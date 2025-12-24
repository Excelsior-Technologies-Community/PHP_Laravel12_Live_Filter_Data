# PHP_Laravel12_Live_Filter_Data

A complete Laravel 12 application demonstrating **real-time product filtering** using **Livewire 3**. The application allows users to filter products by **color**, **category**, and **search keyword** without page refresh, providing a smooth and modern user experience.

---

## Project Overview

**Application Name:** Product Filter App
**Framework:** Laravel 12
**Frontend:** Blade + Tailwind CSS
**Dynamic UI:** Livewire 3
**Database:** MySQL

This project is designed as a **learning-friendly and production-ready example** of Livewire-based filtering.

---

## Key Features

* Live product filtering without page reload
* Filter products by color
* Filter products by category
* Live search by product name or description
* Reset all filters with one click
* Active filters indicator
* Loading indicator during filtering
* Responsive UI using Tailwind CSS
* Proper Eloquent relationships
* Database seeders with demo data

---

## Requirements

* PHP 8.1 or higher
* Composer
* MySQL
* Laravel CLI
* Node.js (optional, CDN Tailwind used)

---

## Installation Steps

### Step 1: Create Laravel Project

```bash
composer create-project laravel/laravel product-filter-app
cd product-filter-app
```

### Step 2: Install Livewire 3

```bash
composer require livewire/livewire
```

### Step 3: Configure Database

Update `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_filter
DB_USERNAME=root
DB_PASSWORD=
```

---

## Database Setup

### Step 4: Create Models and Migrations

```bash
php artisan make:model Category -m
php artisan make:model Product -m
```

### Categories Table

* id
* name
* timestamps

### Products Table

* id
* name
* description
* price
* color
* category_id (foreign key)
* timestamps

---

## Model Relationships

### Product Model

```php
public function category()
{
    return $this->belongsTo(Category::class);
}
```

### Category Model

```php
public function products()
{
    return $this->hasMany(Product::class);
}
```

---

## Migrate Database

```bash
php artisan migrate
```

---

## Seeders

### Create Seeders

```bash
php artisan make:seeder CategorySeeder
php artisan make:seeder ProductSeeder
```

* Categories seeded: Electronics, Clothing, Home & Kitchen, Books, Sports
* Products seeded with random prices, colors, and categories

Run seeders:

```bash
php artisan db:seed
```

---

## Livewire Component

### Create Component

```bash
php artisan make:livewire ProductFilter
```

### Component Responsibilities

* Handle selected color filter
* Handle selected category filter
* Handle live search input
* Combine multiple filters dynamically
* Fetch filtered results from database
* Reset all filters

---

## Livewire View Rules (Important)

Livewire components **must have exactly one root HTML element**.

Incorrect structure causes:

```
MultipleRootElementsDetectedException
```

Correct approach:

```blade
<div>
    <!-- All component HTML inside this single root -->
</div>
```

This project follows the correct Livewire structure.

---

## Routes

```php
use App\Livewire\ProductFilter;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', ProductFilter::class);
```

---

## Screenshot
### *Product Filter 
<img width="1847" height="757" alt="image" src="https://github.com/user-attachments/assets/880ff99f-ac31-4470-97e1-8b1be599f267" />

### *Live Product Filter
<img width="1816" height="963" alt="image" src="https://github.com/user-attachments/assets/26162687-97a9-4dfb-9bdc-7fffd24e2d8d" />

### *Filter
<img width="1850" height="942" alt="image" src="https://github.com/user-attachments/assets/dfb6053f-cafa-4bdf-98fc-b7ad3239a383" />

---

## Usage

1. Visit `http://localhost:8000`
2. Open **Live Filter Demo**
3. Filter products using:

   * Color dropdown
   * Category dropdown
   * Search input
4. Combine multiple filters
5. Click **Reset Filters** to clear all filters

Filtering happens instantly without page refresh.

---

## Error Fix Explained

### Error

```
Livewire only supports one HTML element per component
```

### Cause

The Livewire view had **multiple top-level HTML elements**.

### Fix

Wrap entire component content inside a **single root `<div>`**.

This README includes the corrected structure.

---

## Project Structure

```
app/
 └── Livewire/
     └── ProductFilter.php

resources/views/
 ├── livewire/
 │   └── product-filter.blade.php
 └── welcome.blade.php

database/
 ├── migrations/
 └── seeders/
```

---

## Possible Enhancements

* Pagination support
* Price range filter
* Multiple color selection
* Sorting by price or name
* User authentication
* API-based filtering
* Admin panel for product management

---

