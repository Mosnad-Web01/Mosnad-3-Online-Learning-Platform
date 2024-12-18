@if ($replies && $replies->isNotEmpty())
    @foreach ($replies as $reply)
        <div class="ml-6 border-l-2 border-gray-300 pl-4">
            <strong>{{ $reply->user?->name ?? 'Unknown User' }}:</strong>
            {{ $reply->reply_text ?? 'No reply text available' }}

            <!-- Nested Replies -->
            @if ($reply->replies && $reply->replies->isNotEmpty())
                <div class="mt-2">
                    @include('replies.renderReplies', ['replies' => $reply->replies])
                </div>
            @endif
        </div>
    @endforeach
@else
    <p class="text-gray-500">No replies available.</p>
@endif
