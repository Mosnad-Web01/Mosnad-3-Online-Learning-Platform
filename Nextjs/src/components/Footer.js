"use client";

import { FaFacebook, FaTwitter, FaInstagram, FaLinkedin } from 'react-icons/fa';
import dynamic from 'next/dynamic';

//  dynamic لتأخير تحميل `react-scroll` لتجنب التعارض
const ScrollLink = dynamic(() => import('react-scroll').then((mod) => mod.Link), { ssr: false });

const Footer = () => {
  return (
    <footer className="bg-gray-200 dark:bg-gray-900 text-black dark:text-white py-8">
      <div className="container mx-auto px-6">
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
          {/* قسم الروابط الأساسية */}
          <div>
            <h3 className="text-xl font-semibold mb-4">Quick Links</h3>
            <ul>
              <li>
                <ScrollLink to="about" smooth={true} duration={500} className="block py-2 hover:text-gray-700 dark:hover:text-gray-300">
                  About
                </ScrollLink>
              </li>
              <li>
                <ScrollLink to="services" smooth={true} duration={500} className="block py-2 hover:text-gray-700 dark:hover:text-gray-300">
                  Services
                </ScrollLink>
              </li>
              <li>
                <ScrollLink to="contacts" smooth={true} duration={500} className="block py-2 hover:text-gray-700 dark:hover:text-gray-300">
                  Contacts
                </ScrollLink>
              </li>
            </ul>
          </div>

          {/* قسم وسائل التواصل الاجتماعي */}
          <div>
            <h3 className="text-xl font-semibold mb-4">Follow Us</h3>
            <div className="flex space-x-4">
              <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" className="text-gray-700 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                <FaFacebook size={24} />
              </a>
              <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" className="text-gray-700 dark:text-white hover:text-blue-400 dark:hover:text-blue-300">
                <FaTwitter size={24} />
              </a>
              <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" className="text-gray-700 dark:text-white hover:text-pink-600 dark:hover:text-pink-400">
                <FaInstagram size={24} />
              </a>
              <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" className="text-gray-700 dark:text-white hover:text-blue-800 dark:hover:text-blue-600">
                <FaLinkedin size={24} />
              </a>
            </div>
          </div>

          {/* قسم الاتصال */}
          <div>
            <h3 className="text-xl font-semibold mb-4">Contact</h3>
            <p className="text-gray-700 dark:text-gray-300">
              Address: 123 TutorNet Street, Education City
            </p>
            <p className="text-gray-700 dark:text-gray-300">Phone: +1 234 567 890</p>
            <p className="text-gray-700 dark:text-gray-300">Email: contact@tutornet.com</p>
          </div>
        </div>

        {/* حقوق الطبع والنشر */}
        <div className="text-center mt-8">
          <p className="text-sm text-gray-600 dark:text-gray-400">
            &copy; {new Date().getFullYear()} TutorNet. All Rights Reserved.
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
