<div class="relative py-32 px-4 sm:px-6 lg:px-8" style="height: 100vh;">
    @if($randomImage)
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
            <img
                src="{{ asset('images_show/' . $randomImage) }}"
                alt="Random background"
                class="w-full h-full object-cover"
            />
        </div>
    @endif
</div>
