import React from 'react';

const LessonItem = ({ lesson }) => {
  return (
    <div className="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white rounded-lg shadow-lg">
      <h3 className="text-2xl font-semibold">{lesson.title}</h3>
      <p className="text-md mt-2">{lesson.content}</p>

      {/* عرض الفيديو */}
      {lesson.video_url && (
        <div className="mt-4">
          <h4 className="text-xl font-semibold">Lesson Video</h4>
          <video
            controls
            className="w-full mt-2 rounded-lg"
            src={lesson.video_url}
            alt={`Video for ${lesson.title}`}
          />
        </div>
      )}

      {/* عرض الصور */}
      {lesson.images && lesson.images.length > 0 && (
        <div className="mt-4">
          <h4 className="text-xl font-semibold">Lesson Images</h4>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
            {lesson.images.map((image, index) => (
              <img
                key={index}
                className="w-full h-auto rounded-lg shadow-md"
                src={image}
                alt={`Image ${index + 1} for ${lesson.title}`}
              />
            ))}
          </div>
        </div>
      )}

      {/* عرض الملفات */}
      {lesson.files && lesson.files.length > 0 && (
        <div className="mt-4">
          <h4 className="text-xl font-semibold">Lesson Files</h4>
          <ul className="list-disc pl-5 mt-2">
            {lesson.files.map((file, index) => (
              <li key={index}>
                <a
                  href={file}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="text-blue-500 hover:underline"
                >
                  Download File {index + 1}
                </a>
              </li>
            ))}
          </ul>
        </div>
      )}
    </div>
  );
};

export default LessonItem;
