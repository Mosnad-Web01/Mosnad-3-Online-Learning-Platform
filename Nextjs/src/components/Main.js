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
        setRandomImage(`/images_show/${data[randomIndex]}`); 
      });
  }, []);

  return (
    <div className="relative py-32 px-4 sm:px-6 lg:px-8" style={{ height: '100vh' }}>
      {randomImage && (
        <div className="absolute top-0 left-0 w-full h-full overflow-hidden">
          <Image
            src={randomImage}
            alt="Random background"
            layout="fill" 
            objectFit="cover"
            className="w-full h-full"
          />
        </div>
      )}
    </div>
  );
};

export default Main;
