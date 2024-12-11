"use client";
import i18n from "@/lib/i18n";
import { useEffect, useState } from "react";

export default function ClientWrapper({ children }) {
  const [language, setLanguage] = useState("ar");

  useEffect(() => {
    if (typeof window !== "undefined") {
      setLanguage("ar");
      i18n.changeLanguage("ar");
      document.documentElement.lang = "ar";
      document.body.dir = "rtl";
    }
  }, []);

  return <div lang={language}>{children}</div>;
}
