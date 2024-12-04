// src/app/layout.js
import localFont from "next/font/local";
import "./globals.css";
import Navbar from "../components/Navbar";  // استيراد الناف بار
import Footer from "../components/Footer";  // استيراد الفوتر

const geistSans = localFont({
  src: "./fonts/GeistVF.woff",
  variable: "--font-geist-sans",
  weight: "100 900",
});
const geistMono = localFont({
  src: "./fonts/GeistMonoVF.woff",
  variable: "--font-geist-mono",
  weight: "100 900",
});

export const metadata = {
  title: "Create Next App",
  description: "Generated by create next app",
};

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body className={`${geistSans.variable} ${geistMono.variable} antialiased`}>
        {/* إضافة ناف بار هنا */}
        <Navbar />
        
        <main className="flex-grow p-0">
          {children}
        </main>

        {/* إضافة الفوتر هنا */}
        <Footer />
      </body>
    </html>
  );
}
