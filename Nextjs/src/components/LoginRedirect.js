'use client'; 

import { useRouter } from 'next/navigation'; 

const LoginRedirect = () => {
  const router = useRouter();

  const redirectToLogin = () => {
    router.push('/login'); 
  };

  return (
    <button
      className="bg-blue-500 text-white p-2 rounded mt-4"
      onClick={redirectToLogin}
    >
      Log in now
    </button>
  );
};

export default LoginRedirect;
