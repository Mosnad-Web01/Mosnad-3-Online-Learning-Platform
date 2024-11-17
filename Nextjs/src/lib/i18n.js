// lib/i18n.js
import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

// تحميل ملفات الترجمة باستخدام fetch
const loadTranslations = async () => {
  const en = await fetch('/locales/en/translation.json').then(res => res.json());
  const ar = await fetch('/locales/ar/translation.json').then(res => res.json());

  i18n
    .use(initReactI18next)
    .init({
      resources: {
        en: { translation: en }, // الترجمة الإنجليزية
        ar: { translation: ar }, // الترجمة العربية
      },
      lng: 'en', // اللغة الافتراضية
      fallbackLng: 'en', // اللغة البديلة في حالة عدم العثور على الترجمة
      interpolation: {
        escapeValue: false, // تعطيل هروب النصوص
      },
    });
};

// استدعاء دالة تحميل الترجمة
loadTranslations();

export default i18n;
