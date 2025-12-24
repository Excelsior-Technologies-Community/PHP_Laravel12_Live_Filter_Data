<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Filter App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-blue-600">Product Filter</h1>
                    <p class="text-gray-600">Livewire Demo</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/" 
                       class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->is('/') ? 'text-blue-600 font-medium' : '' }}">
                        Home
                    </a>
                    <a href="/products" 
                       class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->is('products') ? 'text-blue-600 font-medium' : '' }}">
                        Products
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>Laravel 12 + Livewire 3 Live Filter Demo</p>
            <p class="text-gray-400 mt-2">© {{ date('Y') }} All rights reserved</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>