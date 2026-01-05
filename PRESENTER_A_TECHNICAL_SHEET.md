# 📚 ARTSPACE - PRESENTER A SHEET (TECHNICAL)
## Study Guide untuk Presenter A

---

## 🎯 BAGIAN 1: INTRODUCTION & REQUIREMENTS (3 menit)

### Yang Harus Disampaikan:
- Judul: "Artspace - Marketplace Seni Digital dengan Laravel 12"
- Tujuan Project:
  - Implementasi full-stack web application
  - Database relational yang kompleks
  - Authentication & authorization system
  - Real-time communication features

### Technology Stack:
- **Backend:** Laravel 12 (PHP framework)
- **Frontend:** Bootstrap 5, JavaScript/Vue
- **Database:** SQLite/MySQL
- **Storage:** File system (storage/app/public)
- **Key Libraries:** Laravel Eloquent ORM

### Target Users:
1. **Admin** - Manage platform, reports, users
2. **Artist** - Upload artworks, create services, manage orders
3. **Buyer** - Browse, order, communicate, review

### Script:
```
"Hari ini kami akan presentasikan Artspace, sebuah marketplace seni digital 
yang kami bangun menggunakan Laravel 12. Project ini mendemonstrasikan 
implementasi full-stack web application dengan database yang kompleks, 
authentication system, dan real-time features yang terintegrasi baik."
```

---

## 🏗️ BAGIAN 2: SYSTEM ARCHITECTURE & DATABASE DESIGN (8 menit)

### Database Schema Diagram:

```
┌─────────────────────────────────────────────────────────┐
│                      USERS TABLE                         │
│  user_id | name | email | role | whatsapp_link | ...   │
│  PK      | string | string | enum | string |           │
│  Roles: admin, artist, buyer                            │
└──────────────────┬──────────────────────────────────────┘
                   │
       ┌───────────┼───────────┐
       │           │           │
       ▼           ▼           ▼
   ARTWORKS    SERVICES     ORDERS
   (user_id)   (user_id)    (service_id,
   (category)  (category)    buyer_id)
                   │
                   ▼
            SERVICE_CATEGORIES (PIVOT)
            service_id | category_id | price
```

### 📋 TABLE DEFINITIONS:

#### 1. **Users Table**
```
Columns:
├─ user_id (PK, bigint)
├─ name (string)
├─ email (string, unique)
├─ password (hashed)
├─ role (enum: admin, artist, buyer)
├─ whatsapp_link (string, nullable) → untuk artist
├─ created_at, updated_at (timestamps)

Relationships:
├─ hasMany: Artworks (user_id)
├─ hasMany: Services (user_id)
├─ hasMany: Orders (buyer_id)
└─ hasMany: Reviews (user_id)

Key Points:
- role membedakan privilege level
- whatsapp_link untuk contact artist
```

#### 2. **Artworks Table**
```
Columns:
├─ artwork_id (PK, bigint)
├─ user_id (FK) → artist pembuat
├─ title (string)
├─ description (text, nullable)
├─ image_url (string) → path ke file storage
├─ category_id (FK, nullable)
├─ created_at, updated_at (timestamps)

Relationships:
├─ belongsTo: User (user_id) - artist
├─ belongsTo: Category (category_id)
└─ hasMany: Reviews (artwork_id)

Storage Path:
- storage/app/public/artworks/{filename}
- Access: asset('storage/artworks/{filename}')

Key Points:
- image_url menyimpan path relatif (bukan full URL)
- Bisa null jika no image
```

#### 3. **Services Table** ⭐ (MAIN FOCUS)
```
Columns:
├─ service_id (PK, bigint)
├─ user_id (FK) → artist pembuat
├─ title (string)
├─ description (text, nullable)
├─ base_price (decimal: 10,2)
├─ expected_duration (string, nullable) → contoh: "3-5 hari"
├─ thumbnail (string, nullable) → path ke image
├─ status (enum: active, inactive)
├─ created_at, updated_at (timestamps)

Relationships:
├─ belongsTo: User (user_id) - artist
├─ hasMany: Orders (service_id)
├─ belongsToMany: Categories (via service_categories pivot)
│  └─ withPivot('price') → harga per kategori
└─ hasMany: Reviews (service_id)

Storage Path:
- storage/app/public/services/{filename}
- Access: asset('storage/services/{filename}')

Key Points:
- thumbnail wajib buat preview
- base_price adalah harga dasar
- Multiple categories dengan harga berbeda (via pivot)
```

