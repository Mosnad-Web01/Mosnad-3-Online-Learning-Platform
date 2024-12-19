<x-layout>
    <div class="container">
        <h2>Your Profile</h2>

        <div class="profile-details">
            <p><strong>Name:</strong> {{ $profile->full_name }}</p>
            <p><strong>Date of Birth:</strong> {{ $profile->date_of_birth }}</p>
            <p><strong>Address:</strong> {{ $profile->address }}</p>
            <p><strong>Phone Number:</strong> {{ $profile->phone_number }}</p>
            <p><strong>Bio:</strong> {{ $profile->bio }}</p>

            @if ($profile->profile_picture)
                <img src="{{ Storage::url($profile->profile_picture) }}" alt="Profile Picture" width="150">
            @else
                <p>No profile picture</p>
            @endif
        </div>
        
        <a href="{{ route('profile.edit', $profile->id) }}" class="btn btn-primary">Edit Profile</a>
    </div>
</x-layout>
