import React from 'react';
import Image from 'next/image'; 

const UserPanel = ({ user, onlineUsers }) => {
  if (!user) {
    return <div>Loading...</div>; 
  }

  return (
    <div className="w-1/4 p-5">
      <div className="flex items-center gap-4 mb-6">
        <Image
          src={user.profilePic || '/images/default-profile.png'} 
          alt={user.name}
          width={40} 
          height={40} 
          className="rounded-full"
        />
        <div>
          <h3 className="text-lg font-semibold">{user.name}</h3>
          <p className="text-gray-500">{user.id}</p>
        </div>
      </div>
      <h4 className="text-md font-semibold mb-4">Online Users</h4>
      <ul className="space-y-2">
        {onlineUsers.map((u, idx) => (
          <li key={idx} className="flex items-center gap-3">
            <Image
              src={u.profilePic || '/images/default-profile.png'} 
              alt={u.name}
              width={32} 
              height={32} 
              className="rounded-full"
            />
            <p>{u.name}</p>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default UserPanel;