#### 4. **Service_Categories Table (PIVOT)** ⭐ (IMPORTANT)
```
Columns:
├─ service_id (FK to services)
├─ category_id (FK to categories)
├─ price (decimal: 10,2) ⭐ FLEXIBLE PRICING
├─ created_at, updated_at (timestamps)

Primary Key:
├─ Composite: (service_id, category_id)

Purpose:
- Satu service bisa punya multiple categories
- Setiap category punya harga berbeda
- Contoh:
  Service: "Custom Portrait"
  ├─ Category: "Sketch" → Price: 100,000
  ├─ Category: "Watercolor" → Price: 300,000
  └─ Category: "Oil Paint" → Price: 500,000

Pivot Relationship:
$service->categories() → Collection of categories
  with attributes: name, pivot.price
```

#### 5. **Categories Table**
```
Columns:
├─ category_id (PK, bigint)
├─ name (string, unique)
├─ created_at, updated_at (timestamps)

Relationships:
├─ hasMany: Artworks (via artworks.category_id)
├─ belongsToMany: Services (via service_categories)
└─ hasMany: Orders (via services)

Examples:
├─ Painting
├─ Sculpture
├─ Digital Art
├─ Photography
└─ ... (dynamic, user dapat create)
```

#### 6. **Orders Table**
```
Columns:
├─ order_id (PK, bigint)
├─ service_id (FK) → service yang dipesan
├─ buyer_id (FK) → user yang beli
├─ category_id (FK, nullable) → kategori yang dipilih
├─ status (enum: pending, approved, completed, delivered)
├─ total_price (decimal: 10,2)
├─ notes (text, nullable)
├─ created_at, updated_at (timestamps)

Relationships:
├─ belongsTo: Service (service_id)
├─ belongsTo: User (buyer_id) as 'buyer'
├─ hasMany: OrderChat (order_id)
├─ hasOne: Payment (order_id)
└─ hasMany: Reviews (order_id)

Status Workflow:
pending → approved → completed → delivered

Key Points:
- Tracks who ordered what service
- Price bisa berbeda per category (dari pivot)
- Linked ke payment & chat
```

#### 7. **OrderChat Table**
```
Columns:
├─ id (PK)
├─ order_id (FK)
├─ user_id (FK) → who sends message
├─ message (text)
├─ created_at, updated_at

Purpose:
- Real-time communication antara artist & buyer
- Discussion tentang order details

Key Points:
- Setiap order bisa punya multiple chats
- User_id untuk identify sender (artist vs buyer)
```

#### 8. **Payments Table**
```
Columns:
├─ payment_id (PK)
├─ order_id (FK, unique)
├─ amount (decimal)
├─ status (enum: pending, paid, failed)
├─ payment_method (string: bank_transfer, credit_card, etc)
├─ transaction_id (string, nullable)
├─ created_at, updated_at

Purpose:
- Track payment untuk setiap order
- Integrasi dengan payment gateway (future)

Key Points:
- One-to-one relationship dengan Order
- Status workflow tracking
```

#### 9. **Reviews Table**
```
Columns:
├─ review_id (PK)
├─ user_id (FK) → reviewer (pembeli)
├─ service_id (FK, nullable) → bisa untuk service
├─ artwork_id (FK, nullable) → atau untuk artwork
├─ rating (integer: 1-5)
├─ comment (text, nullable)
├─ created_at, updated_at

Purpose:
- Rating & review untuk artworks dan services

Key Points:
- Polymorphic-style (bisa refer ke service atau artwork)
- Penting untuk reputation system
```

