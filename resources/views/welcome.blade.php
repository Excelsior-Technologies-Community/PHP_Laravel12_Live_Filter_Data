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
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-blue-600">Product Filter</h1>
                        <p class="text-gray-600">Laravel 12 + Livewire 3</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="/" 
                           class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->is('/') ? 'text-blue-600 font-medium' : '' }}">
                            Home
                        </a>
                        <a href="/products" 
                           class="px-4 py-2 text-gray-700 hover:text-blue-600 {{ request()->is('products') ? 'text-blue-600 font-medium' : '' }}">
                            Live Filter Demo
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="container mx-auto px-4 py-12">
            <div class="text-center">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Live Product Filter Demo</h2>
                <p class="text-xl text-gray-600 mb-8">Real-time filtering without page refresh using Laravel 12 and Livewire 3</p>
                
                <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Features:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <div class="text-blue-600 text-2xl mb-2">🎨</div>
                            <h4 class="font-bold text-gray-800 mb-2">Color Filter</h4>
                            <p class="text-gray-600">Filter products by color with dropdown</p>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg">
                            <div class="text-green-600 text-2xl mb-2">📂</div>
                            <h4 class="font-bold text-gray-800 mb-2">Category Filter</h4>
                            <p class="text-gray-600">Filter by product category</p>
                        </div>
                        <div class="p-4 bg-yellow-50 rounded-lg">
                            <div class="text-yellow-600 text-2xl mb-2">🔍</div>
                            <h4 class="font-bold text-gray-800 mb-2">Live Search</h4>
                            <p class="text-gray-600">Search products in real-time</p>
                        </div>
                    </div>
                </div>

                <a href="/products" 
                   class="inline-block px-8 py-4 bg-blue-600 text-white text-lg font-medium rounded-lg hover:bg-blue-700 transition transform hover:-translate-y-1">
                    View Live Demo →
                </a>
            </div>
        </div>

        <!-- Instructions -->
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">How It Works</h3>
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <ol class="list-decimal pl-6 space-y-4 text-gray-700">
                        <li class="pb-2">
                            <span class="font-semibold">Database Setup:</span> Products table with color and category relationships
                        </li>
                        <li class="pb-2">
                            <span class="font-semibold">Livewire Component:</span> Handles filtering logic without page refresh
                        </li>
                        <li class="pb-2">
                            <span class="font-semibold">Real-time Updates:</span> Uses <code>wire:model.live</code> for instant filtering
                        </li>
                        <li class="pb-2">
                            <span class="font-semibold">Multiple Filters:</span> Combine color, category, and search filters
                        </li>
                        <li class="pb-2">
                            <span class="font-semibold">Reset Functionality:</span> One-click reset for all filters
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8 mt-12">
            <div class="container mx-auto px-4 text-center">
                <p>Laravel 12 + Livewire 3 Live Filter Demo</p>
                <p class="text-gray-400 mt-2">Filter products by color and category without page refresh</p>
            </div>
        </footer>
    </div>
    @livewireScripts
</body>
</html>