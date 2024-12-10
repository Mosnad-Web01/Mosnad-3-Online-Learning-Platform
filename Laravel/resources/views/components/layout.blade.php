
<x-base>
<!-- <div class="grid h-screen grid-rows-[auto_1fr_auto] grid-cols-[auto_1fr] lg:grid-cols-[250px_1fr]"> -->
            <!-- Navbar and Sidebar -->
                <x-navbar />

            <!-- Main Content -->
                {{ $slot }}

            <!-- Footer -->
                <x-footer />
            </footer>
        </div>
</x-base>
