import Image from 'next/image';

const LessonImage = () => {
  return (
    <div>
      <Image
        src="http://localhost:8000/storage/lessons/images/jagQglLgY9dmZsJmx9FFMviYyn7BWmkauAnK9wpo.png"
        alt="Lesson Image"
        width={500}
        height={300}
      />
    </div>
  );
};

export default LessonImage;
