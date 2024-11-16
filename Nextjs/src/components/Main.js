"use client";
import React, { useEffect, useState } from 'react';
import Image from 'next/image';
import { useRouter } from 'next/navigation';

const Main = () => {
  const [randomImage, setRandomImage] = useState('');
  const router = useRouter();

  useEffect(() => {
    fetch('/imageList.json')
      .then(response => response.json())
      .then(data => {
        const randomIndex = Math.floor(Math.random() * data.length);
        setRandomImage(`/images_show/${data[randomIndex]}`); // تحديث الصورة العشوائية
      });
  }, []);

  return (
    <div className="relative py-32 px-4 sm:px-6 lg:px-8" style={{ height: '100vh' }}> {/* زيادة ارتفاع الصورة */}
      {randomImage && (
        <Image
          src={randomImage}
          alt="Random background"
          layout="fill"
          objectFit="cover"
          className="absolute top-0 left-0 z-0"
        />
      )}
      
    </div>
  );
};

export default Main;
