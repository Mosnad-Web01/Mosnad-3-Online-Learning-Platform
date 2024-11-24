// components/ImageUpload.js
import React, { useState } from 'react';

const ImageUpload = ({ userId, onImageUpload }) => {
  const [image, setImage] = useState(null);
  const [loading, setLoading] = useState(false);

  const handleImageChange = (e) => {
    setImage(e.target.files[0]);
  };

  const handleImageUpload = async () => {
    const formData = new FormData();
    formData.append('image', image);

    try {
      setLoading(true);
      const response = await fetch(`http://127.0.0.1:8000/api/user-profile/${userId}/upload-image`, {
        method: 'POST',
        body: formData,
      });
      const result = await response.json();
      setLoading(false);

      if (response.ok) {
        onImageUpload(result.imageUrl); // يتم استدعاء دالة على مستوى الواجهة لتمرير الرابط
      } else {
        alert('حدث خطأ أثناء رفع الصورة.');
      }
    } catch (error) {
      setLoading(false);
      console.error(error);
      alert('حدث خطأ أثناء رفع الصورة.');
    }
  };

  return (
    <div>
      <input type="file" onChange={handleImageChange} />
      <button onClick={handleImageUpload} disabled={loading}>
        {loading ? 'جاري التحميل...' : 'رفع الصورة'}
      </button>
    </div>
  );
};

export default ImageUpload;
