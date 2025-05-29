<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Studio Karya Kita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url('images/images1.png') center/cover no-repeat,
                  url('images/images7.png') center/cover no-repeat,
                  url('images/images1.png') center/cover no-repeat;
      background-size: cover;
      transition: background 1s ease-in-out;
    }

    .register-container {
      background: rgba(255, 255, 255, 0.8);
      padding: 40px;
      width: 100%;
      max-width: 400px;
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      transition: background 1s ease-in-out;
    }

    .register-container:hover {
      background: rgba(255, 255, 255, 0.9);
    }

    .register-container h2 {
      font-family: 'Arial', sans-serif;
      font-size: 2.5rem;
      color: #333;
      margin-bottom: 20px;
      text-align: center;
    }

    .form-label {
      font-weight: bold;
      color: #333;
    }

    .form-control {
      border-radius: 8px;
      height: 45px;
      font-size: 1rem;
      padding: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
      border-color: #6b8fbd;
      box-shadow: 0 0 5px rgba(107, 143, 189, 0.5);
    }

    .btn-register {
      width: 100%;
      padding: 12px;
      background-color: #4c6d96;
      color: white;
      font-size: 1.2rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-register:hover {
      background-color: #3b4f6d;
    }

    .text-center {
      text-align: center;
    }

    .text-sm {
      font-size: 0.9rem;
    }

    .text-muted {
      color: #6c757d;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border-color: #c3e6cb;
      border-radius: 5px;
      padding: 10px;
    }

    .mt-3 {
      margin-top: 1rem;
    }

    .mt-5 {
      margin-top: 3rem;
    }

    .forgot-password,
    .register-link {
      color: #6b8fbd;
      text-decoration: none;
    }

    .forgot-password:hover,
    .register-link:hover {
      text-decoration: underline;
    }

    /* Logo Styling */
    .logo {
      max-width: 120px;
      margin-bottom: 20px;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="register-container">
    <!-- Logo -->
    <img src="images/logo2.png" alt="Logo" class="logo">

    <h2>Register</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        @error('email')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
        @error('phone')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="user_role" class="form-label">Select Role</label>
        <select id="user_role" name="user_role" class="form-select" required>
          <option value="" disabled selected>Choose your role</option>
          <option value="admin" {{ old('user_role') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="staff" {{ old('user_role') == 'staff' ? 'selected' : '' }}>Staff</option>
          <option value="freelance" {{ old('user_role') == 'freelance' ? 'selected' : '' }}>Freelance Photographer</option>
        </select>
        @error('user_role')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-control" name="password" required>
        @error('password')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
      </div>

      <button type="submit" class="btn btn-register">Register</button>
    </form>

    <p class="mt-3 text-center text-sm text-muted">
      Already have an account? <a href="{{ route('login') }}" class="register-link">Login here</a>
    </p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
