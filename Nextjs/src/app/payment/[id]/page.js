"use client";
import React, { useState, useEffect } from 'react';
import { useParams } from 'next/navigation'; // لاسترجاع المعرف من الرابط
import { fetchCourseById } from '@/services/api'; // API function to fetch course by ID

const PaymentPage = () => {
  const { id } = useParams(); // Get the course ID from the URL
  const [course, setCourse] = useState(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  const [amount, setAmount] = useState('');
  const [userId, setUserId] = useState(''); // سيتم تحديده تلقائيًا
  const [status] = useState('pending'); // سيتم تحديده تلقائيًا
  const [paymentDate] = useState(new Date().toISOString()); // سيتم تحديده تلقائيًا
  const [loading, setLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState(null);

  useEffect(() => {
    const fetchCourseDetails = async () => {
      try {
        const response = await fetchCourseById(id); // Fetch the course data
        setCourse(response.data);
        setAmount(response.data.price); // Set the price from the course details
      } catch (err) {
        setError('Error fetching course details.');
      } finally {
        setIsLoading(false);
      }
    };

    fetchCourseDetails();
  }, [id]); // Reload when the course ID changes

  const handlePayment = async (e) => {
    e.preventDefault();

    setLoading(true);
    setErrorMessage(null);

    try {
      // Sending payment data using API call
      const response = await createPayment({
        user_id: userId, // سيتم تحديده تلقائيًا
        course_user_id: id, // سيتم تحديده تلقائيًا من URL
        amount: amount,
        status: status, // سيتم تحديده تلقائيًا
        payment_date: paymentDate, // سيتم تحديده تلقائيًا
      });

      if (response.status === 201) {
        // Success, update UI
        alert('Payment Successful!');
      }
    } catch (err) {
      setErrorMessage('An error occurred while processing the payment. Please try again.');
    } finally {
      setLoading(false);
    }
  };

  if (isLoading) return <p>Loading...</p>;
  if (error) return <p>{error}</p>;

  return (
    <div className="payment-page bg-white p-8">
      <h1 className="text-3xl font-bold mb-4">Course Payment</h1>
      {course ? (
        <>
          <h2 className="text-xl">{course.course_name}</h2>
          <p>Price: ${course.price}</p>
          <p>{course.description}</p>

          {/* Payment form */}
          <div className="payment-details mt-6">
            <h3 className="text-lg font-semibold">Payment Details</h3>
            <form onSubmit={handlePayment}>
              <div className="mb-4">
                <label htmlFor="amount" className="block mb-1">Amount</label>
                <input
                  type="number"
                  id="amount"
                  value={amount}
                  onChange={(e) => setAmount(e.target.value)}
                  className="w-full p-2 border rounded"
                  required
                />
              </div>

              {/* Hidden fields */}
              <input type="hidden" id="courseUserId" value={id} /> {/* Course ID */}
              <input type="hidden" id="userId" value={userId} /> {/* User ID */}

              {/* Payment form fields */}
              <div className="mb-4">
                <label htmlFor="cardNumber" className="block mb-1">Card Number</label>
                <input
                  type="text"
                  id="cardNumber"
                  className="w-full p-2 border rounded"
                  required
                />
              </div>

              <div className="mb-4">
                <label htmlFor="expiry" className="block mb-1">Expiry Date</label>
                <input
                  type="text"
                  id="expiry"
                  className="w-full p-2 border rounded"
                  required
                />
              </div>

              <div className="mb-4">
                <label htmlFor="cvv" className="block mb-1">CVV</label>
                <input
                  type="text"
                  id="cvv"
                  className="w-full p-2 border rounded"
                  required
                />
              </div>

              <button
                type="submit"
                className="w-full p-2 bg-blue-500 text-white rounded"
                disabled={loading}
              >
                {loading ? 'Processing...' : 'Complete Payment'}
              </button>
            </form>
          </div>
        </>
      ) : (
        <p>No course found.</p>
      )}

      {errorMessage && <p className="text-red-500 mt-4">{errorMessage}</p>}
    </div>
  );
};

export default PaymentPage;
