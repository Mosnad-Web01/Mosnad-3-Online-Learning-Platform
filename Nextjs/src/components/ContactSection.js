import React from 'react';

const ContactSection = () => {
  return (
    <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 text-black dark:text-white">
      <div className="text-center mb-12">
        <h2 className="text-4xl font-extrabold text-gray-800 dark:text-white">
          Get in touch with us
        </h2>
      </div>

      <div className="max-w-3xl mx-auto text-center">
        <p className="text-lg text-gray-700 dark:text-gray-300 mb-8">
          We&#39;re here to help! Whether you have questions, feedback, or just want to say hello, feel free to reach out to us using the details below.
        </p>

        {/* Flexbox container for the contact details */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 text-lg text-gray-700 dark:text-gray-300">
          <div className="flex flex-col items-center">
            <p className="font-semibold text-xl mb-2">Email</p>
            <p className="text-lg">support@tutornet.com</p>
          </div>
          <div className="flex flex-col items-center">
            <p className="font-semibold text-xl mb-2">Phone</p>
            <p className="text-lg">+1 234 567 890</p>
          </div>
          <div className="flex flex-col items-center">
            <p className="font-semibold text-xl mb-2">Address</p>
            <p className="text-lg text-center">123 TutorNet Lane, Education City, Knowledge State, 12345</p>
          </div>
        </div>

        <div className="mt-8">
          <p className="text-lg text-gray-700 dark:text-gray-300">
            Feel free to reach out to us anytime. We&#39;re always happy to hear from you!
          </p>
        </div>
      </div>
    </section>
  );
};

export default ContactSection;
