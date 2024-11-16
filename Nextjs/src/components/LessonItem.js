import React from 'react';

const LessonItem = ({ lesson }) => {
  return (
    <div className="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white rounded-lg shadow-lg">
      <h3 className="text-2xl font-semibold">{lesson.title}</h3>
      <p className="text-md mt-2">{lesson.content}</p>

      <div className="mt-4">
        <h4 className="text-xl font-semibold">Lesson Video</h4>
        <video
          controls
          className="w-full mt-2 rounded-lg"
          src={lesson.video_url}
          alt={`Video for ${lesson.title}`}
        />
      </div>
    </div>
  );
};

export default LessonItem;
