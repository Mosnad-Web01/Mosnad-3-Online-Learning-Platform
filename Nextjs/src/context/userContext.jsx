// src/context/userContext.js
"use client";

import { createContext, useState, useContext } from "react";

// إنشاء سياق المستخدم
const UserContext = createContext(null);

// مكون المزود (Provider) لإدارة الحالة
export const UserProvider = ({ children }) => {
  const [user, setUser] = useState(null); // حالة المستخدم

  return (
    <UserContext.Provider value={{ user, setUser }}>
      {children}
    </UserContext.Provider>
  );
};

// هوك مخصص للوصول إلى سياق المستخدم
export const useUser = () => {
  const context = useContext(UserContext);
  if (!context) {
    throw new Error("useUser must be used within a UserProvider");
  }
  return context;
};
