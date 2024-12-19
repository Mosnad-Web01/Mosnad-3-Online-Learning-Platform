"use client"
import React from 'react'
import {Elements} from '@stripe/react-stripe-js';
import {loadStripe} from '@stripe/stripe-js';
import CheckoutForm from './_components/CheckoutForm';
import { useSearchParams } from 'next/navigation';
// Make sure to call `loadStripe` outside of a component’s render to avoid
// recreating the `Stripe` object on every render.
const ky = 'pk_test_51Q9qNKIvLrUosj0mC3WHetzas1d3Ng9OSgjsLD4LjR4iq3WUbY8aJ8Br2AC8mtDw7ppJX81lf7kengLaXzxj4L8v00XIFf6MpE';
const stripePromise = loadStripe( ky );

function Checkout() {

  const stripePromise1 = useSearchParams();
  const amount = Number(stripePromise1.get('amount') ?? 0); //  إذا كانت  amount  غير مُعرّفة،  فاستخدم  0
  const studentID = Number(stripePromise1.get('studentID') ?? 0);
  const corseId = Number(stripePromise1.get('corseId') ?? 0);


    const options ={
        mode: 'payment',
        currency:'usd',
        amount: amount*100,
    }
  return (
    <Elements stripe={stripePromise} options={options}>
        {/* /checkout?amount=20 & studentID=1 & corseId=/1 مثال على الرابط الئي يجب استدعائه. */}
    <CheckoutForm amount={amount} studentID={studentID} corseId={corseId} />
  </Elements>
  )
}

export default Checkout