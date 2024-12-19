<!-- views/reviews/replies.blade.php -->
@if ($reviews->isNotEmpty())
    <ul class="list-disc pl-{{ $level * 5 }} mb-4"> <!-- Increase padding for nested replies -->
        @foreach ($reviews as $review)
        <li>
            <strong>{{ $review->user->name }}:</strong> {{ $review->reply_text }}

            <!-- Nested replies -->
            @include('replies.replyToReply', ['reviews' => $review->replies, 'level' => $level + 1]) <!-- Recursively display replies -->
            
            <!-- Option to toggle reply form -->
            <button onclick="toggleReplyBox({{ $review->id }})" class="ml-2 text-blue-500 hover:text-blue-600">Reply</button>

            <div id="reply-box-{{ $review->id }}" style="display: none;" class="mt-2">
                <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                    @csrf
                    <textarea name="reply_text" placeholder="Write a reply..." class="w-full border p-2 mt-2" rows="2"></textarea>
                    <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 mt-2">Reply</button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>
@endif