---

## 🔑 KEY DESIGN DECISIONS

### 1. **Many-to-Many Service-Categories dengan Pivot**

**Mengapa?**
- Service bisa punya multiple options/kategori
- Setiap kategori punya harga berbeda
- Fleksibel untuk berbagai jenis commission

**Implementation:**
```php
// Model Service
public function categories()
{
    return $this->belongsToMany(
        Category::class, 
        'service_categories',      // Pivot table name
        'service_id',              // FK di pivot untuk service
        'category_id'              // FK di pivot untuk category
    )
    ->withPivot('price')           // Include price dari pivot
    ->withTimestamps();            // Include created_at, updated_at
}

// Usage:
$service->categories()->get();  // All categories
$service->categories[0]->pivot->price;  // Price for specific category

// Attach dengan harga:
$service->categories()->attach($categoryId, ['price' => 300000]);

// Detach:
$service->categories()->detach();

// Update pivot:
$service->categories()->sync([
    $cat1_id => ['price' => 100000],
    $cat2_id => ['price' => 200000]
]);
```

### 2. **Foreign Keys dengan Cascading Delete**

**Pattern:**
```php
Schema::create('services', function(Blueprint $table) {
    $table->id('service_id');
    $table->unsignedBigInteger('user_id');
    $table->foreign('user_id')
        ->references('user_id')
        ->on('users')
        ->onDelete('cascade');  // Jika user delete, service ikut delete
});
```

**Benefit:**
- Data integrity terjaga
- No orphaned records
- Automatic cleanup

### 3. **Timestamps untuk Audit Trail**

```php
$table->timestamps();  // created_at, updated_at
```

**Usage:**
- Track kapan record dibuat/diubah
- Sorting by latest
- Audit trail untuk business logic

---

## 👨‍💻 MODEL RELATIONSHIPS (ELOQUENT ORM)

### Diagram:
```
User
├─ artworks() → hasMany(Artwork)
├─ services() → hasMany(Service)
├─ orders() → hasMany(Order, 'buyer_id')
└─ reviews() → hasMany(Review)

Artwork
├─ artist() → belongsTo(User, 'user_id')
├─ category() → belongsTo(Category)
└─ reviews() → hasMany(Review, 'artwork_id')

Service ⭐
├─ artist() → belongsTo(User, 'user_id')
├─ categories() → belongsToMany(Category) with pivot.price
├─ orders() → hasMany(Order)
└─ reviews() → hasMany(Review, 'service_id')

Order
├─ service() → belongsTo(Service)
├─ buyer() → belongsTo(User, 'buyer_id')
├─ chats() → hasMany(OrderChat)
└─ payment() → hasOne(Payment)

Category
├─ artworks() → hasMany(Artwork)
└─ services() → belongsToMany(Service) with pivot.price
```

---

## 🎮 BAGIAN 3: CONTROLLERS & LOGIC

### ServiceController - Key Methods:

#### 1. **create()**
```php
public function create()
{
    // Check: Artist must have WhatsApp number
    if (Auth::user()->role === 'artist' && 
        empty(Auth::user()->whatsapp_link)) {
        return redirect()->route('services.index')
            ->with('error', 'Add WhatsApp number first');
    }
    
    return view('services.create');
}
```

**Logic:**
- Ensure artist profile complete
- Prevent incomplete service listings

