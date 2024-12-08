"use client"
import {useStripe, useElements, PaymentElement} from '@stripe/react-stripe-js';
import React, { useState } from 'react';
const CheckoutForm = ({amount,studentID,corseId}) => {


        const stripe = useStripe();
        const elements = useElements();
        const [ setErrorMessage] = useState();
        const [ setLoading] = useState(false);

        const handleSubmit = async (event) => {
         
          // We don't want to let default form submission happen here,
          // which would refresh the page.
          event.preventDefault();
          
          if (!stripe || !elements) {
            // Stripe.js hasn't yet loaded.
            // Make sure to disable form s  ubmission until Stripe.js has loaded.
            return;
          }
          const handleError = (error) => {
            setLoading(false);
            setErrorMessage(error.message);
          }



    // Trigger form validation and wallet collection
    const {error: submitError} = await elements.submit();
    if (submitError) {
      handleError(submitError);
      return;
    }

          const res = await fetch(`/api/create-intent`, {
            method: "POST",
            body: JSON.stringify({
              amount: amount,
            }),
          })

          const clientSecret = await res.json();
          const result = await stripe.confirmPayment({
            //`Elements` instance that was used to create the Payment Element
            clientSecret,
            elements,
            confirmParams: {
              return_url: "http://localhost:3000/payment-confirm",
            },
          });
      
          if (result.error) {
            // Show error to your customer (for example, payment details incomplete)
            console.log(result.error.message);
          } else {
                  // قم هنا ببناءاو باستدعاء الدالة التي تقوم باضافة الكورس الى المستخدم لانه سيتم استدعاء الدالة في حالة فقط نجح الشراء والخصم من البطاقة

            // Your customer will be redirected to your `return_url`. For some payment
            // methods like iDEAL, your customer will be redirected to an intermediate
            // site first to authorize the payment, then redirected to the `return_url`.
          }
        };

      


  return (
    <form onSubmit={handleSubmit}>
        <div className='mx-32 md:mx-[320px] mt-12'>

      <PaymentElement />

      <button className='bg-primary text-white px-4 py-2 rounded-md w-full mt-4'>Submit</button>
        </div>
    </form>
  );
};

export default CheckoutForm;