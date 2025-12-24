<div>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Live Product Filter</h1>

        <!-- Filter Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Color Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Color</label>
                    <select wire:model.live="selectedColor" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Colors</option>
                        @foreach($colors as $color)
                            <option value="{{ $color }}">{{ $color }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Category</label>
                    <select wire:model.live="selectedCategory" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="Search by name or description..."
                           class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Reset Button -->
                <div class="flex items-end">
                    <button wire:click="resetFilters" 
                            class="w-full p-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Active Filters Display -->
        @if($selectedColor || $selectedCategory || $search)
        <div class="mb-4 p-3 bg-blue-50 rounded-lg">
            <span class="font-medium">Active Filters:</span>
            @if($selectedColor)
                <span class="ml-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                    Color: {{ $selectedColor }}
                </span>
            @endif
            @if($selectedCategory)
                @php
                    $categoryName = $categories->where('id', $selectedCategory)->first()->name;
                @endphp
                <span class="ml-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                    Category: {{ $categoryName }}
                </span>
            @endif
            @if($search)
                <span class="ml-2 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                    Search: "{{ $search }}"
                </span>
            @endif
        </div>
        @endif

        <!-- Products Count -->
        <div class="mb-4">
            <p class="text-gray-600">
                Showing <span class="font-bold">{{ $products->count() }}</span> products
            </p>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition">
                        <div class="p-6">
                            <!-- Color Indicator -->
                            <div class="flex items-center mb-3">
                                <div class="w-6 h-6 rounded-full mr-2 border border-gray-300" 
                                     style="background-color: {{ strtolower($product->color) }}"></div>
                                <span class="text-sm font-medium">{{ $product->color }}</span>
                            </div>
                            
                            <h3 class="text-xl font-bold mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                            
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-2xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                                </div>
                                <div>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">📦</div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No products found</h3>
                <p class="text-gray-500">Try changing your filters or search term</p>
                <button wire:click="resetFilters" 
                        class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Reset All Filters
                </button>
            </div>
        @endif
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed top-0 left-0 w-full h-1 bg-blue-500 z-50">
        <div class="h-full bg-blue-600 animate-pulse"></div>
    </div>
</div>