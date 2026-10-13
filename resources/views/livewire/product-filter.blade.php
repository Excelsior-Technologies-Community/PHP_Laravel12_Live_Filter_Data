<div>
    <div class="container mx-auto px-4 lg:px-8 py-8">

        <!-- ================= Top Analytics Counters ================= -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6 mb-8">
            <!-- 1. Total Products -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase font-bold tracking-wider text-slate-400">Total Catalog</span>
                    <h3 class="text-3xl font-black text-brand-600 dark:text-brand-400 mt-1">{{ $totalProducts }}</h3>
                    <span class="text-xs text-slate-500">Active inventory</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 flex items-center justify-center text-xl">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
            </div>

            <!-- 2. Categories -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase font-bold tracking-wider text-slate-400">Departments</span>
                    <h3 class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $totalCategories }}</h3>
                    <span class="text-xs text-slate-500">Hierarchical tree</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl">
                    <i class="fas fa-sitemap"></i>
                </div>
            </div>

            <!-- 3. In Stock -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase font-bold tracking-wider text-slate-400">In Stock</span>
                    <h3 class="text-3xl font-black text-cyan-600 dark:text-cyan-400 mt-1">{{ $inStockCount }}</h3>
                    <span class="text-xs text-slate-500">Ready to ship</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-xl">
                    <i class="fas fa-truck-fast"></i>
                </div>
            </div>

            <!-- 4. Avg Price -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase font-bold tracking-wider text-slate-400">Avg Value</span>
                    <h3 class="text-3xl font-black text-amber-500 mt-1">${{ number_format($averagePrice, 0) }}</h3>
                    <span class="text-xs text-slate-500">Catalog mean</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-500 flex items-center justify-center text-xl">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>

        <!-- ================= Main Content: Sidebar + Products ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">

            <!-- ================= Left Sidebar Filters ================= -->
            <aside class="lg:col-span-1 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 sticky top-20">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                    <h2 class="text-lg font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-sliders text-brand-600"></i> Filters
                    </h2>
                    <button wire:click="resetFilters" 
                            class="text-xs font-semibold text-rose-600 hover:text-rose-700 dark:text-rose-400 flex items-center gap-1 hover:underline transition">
                        <i class="fas fa-rotate-left"></i> Reset All
                    </button>
                </div>

                <!-- 1. Search Bar -->
                <div class="mt-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Keyword Search</label>
                    <div class="relative">
                        <i class="fas fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               placeholder="Search title, specs..." 
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                    </div>
                </div>

                <!-- 2. Category Tree with Expandable Subcategories -->
                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2.5">
                        <i class="fas fa-sitemap text-brand-500 me-1"></i> Category Tree
                    </label>
                    <div class="space-y-2 max-h-56 overflow-y-auto pr-1">
                        @foreach($parentCategories as $parent)
                            <div x-data="{ open: true }" class="rounded-lg border border-slate-100 dark:border-slate-800/80 p-2 bg-slate-50/50 dark:bg-slate-800/30">
                                <div class="flex items-center justify-between">
                                    <label class="flex items-center gap-2 cursor-pointer text-sm font-bold text-slate-800 dark:text-slate-200">
                                        <input type="checkbox" 
                                               wire:click="toggleCategory({{ $parent->id }})" 
                                               {{ in_array($parent->id, $selectedCategories) ? 'checked' : '' }} 
                                               class="rounded text-brand-600 focus:ring-brand-500">
                                        <span>{{ $parent->icon ?? '📁' }} {{ $parent->name }}</span>
                                    </label>
                                    <button @click="open = !open" type="button" class="text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                        <i class="fas" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                                    </button>
                                </div>

                                <!-- Subcategories -->
                                @if($parent->children->count() > 0)
                                    <div x-show="open" class="mt-2 pl-5 space-y-1.5 border-l-2 border-slate-200 dark:border-slate-700 ml-2.5">
                                        @foreach($parent->children as $child)
                                            <label class="flex items-center justify-between cursor-pointer text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-brand-600">
                                                <div class="flex items-center gap-2">
                                                    <input type="checkbox" 
                                                           wire:click="toggleCategory({{ $child->id }})" 
                                                           {{ in_array($child->id, $selectedCategories) ? 'checked' : '' }} 
                                                           class="rounded text-brand-600 focus:ring-brand-500 text-xs">
                                                    <span>{{ $child->name }}</span>
                                                </div>
                                                <span class="text-slate-400 text-[10px] font-mono">({{ $child->products_count }})</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Interactive Color Swatches with Counts -->
                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2.5">
                        <i class="fas fa-palette text-cyan-500 me-1"></i> Color Swatches
                    </label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($colorsList as $c)
                            @php
                                $isSelected = in_array($c->color, $selectedColors);
                                $hex = $c->color_code ?? strtolower($c->color);
                            @endphp
                            <button type="button" 
                                    wire:click="toggleColor('{{ $c->color }}')" 
                                    title="{{ $c->color }} ({{ $c->count }})"
                                    class="group relative flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-medium border transition {{ $isSelected ? 'border-brand-600 bg-brand-50 dark:bg-brand-950/70 text-brand-700 dark:text-brand-300 ring-2 ring-brand-500/20' : 'border-slate-200 dark:border-slate-700 hover:border-slate-300 text-slate-600 dark:text-slate-400 bg-white dark:bg-slate-800' }}">
                                <span class="w-3.5 h-3.5 rounded-full border border-black/10 inline-block shadow-inner" style="background-color: {{ $hex }}"></span>
                                <span>{{ $c->color }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">({{ $c->count }})</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Brands Filter -->
                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2.5">
                        <i class="fas fa-tag text-emerald-500 me-1"></i> Brands &amp; Makers
                    </label>
                    <div class="space-y-1.5 max-h-40 overflow-y-auto pr-1">
                        @foreach($brandsList as $b)
                            <label class="flex items-center justify-between cursor-pointer text-xs font-medium text-slate-700 dark:text-slate-300 hover:text-brand-600">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" 
                                           wire:click="toggleBrand({{ $b->id }})" 
                                           {{ in_array($b->id, $selectedBrands) ? 'checked' : '' }} 
                                           class="rounded text-brand-600 focus:ring-brand-500">
                                    <span>{{ $b->name }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 font-mono">({{ $b->products_count }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 5. Dual Price Range Filter -->
                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800" 
                     x-data="{
                         min: @entangle('minPrice').live,
                         max: @entangle('maxPrice').live,
                         dbMin: {{ $dbMinPrice }},
                         dbMax: {{ $dbMaxPrice }}
                     }"
                     x-init="
                        let slider = $refs.priceSlider;
                        noUiSlider.create(slider, {
                            start: [min || dbMin, max || dbMax],
                            connect: true,
                            step: 10,
                            range: { 'min': dbMin, 'max': dbMax }
                        });
                        slider.noUiSlider.on('change', function(values) {
                            min = Math.round(values[0]);
                            max = Math.round(values[1]);
                        });
                     ">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-3">
                        <i class="fas fa-hand-holding-dollar text-amber-500 me-1"></i> Price Range ($)
                    </label>
                    <div x-ref="priceSlider" class="mb-4 mx-2"></div>
                    <div class="flex items-center justify-between gap-2 text-xs">
                        <div class="w-1/2">
                            <span class="text-[10px] text-slate-400 block mb-0.5">Min ($)</span>
                            <input type="number" wire:model.live.debounce.400ms="minPrice" placeholder="{{ $dbMinPrice }}" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 font-mono text-xs">
                        </div>
                        <span class="text-slate-400 self-end mb-1.5">-</span>
                        <div class="w-1/2">
                            <span class="text-[10px] text-slate-400 block mb-0.5">Max ($)</span>
                            <input type="number" wire:model.live.debounce.400ms="maxPrice" placeholder="{{ $dbMaxPrice }}" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 font-mono text-xs">
                        </div>
                    </div>
                </div>

                <!-- 6. Star Ratings Filter -->
                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">
                        <i class="fas fa-star text-amber-400 me-1"></i> Customer Ratings
                    </label>
                    <div class="space-y-1">
                        @foreach([4.5, 4.0, 3.0] as $rVal)
                            <button type="button" 
                                    wire:click="setRating({{ $rVal }})" 
                                    class="w-full flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition {{ $minRating == $rVal ? 'bg-amber-50 dark:bg-amber-950/50 text-amber-900 dark:text-amber-200 font-bold border border-amber-300 dark:border-amber-700' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                                <div class="flex items-center gap-1.5 text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-[11px] {{ $i <= floor($rVal) ? '' : ($i - 0.5 <= $rVal ? 'fa-star-half-alt' : 'text-slate-300 dark:text-slate-700') }}"></i>
                                    @endfor
                                    <span class="text-xs text-slate-700 dark:text-slate-300 ms-1">{{ $rVal }} &amp; Up</span>
                                </div>
                                @if($minRating == $rVal)
                                    <i class="fas fa-check text-amber-600"></i>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- 7. Stock & Deals Toggles -->
                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 space-y-3">
                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                            <i class="fas fa-check-circle text-emerald-500 me-1"></i> In Stock Only
                        </span>
                        <input type="checkbox" wire:model.live="inStockOnly" class="rounded text-brand-600 focus:ring-brand-500">
                    </label>

                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                            <i class="fas fa-percent text-rose-500 me-1"></i> On Sale / Deals
                        </span>
                        <input type="checkbox" wire:model.live="onSaleOnly" class="rounded text-brand-600 focus:ring-brand-500">
                    </label>
                </div>
            </aside>

            <!-- ================= Right Catalog Products Area ================= -->
            <main class="lg:col-span-3">

                <!-- Controls Bar (Active Filters, Sort, View, Per Page) -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
                    <!-- Left: Counter & Badge Filters -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">
                            Showing <strong class="text-slate-900 dark:text-white">{{ $products->total() }}</strong> Results
                        </span>

                        <!-- Quick Badges: Best Seller, Deals, New -->
                        <div class="flex items-center gap-1.5 ms-2">
                            <button type="button" wire:click="setBadge('best_seller')" 
                                    class="text-xs px-2.5 py-1 rounded-full font-bold transition {{ $selectedBadge === 'best_seller' ? 'bg-amber-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                                🔥 Best Sellers
                            </button>
                            <button type="button" wire:click="setBadge('limited_deal')" 
                                    class="text-xs px-2.5 py-1 rounded-full font-bold transition {{ $selectedBadge === 'limited_deal' ? 'bg-rose-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                                ⚡ Limited Deals
                            </button>
                            <button type="button" wire:click="setBadge('new_arrival')" 
                                    class="text-xs px-2.5 py-1 rounded-full font-bold transition {{ $selectedBadge === 'new_arrival' ? 'bg-indigo-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                                ✨ New
                            </button>
                        </div>
                    </div>

                    <!-- Right Controls: Items per page, Sort, View Grid/List -->
                    <div class="flex items-center gap-3">
                        <!-- Per page -->
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <span class="hidden sm:inline">Show:</span>
                            <select wire:model.live="perPage" class="rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-2 py-1.5 text-xs text-slate-800 dark:text-slate-200">
                                <option value="9">9</option>
                                <option value="18">18</option>
                                <option value="36">36</option>
                                <option value="100">All</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <select wire:model.live="sortBy" class="rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-3 py-1.5 text-xs font-medium text-slate-800 dark:text-slate-200">
                            <option value="latest">Sort: Latest Arrivals</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="rating_high">Highest Rated</option>
                            <option value="name_asc">Name: A to Z</option>
                            <option value="name_desc">Name: Z to A</option>
                        </select>

                        <!-- Grid / List Switcher -->
                        <div class="flex items-center rounded-lg border border-slate-200 dark:border-slate-700 p-0.5 bg-slate-100 dark:bg-slate-800">
                            <button type="button" wire:click="setView('grid')" class="p-1.5 rounded-md text-xs transition {{ $viewType === 'grid' ? 'bg-white dark:bg-slate-700 text-brand-600 shadow-sm' : 'text-slate-400 hover:text-slate-700' }}" title="Grid View">
                                <i class="fas fa-grid-2"></i> ▦
                            </button>
                            <button type="button" wire:click="setView('list')" class="p-1.5 rounded-md text-xs transition {{ $viewType === 'list' ? 'bg-white dark:bg-slate-700 text-brand-600 shadow-sm' : 'text-slate-400 hover:text-slate-700' }}" title="List View">
                                <i class="fas fa-list"></i> ☰
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Active Filters Chips Bar -->
                @if($search || count($selectedColors) || count($selectedCategories) || count($selectedBrands) || $minPrice !== '' || $maxPrice !== '' || $minRating !== '' || $inStockOnly || $onSaleOnly || $selectedBadge)
                    <div class="flex items-center gap-2 flex-wrap mb-6 p-3 rounded-xl bg-brand-50/70 dark:bg-brand-950/40 border border-brand-100 dark:border-brand-900/50 text-xs">
                        <span class="font-bold text-brand-800 dark:text-brand-300">Active Filters:</span>

                        @if($search)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-brand-200 shadow-2xs">
                                Search: "{{ $search }}"
                                <button type="button" wire:click="$set('search', '')" class="text-slate-400 hover:text-rose-500">&times;</button>
                            </span>
                        @endif

                        @foreach($selectedColors as $sc)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-brand-200 shadow-2xs">
                                Color: {{ $sc }}
                                <button type="button" wire:click="toggleColor('{{ $sc }}')" class="text-slate-400 hover:text-rose-500">&times;</button>
                            </span>
                        @endforeach

                        @foreach($selectedBrands as $sb)
                            @php $bObj = $brandsList->firstWhere('id', $sb); @endphp
                            @if($bObj)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-brand-200 shadow-2xs">
                                    Brand: {{ $bObj->name }}
                                    <button type="button" wire:click="toggleBrand({{ $sb }})" class="text-slate-400 hover:text-rose-500">&times;</button>
                                </span>
                            @endif
                        @endforeach

                        @if($minRating)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-brand-200 shadow-2xs">
                                {{ $minRating }}+ Stars
                                <button type="button" wire:click="setRating('')" class="text-slate-400 hover:text-rose-500">&times;</button>
                            </span>
                        @endif

                        @if($inStockOnly)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                                In Stock
                                <button type="button" wire:click="$set('inStockOnly', false)" class="text-emerald-500 hover:text-rose-500">&times;</button>
                            </span>
                        @endif

                        @if($onSaleOnly)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-200">
                                On Sale
                                <button type="button" wire:click="$set('onSaleOnly', false)" class="text-rose-500 hover:text-rose-500">&times;</button>
                            </span>
                        @endif

                        <button type="button" wire:click="resetFilters" class="text-rose-600 dark:text-rose-400 font-bold hover:underline ms-auto">
                            Clear All
                        </button>
                    </div>
                @endif

                <!-- ================= Skeleton Shimmer Loading Placeholder ================= -->
                <div wire:loading.grid class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                    @for($i = 0; $i < 6; $i++)
                        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 animate-pulse">
                            <div class="w-full h-44 bg-slate-200 dark:bg-slate-800 rounded-xl mb-4"></div>
                            <div class="h-4 bg-slate-200 dark:bg-slate-800 rounded w-3/4 mb-2"></div>
                            <div class="h-3 bg-slate-200 dark:bg-slate-800 rounded w-1/2 mb-4"></div>
                            <div class="flex justify-between items-center pt-3 border-t border-slate-100 dark:border-slate-800">
                                <div class="h-6 bg-slate-200 dark:bg-slate-800 rounded w-1/3"></div>
                                <div class="h-8 bg-slate-200 dark:bg-slate-800 rounded w-1/4"></div>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- ================= Product Results List/Grid ================= -->
                <div wire:loading.remove>
                    @if($products->count() > 0)
                        @if($viewType === 'grid')
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach($products as $product)
                                    <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-1 transition duration-200 flex flex-col justify-between">
                                        <!-- Card Top Header Image & Badges -->
                                        <div class="relative bg-slate-100 dark:bg-slate-800/50 p-6 flex items-center justify-center overflow-hidden">
                                            <!-- Badge -->
                                            @if($product->badge === 'best_seller')
                                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-amber-500 text-white shadow-sm">
                                                    🔥 Best Seller
                                                </span>
                                            @elseif($product->badge === 'limited_deal')
                                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-rose-500 text-white shadow-sm">
                                                    ⚡ Limited Deal
                                                </span>
                                            @elseif($product->badge === 'new_arrival')
                                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-indigo-500 text-white shadow-sm">
                                                    ✨ New Arrival
                                                </span>
                                            @endif

                                            <!-- Out of stock badge -->
                                            @if(!$product->is_in_stock)
                                                <span class="absolute top-3 right-3 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-800/80 text-white backdrop-blur">
                                                    Out of Stock
                                                </span>
                                            @endif

                                            <!-- Thumbnail -->
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-40 w-auto object-contain group-hover:scale-105 transition duration-300">

                                            <!-- Quick View Overlay Button -->
                                            <button type="button" wire:click="openQuickView({{ $product->id }})" 
                                                    class="absolute bottom-3 right-3 bg-white/90 dark:bg-slate-800/90 hover:bg-white text-slate-800 dark:text-slate-100 p-2 rounded-xl shadow-md text-xs font-semibold backdrop-blur transition hover:scale-110"
                                                    title="Quick View Details">
                                                <i class="fas fa-eye me-1"></i> Quick View
                                            </button>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="p-5 flex-grow flex flex-col justify-between">
                                            <div>
                                                <!-- Category & Brand -->
                                                <div class="flex items-center justify-between text-xs text-slate-400 mb-1.5 font-medium">
                                                    <span>{{ $product->category->name ?? 'General' }}</span>
                                                    @if($product->brand)
                                                        <span class="font-bold text-slate-600 dark:text-slate-300">{{ $product->brand->name }}</span>
                                                    @endif
                                                </div>

                                                <!-- Product Name -->
                                                <h3 class="font-bold text-base text-slate-900 dark:text-white line-clamp-1 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition">
                                                    {{ $product->name }}
                                                </h3>

                                                <!-- Description -->
                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                                    {{ $product->description }}
                                                </p>

                                                <!-- Star Ratings -->
                                                <div class="flex items-center gap-1.5 mt-3">
                                                    <div class="flex text-amber-400 text-xs">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= floor($product->rating) ? '' : 'text-slate-200 dark:text-slate-700' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ number_format($product->rating, 1) }}</span>
                                                    <span class="text-[11px] text-slate-400 font-mono">({{ $product->reviews_count }})</span>
                                                </div>
                                            </div>

                                            <!-- Bottom Price & Color swatch -->
                                            <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                                <!-- Price -->
                                                <div>
                                                    <div class="flex items-baseline gap-1.5">
                                                        <span class="text-xl font-black text-slate-900 dark:text-white">
                                                            ${{ number_format($product->price, 2) }}
                                                        </span>
                                                        @if($product->has_discount)
                                                            <span class="text-xs text-slate-400 line-through">
                                                                ${{ number_format($product->original_price, 2) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if($product->discount_percent > 0)
                                                        <span class="text-[10px] font-bold text-rose-600 dark:text-rose-400">
                                                            Save {{ number_format($product->discount_percent, 0) }}%
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Color Dot -->
                                                <div class="flex items-center gap-1" title="Color: {{ $product->color }}">
                                                    <span class="w-4 h-4 rounded-full border border-black/10 inline-block shadow-inner" style="background-color: {{ $product->color_code ?? strtolower($product->color) }}"></span>
                                                    <span class="text-xs font-medium text-slate-500">{{ $product->color }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- List View -->
                            <div class="space-y-4">
                                @foreach($products as $product)
                                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-xs hover:shadow-md transition flex flex-col md:flex-row items-center gap-6">
                                        <div class="w-full md:w-48 h-36 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center p-4 shrink-0 relative">
                                            @if($product->badge)
                                                <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-amber-500 text-white">
                                                    {{ str_replace('_', ' ', $product->badge) }}
                                                </span>
                                            @endif
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-28 object-contain">
                                        </div>

                                        <div class="flex-grow">
                                            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                                                <span>{{ $product->category->name }}</span>
                                                <span>·</span>
                                                <span class="font-bold text-slate-600 dark:text-slate-300">{{ $product->brand->name ?? 'Brand' }}</span>
                                            </div>
                                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $product->name }}</h3>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2">{{ $product->description }}</p>

                                            <div class="flex items-center gap-4 mt-3">
                                                <div class="flex items-center gap-1 text-amber-400 text-xs">
                                                    <i class="fas fa-star"></i>
                                                    <span class="font-bold text-slate-700 dark:text-slate-300">{{ $product->rating }}</span>
                                                    <span class="text-slate-400">({{ $product->reviews_count }} reviews)</span>
                                                </div>
                                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                                    <span class="w-3 h-3 rounded-full border" style="background-color: {{ $product->color_code ?? strtolower($product->color) }}"></span>
                                                    <span>{{ $product->color }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right shrink-0">
                                            <div class="text-2xl font-black text-slate-900 dark:text-white">${{ number_format($product->price, 2) }}</div>
                                            @if($product->has_discount)
                                                <span class="text-xs text-slate-400 line-through">${{ number_format($product->original_price, 2) }}</span>
                                            @endif
                                            <div class="mt-3">
                                                <button type="button" wire:click="openQuickView({{ $product->id }})" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition">
                                                    Quick View
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Pagination Container -->
                        @if($products->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $products->links() }}
                            </div>
                        @endif
                    @else
                        <!-- No Results Found -->
                        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-12 text-center">
                            <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-4">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">No Products Matched</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                                We couldn't find any products matching your active filters. Try adjusting price, colors, or categories.
                            </p>
                            <button type="button" wire:click="resetFilters" class="mt-5 px-5 py-2.5 rounded-xl bg-brand-600 text-white text-xs font-bold shadow-md hover:bg-brand-700 transition">
                                <i class="fas fa-rotate-left me-1"></i> Clear All Filters
                            </button>
                        </div>
                    @endif
                </div>

            </main>
        </div>

    </div>

    <!-- ================= Quick View Modal ================= -->
    @if($quickViewProduct)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4" x-data @keydown.escape.window="$wire.closeQuickView()">
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-2xl w-full border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden relative animate-in fade-in zoom-in duration-150">
                <!-- Close Button -->
                <button type="button" wire:click="closeQuickView" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center hover:bg-rose-100 hover:text-rose-600 transition">
                    &times;
                </button>

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <!-- Modal Left Image -->
                    <div class="bg-slate-100 dark:bg-slate-800 p-8 flex items-center justify-center">
                        <img src="{{ $quickViewProduct->image_url }}" alt="{{ $quickViewProduct->name }}" class="max-h-64 object-contain">
                    </div>

                    <!-- Modal Right Details -->
                    <div class="p-6 md:p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                                <span>{{ $quickViewProduct->category->name }}</span>
                                <span>·</span>
                                <span class="font-bold text-brand-600">{{ $quickViewProduct->brand->name ?? 'Brand' }}</span>
                            </div>

                            <h2 class="text-xl font-extrabold text-slate-900 dark:text-white leading-snug">
                                {{ $quickViewProduct->name }}
                            </h2>

                            <!-- Rating -->
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex text-amber-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= floor($quickViewProduct->rating) ? '' : 'text-slate-300 dark:text-slate-700' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $quickViewProduct->rating }} / 5</span>
                                <span class="text-xs text-slate-400">({{ $quickViewProduct->reviews_count }} reviews)</span>
                            </div>

                            <!-- Price -->
                            <div class="mt-4 flex items-baseline gap-2">
                                <span class="text-3xl font-black text-slate-900 dark:text-white">
                                    ${{ number_format($quickViewProduct->price, 2) }}
                                </span>
                                @if($quickViewProduct->has_discount)
                                    <span class="text-sm text-slate-400 line-through">
                                        ${{ number_format($quickViewProduct->original_price, 2) }}
                                    </span>
                                    <span class="text-xs font-bold text-rose-600">
                                        -{{ number_format($quickViewProduct->discount_percent, 0) }}% Off
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-3 leading-relaxed">
                                {{ $quickViewProduct->description }}
                            </p>

                            <!-- Color & Stock -->
                            <div class="mt-5 space-y-2 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-700 dark:text-slate-300">Selected Color:</span>
                                    <span class="w-4 h-4 rounded-full border inline-block" style="background-color: {{ $quickViewProduct->color_code ?? strtolower($quickViewProduct->color) }}"></span>
                                    <span>{{ $quickViewProduct->color }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-700 dark:text-slate-300">Stock Status:</span>
                                    @if($quickViewProduct->is_in_stock)
                                        <span class="text-emerald-600 font-bold"><i class="fas fa-check-circle me-1"></i> In Stock ({{ $quickViewProduct->stock_quantity }} units left)</span>
                                    @else
                                        <span class="text-rose-600 font-bold"><i class="fas fa-times-circle me-1"></i> Currently Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 mt-6 border-t border-slate-100 dark:border-slate-800 flex items-center gap-3">
                            <button type="button" wire:click="closeQuickView" class="w-full py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold hover:bg-slate-200 transition">
                                Close Preview
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>