<x-layout>

<h1>Edit Review</h1>

<form action="{{ route('reviews.update', $review->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="course_id">Course:</label>
    <select name="course_id" id="course_id" required>
        @foreach ($courses as $course)
            <option value="{{ $course->id }}" 
                {{ $review->course_id == $course->id ? 'selected' : '' }}>
                {{ $course->course_name }}
            </option>
        @endforeach
    </select>

    <label for="instructor_id">Instructor:</label>
    <select name="instructor_id" id="instructor_id" required>
        @foreach ($instructors as $instructor)
            <option value="{{ $instructor->id }}" 
                {{ $review->instructor_id == $instructor->id ? 'selected' : '' }}>
                {{ $instructor->name }}
            </option>
        @endforeach
    </select>

    <label for="course_rating">Course Rating (1-5):</label>
    <input type="number" name="course_rating" id="course_rating" min="1" max="5" 
        value="{{ $review->course_rating }}" required>

    <label for="instructor_rating">Instructor Rating (1-5):</label>
    <input type="number" name="instructor_rating" id="instructor_rating" min="1" max="5" 
        value="{{ $review->instructor_rating }}" required>

    <label for="review_text">Review:</label>
    <textarea name="review_text" id="review_text" rows="4">{{ $review->review_text }}</textarea>

    <button type="submit">Update Review</button>
</form>

</x-layout>