#### 2. **store()** - Create Service with Image & Categories
```php
public function store(Request $r)
{
    // Validation
    $r->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'base_price' => 'required|numeric|min:0',
        'expected_duration' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'categories' => 'nullable|json',  // JSON array
    ]);

    // Handle Image Upload
    $thumbnail = null;
    if ($r->hasFile('image')) {
        // Store image ke: storage/app/public/services/
        $path = $r->file('image')->store('services', 'public');
        $thumbnail = $path;
    }

    // Create Service
    $service = Service::create([
        'user_id' => Auth::id(),
        'title' => $r->title,
        'description' => $r->description,
        'base_price' => $r->base_price,
        'expected_duration' => $r->expected_duration,
        'thumbnail' => $thumbnail,  // Path ke storage
        'status' => 'active',
    ]);

    // Process Categories (dari JSON frontend)
    if ($r->categories) {
        $categoriesData = json_decode($r->categories, true);
        
        if (is_array($categoriesData)) {
            foreach ($categoriesData as $catData) {
                // Find or create category
                $category = Category::where('name', $catData['name'])->first();
                if (!$category) {
                    $category = Category::create(['name' => $catData['name']]);
                }
                
                // Attach dengan harga
                $service->categories()->attach($category->category_id, [
                    'price' => $catData['price']
                ]);
            }
        }
    }

    return redirect()->route('services.index')
        ->with('success', 'Service created');
}
```

**Key Points:**
- Image stored sebagai path (bukan full URL)
- Categories dikirim sebagai JSON dari frontend
- Decode JSON → loop → attach dengan price
- Atomic transaction untuk data integrity

#### 3. **edit()** - Load Service untuk Edit
```php
public function edit(Service $service)
{
    // Authorization check
    if (!Auth::check() || 
        (Auth::user()->role !== 'admin' && 
         Auth::id() !== $service->user_id)) {
        abort(403);  // Forbidden
    }

    // Load relationships
    $service->load('categories');
    $categories = Category::all();
    
    return view('services.edit', compact('service', 'categories'));
}
```

**Authorization Pattern:**
```
Allowed:
├─ User yang membuat service
└─ Admin (super user)

Denied:
├─ Other users (403 Forbidden)
└─ Anonymous (redirect to login)
```

#### 4. **update()** - Edit Service with Image Replacement
```php
public function update(Request $r, Service $service)
{
    // Authorization
    if (!Auth::check() || 
        (Auth::user()->role !== 'admin' && 
         Auth::id() !== $service->user_id)) {
        abort(403);
    }

    // Validation
    $r->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'base_price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'categories' => 'nullable|json',
        'status' => 'required|in:active,inactive',
    ]);

    // Handle Image Update
    $thumbnail = $service->thumbnail;  // Keep existing
    if ($r->hasFile('image')) {
        // Delete old image
        if ($service->thumbnail) {
            Storage::disk('public')->delete($service->thumbnail);
        }
        
        // Store new image
        $path = $r->file('image')->store('services', 'public');
        $thumbnail = $path;
    }

    // Update Service
    $service->update([
        'title' => $r->title,
        'description' => $r->description,
        'base_price' => $r->base_price,
        'expected_duration' => $r->expected_duration,
        'thumbnail' => $thumbnail,
        'status' => $r->status,
    ]);

    // Update Categories
    if ($r->categories) {
        // Detach all old categories
        $service->categories()->detach();
        
        // Attach new categories
        $categoriesData = json_decode($r->categories, true);
        
        if (is_array($categoriesData)) {
            foreach ($categoriesData as $catData) {
                $category = Category::where('name', $catData['name'])->first();
                if (!$category) {
                    $category = Category::create(['name' => $catData['name']]);
                }
                
                $service->categories()->attach($category->category_id, [
                    'price' => $catData['price']
                ]);
            }
        }
    }

    return redirect()->route('services.index')
        ->with('success', 'Service updated');
}
```

**Important Pattern:**
```
Old Image Deletion:
1. Check if thumbnail exists
2. Delete dari storage
3. Store new image
4. Update database

Category Sync:
1. Detach all (clean slate)
2. Attach new ones with prices
(Lebih safe daripada sync)
```

---

## 💾 FILE STORAGE & SYMLINK

### Directory Structure:
```
storage/
├─ app/
│  ├─ private/               (Default, not web-accessible)
│  └─ public/                (Web-accessible via symlink)
│     ├─ artworks/           (Artwork images)
│     │  └─ uuid-1234.jpg
│     └─ services/           (Service thumbnails)
│        └─ uuid-5678.jpg
└─ logs/

public/
├─ storage → symlink to ../storage/app/public
│  ├─ artworks/
│  └─ services/
├─ index.php
└─ ...other files
```

