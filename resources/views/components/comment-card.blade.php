<!-- resources/views/components/comment-card.blade.php -->
<div class="feedback bg-gray-700 p-6 rounded-lg shadow-inner">
    <div class="flex items-center mb-4">
        <img src="{{ asset($comment->user_image) }}" alt="{{ $comment->user_name }}"
            class="w-12 h-12 rounded-full mr-4 object-cover">
        <div>
            <div class="flex">
                @for ($i = 0; $i < 5; $i++)
                    @if ($i < $comment->rating)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.179c.969 0 1.371 1.24.588 1.81l-3.376 2.455a1 1 0 00-.364 1.118l1.286 3.974c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.376 2.455c-.784.57-1.838-.197-1.539-1.118l1.286-3.974a1 1 0 00-.364-1.118L2.98 9.401c-.783-.57-.38-1.81.588-1.81h4.179a1 1 0 00.951-.69l1.286-3.974z" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.179c.969 0 1.371 1.24.588 1.81l-3.376 2.455a1 1 0 00-.364 1.118l1.286 3.974c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.376 2.455c-.784.57-1.838-.197-1.539-1.118l1.286-3.974a1 1 0 00-.364-1.118L2.98 9.401c-.783-.57-.38-1.81.588-1.81h4.179a1 1 0 00.951-.69l1.286-3.974z" />
                        </svg>
                    @endif
                @endfor
            </div>
            <h3 class="text-lg text-white">{{ $comment->user_name }}</h3>
        </div>
    </div>
    <p class="text-gray-300 mb-4">{{ $comment->review }}</p>
    <p class="text-gray-400 text-sm">hace {{ $comment->created_at->diffForHumans() }}</p>
</div>
