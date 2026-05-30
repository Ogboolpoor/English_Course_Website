<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English Learning Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center font-sans">

<div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full text-center border border-gray-200">
    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-30 h-24 mx-auto mb-6 opacity-80">

    <h1 class="text-3xl font-bold text-gray-900 mb-2">English Learning Portal</h1>
    <p class="text-gray-500 mb-8">Select your portal to continue</p>

    @if (Route::has('login'))
        @auth
            <a href="{{ url('/dashboard') }}" class="block w-full bg-gray-900 text-white font-bold py-3 rounded mb-4 hover:bg-black transition">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="block w-full border-2 border-gray-900 text-gray-900 font-bold py-3 rounded mb-4 hover:bg-gray-50 transition">
                Log In
            </a>

            <div class="relative flex py-5 items-center">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="flex-shrink-0 mx-4 text-gray-400 text-sm">Or Register</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <a href="{{ route('register', ['role' => 'student']) }}" class="block w-full bg-gray-900 text-white font-bold py-3 rounded mb-3 hover:bg-black transition">
                Register as Student
            </a>

            <a href="{{ route('register', ['role' => 'teacher']) }}" class="block w-full bg-gray-200 text-gray-700 font-bold py-3 rounded hover:bg-gray-300 transition">
                Register as Teacher
            </a>
        @endauth
    @endif
</div>

</body>
</html>
