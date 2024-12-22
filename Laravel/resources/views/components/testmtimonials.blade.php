<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-wrap -m-4">
      @foreach($reviews as $review)
      <div class="lg:w-1/3 lg:mb-0 mb-6 p-4">
        <div class="h-full text-center">
          <img alt="testimonial" 
               class="w-20 h-20 mb-8 object-cover object-center rounded-full inline-block border-2 border-gray-200 bg-gray-100" 
               src="{{ $review->student->profile_picture ?? 'https://via.placeholder.com/100' }}">
          <p class="leading-relaxed">{{ $review->review_text }}</p>
          <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-6 mb-4"></span>
          <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">
            {{ $review->student->name ?? 'Anonymous' }}
          </h2>
          <p class="text-gray-500">{{ $review->student->job_title ?? 'No Title' }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
