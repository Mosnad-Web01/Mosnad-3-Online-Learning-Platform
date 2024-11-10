import React from 'react';
import { FaArrowLeft, FaArrowRight } from 'react-icons/fa';

const PaginationButton = ({ onClick, direction, isDisabled, color }) => {
  return (
    <button
      onClick={onClick}
      disabled={isDisabled}
      className={`p-3 rounded-full ${color} ${isDisabled ? 'opacity-50' : 'hover:opacity-80'} transition-all duration-300`}
    >
     
      {direction === 'left' ? <FaArrowLeft className="text-white" /> : <FaArrowRight className="text-white" />}
    </button>
  );
};

export default PaginationButton;
