<footer2 class="bg-gray-200 dark:bg-gray-900 text-black dark:text-white py-8">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        {{-- قسم الروابط الأساسية --}}
        <div>
          <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
          <ul>
            <li>
              <a href="#about" class="block py-2 hover:text-gray-700 dark:hover:text-gray-300">
                About
              </a>
            </li>
            <li>
              <a href="#services" class="block py-2 hover:text-gray-700 dark:hover:text-gray-300">
                Services
              </a>
            </li>
            <li>
              <a href="#contacts" class="block py-2 hover:text-gray-700 dark:hover:text-gray-300">
                Contacts
              </a>
            </li>
          </ul>
        </div>

        {{-- قسم وسائل التواصل الاجتماعي --}}
        <div>
          <h3 class="text-xl font-semibold mb-4">Follow Us</h3>
          <div class="flex space-x-4">
            <a href="https://facebook.com/tutornet" target="_blank" rel="noopener noreferrer" class="text-gray-700 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
              </svg>
            </a>
            <a href="https://twitter.com/tutornet" target="_blank" rel="noopener noreferrer" class="text-gray-700 dark:text-white hover:text-blue-400 dark:hover:text-blue-300">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M8 19c6.627 0 10.293-5.49 10.293-10.25 0-.155 0-.309-.01-.463A7.326 7.326 0 0020 6.293a7.066 7.066 0 01-2.02.557 3.667 3.667 0 001.605-2.018A7.221 7.221 0 0117.865 5a3.628 3.628 0 00-6.176 3.309A10.3 10.3 0 015 6.368a3.628 3.628 0 001.127 4.845 3.606 3.606 0 01-1.64-.443v.044a3.625 3.625 0 002.91 3.559 3.632 3.632 0 01-.946.126 3.576 3.576 0 01-.686-.067 3.627 3.627 0 003.389 2.522A7.262 7.262 0 015 18.086 10.267 10.267 0 008 19z" />
              </svg>
            </a>

          </div>
        </div>

        {{-- قسم الاتصال --}}
        <div>
          <h3 class="text-xl font-semibold mb-4">Contact</h3>
          <p class="text-gray-700 dark:text-gray-300">
            Address: 123 TutorNet Street, Sana’a, Yemen
          </p>
          <p class="text-gray-700 dark:text-gray-300">Phone: +967 77 123 4567</p>
          <p class="text-gray-700 dark:text-gray-300">Email: support@tutornet.com</p>
        </div>
      </div>

      {{-- حقوق الطبع والنشر --}}
      <div class="text-center mt-8">
        <p class="text-sm text-gray-600 dark:text-gray-400">
          &copy; {{ now()->year }} {{ config('app.name', 'TutorNet') }}. All Rights Reserved.
        </p>
      </div>
    </div>
  </footer2>
