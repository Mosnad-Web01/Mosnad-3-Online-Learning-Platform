<x-layout>
    <section class="py-16 px-4 sm:px-0 dark:bg-gray-900 min-h-screen flex items-center justify-center">
        <div class="relative flex flex-col items-center justify-center w-full">
            <div class="max-w-3xl text-center">
                
                <div class="pb-4">
                    <span class="inline-flex items-center rounded-2xl bg-lime-100 px-4 py-1.5 text-xs sm:text-sm font-serif font-medium text-lime-700">Create your profile with ease.</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-semibold text-gray-600 xl:text-6xl font-serif !leading-tight">
                    {{ $profile ? 'Edit Profile' : 'Create Profile' }}
                </h1>
                <p class="mt-4 text-lg sm:text-xl leading-8 text-gray-600 sm:px-16" style="white-space: pre-line;">
                    {{ $profile ? 'Update your profile details' : 'Enter your profile details' }}
                </p>

                <form action="{{ $profile ? route('profile.update', $profile->id) : route('profile.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-4 w-full">
                    @csrf
                    @if($profile)
                        @method('PUT')
                    @endif

  

                    <!-- Profile and Cover Image -->
                    <div class="w-full rounded-sm bg-[url('{{ $profile->cover_picture ?? 'https://images.unsplash.com/photo-1449844908441-8829872d2607?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHw2fHxob21lfGVufDB8MHx8fDE3MTA0MDE1NDZ8MA&ixlib=rb-4.0.3&q=80&w=1080' }}')] bg-cover bg-center bg-no-repeat items-center">
                        <!-- Profile Image -->
                        <div class="mx-auto flex justify-center w-[141px] h-[141px] bg-blue-300/20 rounded-full bg-[url('{{ $profile->profile_picture ?? 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHw4fHxwcm9maWxlfGVufDB8MHx8fDE3MTEwMDM0MjN8MA&ixlib=rb-4.0.3&q=80&w=1080' }}')] bg-cover bg-center bg-no-repeat">
                            
                            <div class="bg-white/90 rounded-full w-10 h-10 text-center ml-28 mt-4">
                            <img src="{{ $profile && $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : 'https://via.placeholder.com/80' }}" alt="Profile Picture" class="w-full h-full rounded-full object-cover">

                                <input type="file" name="profile_picture" id="upload_profile" hidden>
                                <label for="upload_profile">

                                    <svg class="w-6 h-5 text-blue-700" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"></path>
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>


                    <!-- Personal Information -->
                    <div class="flex gap-4 justify-center w-full">
                        <div class="w-full mb-4">
                            <label for="full_name" class="mb-2 dark:text-gray-300">Full Name</label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $profile->full_name ?? '') }}" class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800" placeholder="Full Name" required>
                        </div>
                    </div>

                    <div class="flex gap-4 justify-center w-full">
                        <div class="w-full">
                            <label for="date_of_birth" class="mb-2 dark:text-gray-300">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}" class="text-grey p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800" required>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="flex gap-4 justify-center w-full">
                        <div class="w-full">
                            <label for="address" class="mb-2 dark:text-gray-300">Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $profile->address ?? '') }}" class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800" placeholder="Address" required>
                        </div>
                        <div class="w-full">
                            <label for="phone_number" class="mb-2 dark:text-gray-300">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $profile->phone_number ?? '') }}" class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800" placeholder="Phone Number" required>
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="w-full mb-4 mt-6">
                        <label for="bio" class="mb-2 dark:text-gray-300">Bio</label>
                        <textarea name="bio" id="bio" class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800" placeholder="Tell us about yourself">{{ old('bio', $profile->bio ?? '') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="w-full rounded-lg bg-blue-500 mt-4 text-white text-lg font-semibold">
                        <button type="submit" class="w-full p-4">{{ $profile ? 'Update Profile' : 'Create Profile' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout>
