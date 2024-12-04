import axios from 'axios';
import { getCsrfToken } from './csrf';

const API_URL = 'http://127.0.0.1:8000/api';

export const registerUser = async (userData) => {
  await getCsrfToken(); // طلب التوكن CSRF
  const response = await axios.post(`${API_URL}/register`, userData, {
    withCredentials: true, // السماح بإرسال الكوكيز
  });
  return response.data;
};

export const loginUser = async (credentials) => {
  await getCsrfToken(); // طلب التوكن CSRF
  const response = await axios.post(`${API_URL}/login`, credentials, {
    withCredentials: true, // السماح بإرسال الكوكيز
  });
  return response.data;
};
