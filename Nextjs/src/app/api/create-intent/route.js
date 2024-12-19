import { NextResponse } from "next/server";
import Stripe from "stripe";



const stripeSecretKey = 'sk_test_51Q9qNKIvLrUosj0m8oLnBQbGhiILi5njBBO4NrK0JNILQ06UDne5jOzXBR7JdreVPPxNryqHb6s2gzUoMfm8764i00TLKsJEss';

const stripe = new Stripe(stripeSecretKey, {
    typescript: true,
    apiVersion: "2023-08-16"
});


// const stripe = new Stripe(process.env.STRIPE_SECRET_KEY, {
//   typescript: true,
//   apiVersion: "2023-08-16",
// });

export async function POST(request) {
  const date = await request.json();
  const amount = date.amount;
  try {
    const paymentIntent = await stripe.paymentIntents.create({
      amount: Number(amount) * 100,
      currency: "usd",
    });
    return NextResponse.json(paymentIntent.client_secret, { status: 200 });
  } catch (err) {
    if (err instanceof Error) {
      return NextResponse.json(err.message, { status: 400 });
    } else {
      // Handle the case where err is not an instance of Error
      return NextResponse.json("An unknown error occurred", { status: 400 });
    }
  }
}
