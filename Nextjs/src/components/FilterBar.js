'use client';

import React from 'react';

const FilterBar = ({ onFilterChange }) => {
  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
      <select 
        onChange={(e) => onFilterChange('time', e.target.value)} 
        className="p-2 border rounded w-full"
      >
        <option value="">Time</option>
        <option value="recent">Most Recent</option>
        <option value="old">Oldest</option>
      </select>
      <select 
        onChange={(e) => onFilterChange('level', e.target.value)} 
        className="p-2 border rounded w-full"
      >
        <option value="">Level</option>
        <option value="1">Beginner</option>
        <option value="2">Intermediate</option>
        <option value="3">Advanced</option>
      </select>
      <select 
        onChange={(e) => onFilterChange('language', e.target.value)} 
        className="p-2 border rounded w-full"
      >
        <option value="">Language</option>
        <option value="english">English</option>
        <option value="spanish">Spanish</option>
        <option value="french">French</option>
      </select>
      <select 
        onChange={(e) => onFilterChange('category', e.target.value)} 
        className="p-2 border rounded w-full"
      >
        <option value="">Category</option>
        <option value="1">Programming</option>
        <option value="2">Design</option>
        <option value="3">Languages</option>
      </select>
    </div>
  );
};

export default FilterBar;
