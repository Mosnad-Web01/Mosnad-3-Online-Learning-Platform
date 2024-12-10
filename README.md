This will be for the readme file for both front end and back end

include:
brief about the project
step by step on how to install
contribution guide
team





# Mosnad 3 Online Learning Platform

## Authentication with Sanctum (Laravel & Next.js)

In this project, **Sanctum** has been implemented for API authentication to enable secure communication between the frontend (Next.js) and the backend (Laravel). Below is a summary of how Sanctum has been configured and how it works with both frameworks.

### 1. Sanctum Setup in Laravel

- **Installed Sanctum**: Sanctum was installed using the following command:
  ```bash
  composer require laravel/sanctum
  php artisan install:api
  php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
  php artisan migrate

  ```

- **Sanctum Middleware**: Added Sanctum middleware in `api.php` and `web.php` routes to protect API routes.
  
  In `app/Http/Kernel.php`, ensure Sanctum middleware is added:
  ```php
  'api' => [
      \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
      'throttle:api',
      \Illuminate\Routing\Middleware\SubstituteBindings::class,
  ],
  ```

- **Sanctum Authentication**: Set up routes for issuing API tokens. These include endpoints for login and logout.

  Example for issuing tokens:
  ```php
  Route::post('/login', [WebAuthController::class, 'login'])->name('login');
  ```

### 2. Sanctum Setup in Next.js

- **CSRF Token Handling**: In the frontend (Next.js), ensure that the CSRF token is retrieved before making any requests. This is handled by calling a specific route in Laravel that returns the CSRF cookie.
  
  Example:
  ```js
  const getCSRFToken = async () => {
    await axios.get('http://localhost:8000/sanctum/csrf-cookie');
  };
  ```

- **Login API Call**: The frontend sends login requests with credentials to Laravel, and upon successful login, a token is issued and stored in local storage or cookies.

  Example:
  ```js
  const loginUser = async (credentials) => {
    await axios.post('http://localhost:8000/login', credentials);
  };
  ```

- **Authorization with Axios**: After receiving the token, all future requests are authenticated by attaching the token in the `Authorization` header.

  Example:
  ```js
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
  ```

### 3. Handling Authentication and Authorization

- **Protecting Routes**: For secure API routes, use `auth:sanctum` middleware in Laravel to ensure that only authenticated users can access certain endpoints.

  Example:
  ```php
  Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
      return $request->user();
  });
  ```

- **Logout**: To log out, simply delete the Sanctum token on both the backend (Laravel) and the frontend (Next.js).

  Laravel logout route:
  ```php
  Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
  ```

### 4. Next.js API Requests

- Ensure that **Axios** or any other HTTP client is set up to handle authentication tokens for every request after login.
  
  Example Axios setup:
  ```js
  axios.defaults.baseURL = 'http://localhost:8000/api/';
  axios.defaults.withCredentials = true;  // Enable cookies to be sent
  ```

### 5. Conclusion

This setup allows seamless authentication between the Laravel backend and the Next.js frontend using **Sanctum**. CSRF protection, token management, and secure routes are all handled appropriately for a robust and secure authentication system.