### Symlink Setup:
```bash
# Create symlink
php artisan storage:link

# Ini creates: public/storage → storage/app/public
```

### Why Symlink?
```
Problem:
├─ Files di storage/ tidak accessible dari web
├─ Need to serve files publicly
└─ Keep files outside webroot for security

Solution:
├─ Create symlink di public/
├─ Now files accessible via public/storage/
└─ Laravel: asset('storage/...')
```

### File Upload Flow:
```
Frontend:
├─ User select image file
└─ POST to /services (multipart/form-data)

Controller:
├─ Validate: isImage, max 2MB
├─ Store: $path = $file->store('services', 'public')
│  └─ Path: 'services/uuid-hash.jpg'
├─ Save path to DB: $service->thumbnail = $path
└─ Return response

Frontend Display:
├─ Load service: $service->thumbnail
├─ URL: asset('storage/' . $service->thumbnail)
├─ Result: /public/storage/services/uuid-hash.jpg
└─ Browser renders image
```

---

## 🔒 VALIDATION & AUTHORIZATION

### Input Validation:

**Service Store/Update:**
```php
[
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'base_price' => 'required|numeric|min:0',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'categories' => 'nullable|json',
    'status' => 'required|in:active,inactive'
]

Explanation:
├─ required: Harus ada
├─ nullable: Optional
├─ string, numeric: Data type check
├─ max:2048: File size (KB)
├─ image: Must be image file
├─ mimes: Allowed formats
├─ in: Allowed values only
└─ json: Valid JSON format
```

### Authorization Pattern:

**Method 1: Manual Check dalam Controller**
```php
if (!Auth::check() || 
    (Auth::user()->role !== 'admin' && 
     Auth::id() !== $service->user_id)) {
    abort(403);  // Forbidden
}
```

**Method 2: Authorization Policy (Best Practice)**
```php
// app/Policies/ServicePolicy.php
public function update(User $user, Service $service)
{
    return $user->role === 'admin' || 
           $user->id === $service->user_id;
}

// In Controller:
$this->authorize('update', $service);
```

---

## 🎬 BAGIAN 4: FILE STORAGE CHALLENGES & SOLUTIONS

### Challenge 1: Images Not Displaying

**Problem:**
- User upload image → stored di storage/
- Try to display in view → tidak muncul
- Browser error: 404 Not Found

**Root Cause:**
- Symlink public/storage tidak exist
- Files di storage/ tidak accessible dari web

**Solution:**
```bash
# Run this command
php artisan storage:link

# Verify symlink created
# Output: Link created!
```

**Verification:**
```php
// In view
@if($service->thumbnail)
    <!-- ✅ Correct -->
    <img src="{{ asset('storage/' . $service->thumbnail) }}">
    
    <!-- ❌ Wrong -->
    <img src="{{ $service->thumbnail }}">
@endif
```

### Challenge 2: Old Image Not Deleted on Update

**Problem:**
- User upload image #1 → stored
- User edit service, upload image #2
- Old image #1 still exists in storage (waste space)

**Solution:**
```php
if ($r->hasFile('image')) {
    // Delete old image first
    if ($service->thumbnail) {
        Storage::disk('public')->delete($service->thumbnail);
    }
    
    // Store new image
    $path = $r->file('image')->store('services', 'public');
    $service->thumbnail = $path;
}
```

### Challenge 3: Flexible Pricing Per Category

**Problem:**
- Service: "Custom Portrait"
- Multiple options dengan harga berbeda
- Bagaimana store di database?

**Solutions:**
1. ❌ Separate columns (not scalable)
2. ❌ JSON column (hard to query)
3. ✅ Pivot table with price (best practice)

**Implementation:**
```
service_categories table:
├─ service_id: 1
├─ category_id: 5 (Portrait)
├─ price: 500000

├─ service_id: 1
├─ category_id: 6 (Sketch)
└─ price: 200000
```

