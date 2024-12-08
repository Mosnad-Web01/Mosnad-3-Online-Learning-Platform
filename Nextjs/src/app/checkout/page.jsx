"use client"
import React from 'react'
import {Elements} from '@stripe/react-stripe-js';
import {loadStripe} from '@stripe/stripe-js';
import CheckoutForm from './_components/CheckoutForm';
import { useSearchParams } from 'next/navigation';
// Make sure to call `loadStripe` outside of a component’s render to avoid
// recreating the `Stripe` object on every render.
const stripePromise = loadStripe( process.env.NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY );
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
        {/* /checkout?amount=?? & studentID=?? & corseId=/?? مثال على الرابط الئي يجب استدعائه. */}
    <CheckoutForm amount={amount} studentID={studentID} corseId={corseId} />
  </Elements>
  )
}

export default Checkout