<div>


    <div class="container mx-auto px-6 py-8">

        @if(session('success'))

            <div class="mb-6">

                <div class="bg-green-100 border border-green-400 text-green-700 px-5 py-4 rounded">

                    {{ session('success') }}

                </div>

            </div>

        @endif


        <!-- ================= Dashboard ================= -->

        <div class="mb-8">

            <h1 class="text-4xl font-bold text-center text-gray-800">
                Live Product Filter
            </h1>

            <p class="text-center text-gray-500 mt-2">
                Laravel 12 + Livewire 3
            </p>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            <!-- Total Products -->

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">

                <h3 class="text-gray-500 text-sm uppercase">

                    Total Products

                </h3>

                <h2 class="text-4xl font-bold text-blue-600 mt-2">

                    {{ $totalProducts }}

                </h2>

            </div>

            <!-- Categories -->

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">

                <h3 class="text-gray-500 text-sm uppercase">

                    Categories

                </h3>

                <h2 class="text-4xl font-bold text-green-600 mt-2">

                    {{ $totalCategories }}

                </h2>

            </div>

            <!-- Average Price -->

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">

                <h3 class="text-gray-500 text-sm uppercase">

                    Average Price

                </h3>

                <h2 class="text-4xl font-bold text-yellow-600 mt-2">

                    ${{ number_format($averagePrice, 2) }}

                </h2>

            </div>

            <!-- Latest Product -->

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">

                <h3 class="text-gray-500 text-sm uppercase">

                    Latest Product

                </h3>

                <h2 class="text-xl font-bold text-purple-600 mt-2 truncate">

                    {{ $latestProduct?->name ?? 'N/A' }}

                </h2>

            </div>

        </div>


        <!-- ================= Filter Card ================= -->

        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-5">

                <!-- Search -->

                <div>

                    <label class="font-semibold text-gray-700">

                        Search

                    </label>

                    <input type="text" wire:model.live="search" placeholder="Search products..."
                        class="mt-2 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                </div>


                <!-- Color -->

                <div>

                    <label class="font-semibold text-gray-700">

                        Color

                    </label>

                    <select wire:model.live="selectedColor" class="mt-2 w-full rounded-lg border-gray-300">

                        <option value="">All Colors</option>

                        @foreach($colors as $color)

                            <option value="{{ $color }}">

                                {{ $color }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- Category -->

                <div>

                    <label class="font-semibold text-gray-700">

                        Category

                    </label>

                    <select wire:model.live="selectedCategory" class="mt-2 w-full rounded-lg border-gray-300">

                        <option value="">All Categories</option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- Sort -->

                <div>

                    <label class="font-semibold text-gray-700">

                        Sort By

                    </label>

                    <select wire:model.live="sortBy" class="mt-2 w-full rounded-lg border-gray-300">

                        <option value="latest">

                            Latest

                        </option>

                        <option value="oldest">

                            Oldest

                        </option>

                        <option value="price_low">

                            Price Low → High

                        </option>

                        <option value="price_high">

                            Price High → Low

                        </option>

                        <option value="name_asc">

                            Name A → Z

                        </option>

                        <option value="name_desc">

                            Name Z → A

                        </option>

                    </select>

                </div>


                <!-- Reset -->

                <div class="flex items-end">

                    <button wire:click="resetFilters"
                        class="w-full bg-red-500 hover:bg-red-600 text-white rounded-lg py-3 transition">

                        Reset Filters

                    </button>

                </div>

            </div>

        </div>


        <!-- ================= Active Filters ================= -->

        @if($search || $selectedColor || $selectedCategory)

            <div class="bg-blue-50 rounded-xl p-4 mb-6">

                <span class="font-bold text-blue-700">

                    Active Filters :

                </span>

                @if($search)

                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full ml-2">

                        {{ $search }}

                    </span>

                @endif

                @if($selectedColor)

                    <span class="bg-green-600 text-white px-3 py-1 rounded-full ml-2">

                        {{ $selectedColor }}

                    </span>

                @endif

                @if($selectedCategory)

                    <span class="bg-purple-600 text-white px-3 py-1 rounded-full ml-2">

                        {{ optional($categories->find($selectedCategory))->name }}

                    </span>

                @endif

            </div>

        @endif


        <!-- ================= Product Count ================= -->

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-xl font-semibold">

                Products

            </h2>

            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg">

                {{ $products->total() }} Products Found

            </span>

        </div>

        <!-- ================= Product Grid Starts Here ================= -->

        @if($products->count())

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($products as $product)

                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">

                        <!-- Product Header -->

                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-5 text-white">

                            <h2 class="text-2xl font-bold">

                                {{ $product->name }}

                            </h2>

                            <p class="text-sm opacity-90 mt-2">

                                {{ Str::limit($product->description, 80) }}

                            </p>

                        </div>

                        <!-- Product Body -->

                        <div class="p-5">

                            <div class="flex justify-between items-center mb-4">

                                <span class="text-3xl font-bold text-green-600">

                                    ${{ number_format($product->price, 2) }}

                                </span>

                                <span class="px-3 py-1 bg-gray-200 rounded-full text-sm font-semibold">

                                    {{ $product->category->name }}

                                </span>

                            </div>

                            <!-- Color -->

                            <div class="flex items-center mb-5">

                                <div class="w-6 h-6 rounded-full border border-gray-300 mr-3"
                                    style="background: {{ strtolower($product->color) }}">
                                </div>

                                <span class="font-medium">

                                    {{ $product->color }}

                                </span>

                            </div>

                            <!-- Product Information -->

                            <div class="space-y-2 text-sm text-gray-600">

                                <div class="flex justify-between">

                                    <span>ID</span>

                                    <span>#{{ $product->id }}</span>

                                </div>

                                <div class="flex justify-between">

                                    <span>Created</span>

                                    <span>

                                        {{ $product->created_at->format('d M Y') }}

                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span>Updated</span>

                                    <span>

                                        {{ $product->updated_at->diffForHumans() }}

                                    </span>

                                </div>

                            </div>

                            <!-- Buttons -->

                            <div class="grid grid-cols-2 gap-3 mt-6">

                                <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">

                                    View

                                </button>

                                <button onclick="confirmDelete({{ $product->id }})"
                                    class="bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg">

                                    Delete

                                </button>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <!-- No Products Found -->

            <div class="bg-white rounded-xl shadow-lg p-12 text-center">

                <div class="text-7xl mb-4">
                    📦
                </div>

                <h2 class="text-3xl font-bold text-gray-700 mb-3">
                    No Products Found
                </h2>

                <p class="text-gray-500 mb-6">
                    Try changing your search or filters.
                </p>

                <button wire:click="resetFilters" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg">

                    Reset Filters

                </button>

            </div>

        @endif


        <!-- Pagination -->

        @if($products->hasPages())

            <div class="mt-10 flex justify-center">

                {{ $products->links() }}

            </div>

        @endif


        <!-- Loading Indicator -->

        <div wire:loading class="fixed top-0 left-0 w-full h-1 bg-blue-200 z-50">

            <div class="h-full bg-blue-600 animate-pulse"></div>

        </div>


        <!-- SweetAlert Script (used in Part 3) -->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

            function confirmDelete(id) {

                Swal.fire({

                    title: 'Are you sure?',

                    text: "This product will be deleted.",

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#dc2626',

                    cancelButtonColor: '#6b7280',

                    confirmButtonText: 'Yes, Delete'

                }).then((result) => {

                    if (result.isConfirmed) {

                        window.location = '/products/delete/' + id;

                    }

                });

            }

        </script>

    </div>