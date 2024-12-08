# Mosnad 3 Online Learning Platform

Welcome to the Mosnad (Project 3) Online Learning Platform repository! This project combines a Laravel backend with a Next.js frontend to create a comprehensive online learning experience.

## Project Structure

The project consists of two main parts: the Laravel backend and the Next.js frontend. Below is a brief overview of the directory structure:

```
Mosnad-3-Online-Learning-Platform/
├── Laravel/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   └── ...
└── Nextjs/
    ├── public/
    ├── src/
    ├── package.json
    └── ...
```

## Key Features

- Role-based user access (Admin, Instructor, Student)
- Course and lesson management
- Payment integration with Stripe
- Multi-language support (Arabic, English)
- User profile and enrollment system

## Installation Guide

### Prerequisites

Before you begin, ensure you have the following installed on your machine:

- **Node.js** (version 14 or higher)
- **npm** (Node Package Manager)
- **Composer** (for PHP dependency management)
- **PHP** (version 8.0 or higher)
- **MySQL** or another supported database

### Step 1: Clone the Repository

Clone the repository to your local machine using Git:

```bash
git clone https://github.com/Mosnad-Web01/Mosnad-3-Online-Learning-Platform
cd Mosnad-3-Online-Learning-Platform
```

### Step 2: Set Up Laravel Backend

1. Navigate to the Laravel directory:

   ```bash
   cd Laravel
   ```

2. Install PHP dependencies using Composer:

   ```bash
   composer install
   ```

3. Install Node.js dependencies for Vite:

   ```bash
   npm install
   ```

4. Create a `.env` file: Copy the example environment file to create your own:

   ```bash
   cp .env.example .env
   ```

5. Generate application key: Run the following command to generate a unique application key:

   ```bash
   php artisan key:generate
   ```

6. Set up your database:

   - Update your .env file with your database credentials:

   ```js
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. Run migrations and seed the database: Execute the following commands to set up your database schema and seed it with initial data:

   ```bash
   php artisan migrate --seed
   ```

8. Start the Laravel development server: Run this command to start the server:

   ```bash
   php artisan serve
   ```

9. Run Vite for asset compilation: In a separate terminal, run:

   ```bash
   npm run dev
   ```

### Step 3: Set Up Next.js Frontend

1. Navigate to the Next.js directory:

   ```bash
   cd ../Nextjs
   ```

2. Install Node.js dependencies: Use npm to install the necessary packages:

   ```bash
   npm install
   ```

3. Configure axios: go inside `src/services/api.js` file in the Next.js directory and add your API endpoint (adjust according to your backend URL):

   ```js
   const api = axios.create({
     baseURL: "http://localhost:8000/api",
     withCredentials: true,
   });
   ```

4. Start the Next.js development server: Run this command to start the frontend server:

   ```bash
   npm run dev
   ```

### Step 4: Accessing Your Application

Once both servers are running, you can access your application in a web browser at:

- Laravel API: http://localhost:8000
- Next.js Frontend: http://localhost:3000

## Contributing

Contributions are welcome! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/feature-name`).
3. Make your changes and commit (`git commit -m 'feat(scope): Add new feature'`).
4. Push to the branch (`git push origin feature/feature-name`).
5. Create a pull request.

Please ensure your code follows the coding standards, and write tests for new features.
