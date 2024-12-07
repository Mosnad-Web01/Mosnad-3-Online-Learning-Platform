/** @type {import('next').NextConfig} */
const nextConfig = {
    images: {
      domains: ['via.placeholder.com'],
      remotePatterns: [
        {
          protocol: 'http',
          hostname: 'localhost',
          port: '8000', // المنفذ المستخدم لخادم Laravel
          pathname: '/storage/**', // مسار الصور المسموح به
        },
      ],
    },
  };
  
  export default nextConfig;
  