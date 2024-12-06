// src/app/page.js
import React from 'react';
import Main from '../components/Main';
import CourseSection from '../components/CourseSection';
import About from '../components/About';
import ContactSection from '../components/ContactSection';
async function HomePage() {
 
  return (
    <>
      <div id="home"><Main /></div>
      <div id="about"><About  /></div>
      <div id="services"><CourseSection  /></div>
      <div id="contacts"><ContactSection /></div>
    </>
  );
}

export default HomePage;