**Query:**
```php
$service->categories()->with('pivot')->get();
// Result:
// [
//   {id: 5, name: "Portrait", pivot: {price: 500000}},
//   {id: 6, name: "Sketch", pivot: {price: 200000}}
// ]
```

---

## 📊 MIGRATION & SCHEMA MANAGEMENT

### Migration File Example:

```php
// database/migrations/2025_12_02_030404_create_services_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('services', function(Blueprint $table) {
            // Primary Key
            $table->id('service_id');
            
            // Foreign Keys
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();
            
            // Service Data
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->string('expected_duration')->nullable();
            $table->string('thumbnail')->nullable();  // Image path
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            // Timestamps
            $table->timestamps();
            
            // Constraints
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories')
                ->nullOnDelete();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
```

### Running Migrations:

```bash
# Create new tables
php artisan migrate

# Rollback last batch
php artisan migrate:rollback

# Rollback specific migration
php artisan migrate:rollback --step=1

# Reset all (development only!)
php artisan migrate:reset
```

---

## ✅ TESTING CHECKLIST

### Manual Testing:

```
Service Creation:
☐ Form validation works (required fields)
☐ Image upload accepted (jpg, png, gif, max 2MB)
☐ Invalid image rejected
☐ Categories added dynamically (frontend JS)
☐ JSON categories encode correctly
☐ Service created in database
☐ Image stored di storage/app/public/services/
☐ Thumbnail path saved to DB

Service Display:
☐ Service appears in list
☐ Thumbnail image displays correctly
☐ Categories visible dengan harga
☐ Click service → detail page works

Service Edit:
☐ Load existing data correctly
☐ Load existing thumbnail
☐ Load existing categories
☐ Can replace image
☐ Old image deleted from storage
☐ New image stored
☐ Categories can be updated
☐ Save changes successfully

Authorization:
☐ Non-creator cannot edit
☐ Admin can edit any service
☐ Anonymous user redirected to login
☐ 403 Forbidden displayed when denied

Edge Cases:
☐ Edit without changing image (keep existing)
☐ Edit with image (replace)
☐ Edit with no categories
☐ Edit with new categories
☐ Delete service → image also deleted
```

---

## 🚀 DEPLOYMENT NOTES

### Requirements:
```
1. Storage Directory Writable:
   └─ chmod 755 storage/

2. Create Symlink:
   └─ php artisan storage:link

3. Environment Config:
   └─ FILESYSTEM_DISK=public (in .env)

4. Permissions:
   └─ storage/app/public/* readable by web server
```

### Backup Strategy:
```
Important:
├─ Database backups (MySQL/SQLite)
└─ storage/app/public/ backups (uploaded files)

Scripts:
├─ Daily database backup
├─ Weekly file backup
└─ Keep 30 days retention
```

---

## 📝 SUMMARY - KEY LEARNINGS

✅ **Database Design:**
- Normalization & relationships
- Foreign keys & cascading
- Pivot tables for flexibility

✅ **File Management:**
- Symlinks for web accessibility
- Validation (type, size)
- Secure storage location

✅ **Authorization:**
- Role-based access control
- Ownership checks
- Admin override capability

✅ **Eloquent ORM:**
- Model relationships (hasMany, belongsTo, belongsToMany)
- Query optimization (load relationships)
- Pivot data handling (withPivot)

✅ **Form Handling:**
- JSON serialization for complex data
- Dynamic field management
- Validation on both client & server

---

## 🎓 NOTES UNTUK PRESENTASI:

**Opening:**
```
"Saya akan menjelaskan technical architecture Artspace, 
mulai dari database design, bagaimana data tersimpan dan terrelasi, 
hingga implementasi service creation dengan image upload dan 
flexible category pricing system."
```

**Closing:**
```
"Key takeaway adalah bagaimana kita menggunakan pivot table 
untuk memberikan fleksibilitas pricing, dan proper file storage 
management untuk handle uploaded images dengan aman dan accessible."
```

---

**Prepared by:** Technical Lead  
**Last Updated:** January 5, 2026  
**Duration:** ~25 minutes (combined parts 1,2,4)
