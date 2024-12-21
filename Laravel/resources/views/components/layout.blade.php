<x-base>
    <div class="grid grid-rows-[auto_1fr_auto] h-screen">
        <!-- Navbar: شريط علوي وقائمة جانبية -->
        <x-navbar class="lg:row-span-3 lg:col-span-1 bg-gray-800 text-white" />

        <!-- المحتوى الرئيسي -->
        <main class="lg:pl-[160px] bg-white  overflow-y-auto">
            {{ $slot }}
        </main>

        <!-- الفوتر -->
        <x-footer class="row-span-1 col-span-2 bg-gray-800 text-white text-center p-4" />
    </div>
</x-base>
