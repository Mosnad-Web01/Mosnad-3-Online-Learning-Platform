<ul>
    @foreach ($reviews as $review)
    <li class="mb-4 border-b pb-4">
        <!-- Review Info -->
        <div>
            <strong>Student:</strong> {{ $review->student?->name ?? 'Unknown Student' }}<br>
            <strong>Course Rating:</strong> {{ $review->course_rating ?? 'N/A' }} /
            <strong>Instructor Rating:</strong> {{ $review->instructor_rating ?? 'N/A' }}<br>
            <strong>Review:</strong> {{ $review->review_text ?? 'No review text available' }}
        </div>

        <!-- Replies Section -->
        @if (isset($review) && $review && is_object($review))
        <div class="ml-{{ $level * 6 }} border-l-2 border-gray-300 pl-4">
            <strong>{{ $review->user?->name ?? 'Unknown User' }}:</strong>
            {{ $review->review_text ?? 'No review text available' }}

            <!-- Replies Section -->
            @if ($review->replies && $review->replies->isNotEmpty())
            <div class="mt-2">
                @include('replies.replyToReply', ['review' => $review, 'level' => $level + 1])
            </div>
            @endif
        </div>
        @else
        <p class="ml-{{ $level * 6 }} text-gray-500">No replies available.</p>
        @endif


        <!-- Reply Form -->
        <div class="mt-2">
        @if (isset($review) && $review && is_object($review))

            <button onclick="toggleReviewReplyBox({{ $review->id }})" class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600">
                Reply
            </button>
            <form id="review-reply-box-{{ $review->id }}" style="display: none;" action="{{ route('reviews.reply', $review->id) }}" method="POST">
                @csrf
                <textarea name="reply_text" placeholder="Write a reply..." class="w-full border p-2 mt-2" rows="2"></textarea>
                <button type="submit" class="btn btn-primary mt-2">Reply</button>
            </form>
            @else
        <p class="ml-{{ $level * 6 }} text-gray-500">No replies available.</p>
        @endif
        </div>
    </li>
    @endforeach
</ul>

<!-- Nested Reply Blade Template (replies/replyToReply.blade.php) -->
@if (isset($review->replies) && $review->replies->isNotEmpty())
@foreach ($review->replies as $reply)
<div class="ml-{{ $level * 6 }} border-l-2 border-gray-300 pl-4">
    <strong>{{ $reply->user?->name ?? 'Unknown User' }}:</strong>
    {{ $reply->reply_text ?? 'No reply text available' }}

    <!-- Nested Replies -->
    @if ($reply->replies && $reply->replies->isNotEmpty())
    <div class="mt-2">
        @include('replies.replyToReply', ['review' => $reply, 'level' => $level + 1])
    </div>
    @endif
</div>
@endforeach
@else
<p class="ml-{{ $level * 6 }} text-gray-500">No replies available.</p>
@endif

<script>
    function toggleReplies(id) {
        const repliesDiv = document.getElementById(`replies-${id}`);
        repliesDiv.classList.toggle('hidden');
    }

    function toggleReviewReplyBox(id) {
        const replyBox = document.getElementById(`review-reply-box-${id}`);
        replyBox.style.display = replyBox.style.display === 'none' ? 'block' : 'none';
    }
</script>