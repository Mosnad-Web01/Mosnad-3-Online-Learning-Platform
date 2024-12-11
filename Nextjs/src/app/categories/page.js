"use client";
import CategoryCard from "@components/CategoryCard";
import { fetchCategories } from "@services/api";
import { useEffect, useState } from "react";

const CategoriesPage = () => {
  const [categories, setCategories] = useState([]);

  useEffect(() => {
    const fetchCategoryData = async () => {
      try {
        const response = await fetchCategories();
        setCategories(response.data);
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    };

    fetchCategoryData();
  }, []);

  return (
    <div className="bg-white dark:bg-gray-800 text-black dark:text-white min-h-screen py-8 px-4">
      <h1 className="text-3xl font-bold mb-6 text-center">Categories</h1>
      <div className="flex flex-wrap justify-center">
        {categories.length > 0 ? (
          categories.map((category) => (
            <CategoryCard key={category.id} category={category} />
          ))
        ) : (
          <p>No categories available</p>
        )}
      </div>
    </div>
  );
};

export default CategoriesPage;
