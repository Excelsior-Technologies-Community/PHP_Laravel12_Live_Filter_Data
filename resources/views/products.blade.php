<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Product Filter - Laravel 12 + Livewire</title>
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
                    <p class="text-gray-600">Laravel 12 + Livewire 3 Demo</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/" 
                       class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->is('/') ? 'text-blue-600 font-medium' : '' }}">
                        Home
                    </a>
                    <a href="/products" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Live Filter
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Livewire Component -->
    <div class="min-h-screen">
        @livewire('product-filter')
    </div>

    @livewireScripts
</body>
</html>