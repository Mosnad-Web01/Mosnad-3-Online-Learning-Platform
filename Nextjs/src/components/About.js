import React from 'react';

const About = () => {
  return (
    <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 text-black dark:text-white">
      <div className="text-center">
        <h2 className="text-4xl font-extrabold font-serif mb-4">
          About TutorNet
        </h2>
        <div className="w-full border-b border-gray-300 dark:border-gray-700 mb-6"></div> {/* Gray line */}
        <p className="text-lg max-w-6xl mx-auto">
          Welcome to TutorNet – the online learning platform that connects students with expert instructors, empowering them to learn and grow across a variety of fields.

          At TutorNet, we’re committed to enhancing the learning experience by providing an innovative, user-friendly environment. Teachers can effortlessly design and manage courses, while students enjoy exploring, enrolling, and completing their educational journeys with ease. Whether you’re interested in programming, design, or business, TutorNet offers a comprehensive range of courses tailored to meet diverse interests and skill levels.

          Our platform provides detailed course catalogs, progress tracking, and personalized recommendations, allowing students to access rich learning resources and interact with experienced instructors. Join TutorNet to be part of a unique educational experience, where you can expand your knowledge or share your expertise in an accessible and effective way.
        </p>
      </div>
    </section>
  );
};

export default About;
