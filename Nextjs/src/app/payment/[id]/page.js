"use client";
import React, { useState, useEffect } from "react";
import { useParams } from "next/navigation"; // لاسترجاع معرّف الدورة
import { fetchCourseById, createPayment, fetchCourseUser } from "@/services/api";

const PaymentPage = () => {
  const { id } = useParams(); // Get the course ID from the URL
  const [course, setCourse] = useState(null);
  const [courseUser, setCourseUser] = useState(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  const [amount, setAmount] = useState('');
  const [loading, setLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState(null);

  useEffect(() => {
    const queryParams = new URLSearchParams(window.location.search);
    const studentId = queryParams.get("studentId");

    const fetchDetails = async () => {
      try {
        // Fetch course details
        const courseResponse = await fetchCourseById(id);
        setCourse(courseResponse.data);

        // Fetch CourseUser
        const courseUserResponse = await fetchCourseUser(studentId, id);
        setCourseUser(courseUserResponse.data);

        // Set default amount
        setAmount(courseResponse.data.price);
      } catch (err) {
        setError("Error fetching details.");
      } finally {
        setIsLoading(false);
      }
    };

    fetchDetails();
  }, [id]);

  const handlePayment = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrorMessage(null);

    try {
      const response = await createPayment({
        user_id: courseUser.user_id, // من بيانات التسجيل
        course_user_id: courseUser.id, // من بيانات التسجيل
        amount: amount,
        status: "pending", // الحالة الافتراضية
        payment_date: new Date().toISOString(), // تاريخ الدفع الحالي
      });

      if (response.status === 201) {
        alert("Payment Successful!");
      }
    } catch (err) {
      setErrorMessage("An error occurred while processing the payment.");
    } finally {
      setLoading(false);
    }
  };

  if (isLoading) return <p>Loading...</p>;
  if (error) return <p>{error}</p>;

  return (
    <div className="payment-page bg-white p-8">
      <h1 className="text-3xl font-bold mb-4">Course Payment</h1>
      {course && courseUser ? (
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

              <div className="mb-4">
                <label htmlFor="cardNumber" className="block mb-1">Card Number</label>
                <input type="text" id="cardNumber" className="w-full p-2 border rounded" required />
              </div>

              <div className="mb-4">
                <label htmlFor="expiry" className="block mb-1">Expiry Date</label>
                <input type="text" id="expiry" className="w-full p-2 border rounded" required />
              </div>

              <div className="mb-4">
                <label htmlFor="cvv" className="block mb-1">CVV</label>
                <input type="text" id="cvv" className="w-full p-2 border rounded" required />
              </div>

              <button
                type="submit"
                className="w-full p-2 bg-blue-500 text-white rounded"
                disabled={loading}
              >
                {loading ? "Processing..." : "Complete Payment"}
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
