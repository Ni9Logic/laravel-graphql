<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-blue-600 mb-4 text-center">cool Hello World</h1>
        <p class="text-gray-600 text-center">Tailwind CSS is now working! Not</p>
        <p class="text-yellow-700 text-center">
            Testing Front End Great Work Nice!
        </p>
        <div class="mt-6">
            <h2 class="text-xl font-bold text-gray-800">Registered Users</h2>
            <ul class="mt-2">
                @foreach ($users as $user)
                    <li class="text-gray-700">{{ $user->name }} ({{ $user->email }})</li>
                @endforeach
            </ul>
        </div>
        <div class="mt-6 text-center bg-blue-400">
            <button id="helloBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                Call Hello API
            </button>
            <div id="apiResponse" class="mt-4 p-3 bg-gray-50 rounded hidden">
                <p class="text-sm text-gray-700"></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('helloBtn').addEventListener('click', async function() {
            try {
                const response = await fetch('/hello');
                const data = await response.json();
                
                const responseDiv = document.getElementById('apiResponse');
                const responseText = responseDiv.querySelector('p');
                
                responseText.textContent = `API Response: ${data.message}`;
                responseDiv.classList.remove('hidden');
                
                // Change button text temporarily
                this.textContent = 'Success!';
                this.classList.add('bg-green-500');
                this.classList.remove('bg-blue-500');
                
                setTimeout(() => {
                    this.textContent = 'Call Hello API';
                    this.classList.remove('bg-green-500');
                    this.classList.add('bg-blue-500');
                }, 2000);
                
            } catch (error) {
                console.error('Error calling API:', error);
                
                const responseDiv = document.getElementById('apiResponse');
                const responseText = responseDiv.querySelector('p');
                
                responseText.textContent = 'Error calling API';
                responseDiv.classList.remove('hidden');
                
                // Change button to error state
                this.textContent = 'Error!';
                this.classList.add('bg-red-500');
                this.classList.remove('bg-blue-500');
                
                setTimeout(() => {
                    this.textContent = 'Call Hello API';
                    this.classList.remove('bg-red-500');
                    this.classList.add('bg-blue-500');
                }, 2000);
            }
        });
    </script>
</body>
</html>