import localFont from "next/font/local";
import "./globals.css";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";

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

// تعديل RootLayout للحصول على بيانات المستخدم بشكل غير متزامن
export default async function RootLayout({ children }) {
  // جلب بيانات المستخدم بشكل غير متزامن

  return (
    <html lang="en">
      <body
        className={`${geistSans.variable} ${geistMono.variable} antialiased`}
      >
          {/* تمرير بيانات المستخدم إلى Navbar و UserProvider */}
          <Navbar  />
          <main className="flex-grow p-0">{children}</main>
          <Footer />
      </body>
    </html>
  );
}
