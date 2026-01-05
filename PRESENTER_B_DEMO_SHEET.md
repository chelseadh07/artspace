# 📚 ARTSPACE - PRESENTER B SHEET (USER FLOW & DEMO)
## Study Guide untuk Presenter B

---

## 🎯 BAGIAN 1: USER JOURNEY & FLOW (10 menit)

### USER TYPES & THEIR JOURNEYS:

#### 1. **ARTIST WORKFLOW** 

**Journey: Create Service → Upload Image & Categories**

```
┌─ DASHBOARD ─┐
│   "My Art"  │
└─────┬───────┘
      │
      ▼
┌──────────────────────────────┐
│  Services Management         │
│  [Create Service] [Edit] [View]
└──────────┬───────────────────┘
           │
           ▼
    ┌─────────────────┐
    │  CREATE SERVICE │
    │  Form Fills:    │
    │ ├─ Title        │
    │ ├─ Description  │
    │ ├─ Base Price   │
    │ ├─ Duration     │
    │ ├─ Image        │
    │ └─ Categories + │
    │    Prices       │
    └────────┬────────┘
             │
             ▼
    ┌─────────────────────┐
    │  Database Create    │
    │ ├─ Service record   │
    │ ├─ Image stored     │
    │ └─ Categories pivot │
    └────────┬────────────┘
             │
             ▼
    ┌─────────────────┐
    │  Service Listed │
    │  Ready for sale │
    └─────────────────┘
```

**Demo Script:**
```
"Saya sebagai artist, buka dashboard saya. 
Di sini saya bisa kelola services yang saya tawarkan. 

Saya click 'Create Service'. Muncul form:
- Title: 'Custom Portrait Painting'
- Description: Detail tentang layanan
- Base Price: 500.000 Rp
- Expected Duration: '3-5 hari'

Terus saya upload foto/thumbnail untuk preview layanan. ✅

Bagian paling menarik - Categories with Different Prices:
- Add Category 1: 'Sketch Portrait' - Harga 200.000
- Add Category 2: 'Watercolor' - Harga 400.000
- Add Category 3: 'Oil Painting' - Harga 600.000

Jadi customer nanti bisa pilih level/varian yang mereka mau, 
dengan harga berbeda-beda. Sangat flexible!

Saya click Submit → Service berhasil dibuat dan langsung listed."
```

---

#### 2. **BUYER WORKFLOW**

**Journey: Browse → Order → Chat → Review**

```
┌──────────────────┐
│  Browse Services │
│  Filter by...    │
│  Search for...   │
└────────┬─────────┘
         │
         ▼
┌──────────────────────┐
│  Service Detail Page │
│ ├─ Thumbnail image   │
│ ├─ Description       │
│ ├─ Artist Info       │
│ ├─ Categories List   │
│ │  ├─ Sketch: 200K   │
│ │  ├─ Watercolor: 400K
│ │  └─ Oil: 600K      │
│ └─ Reviews/Ratings   │
└────────┬─────────────┘
         │
         ▼
   ┌──────────────┐
   │ Select Category
   │  (Choose harga)
   └──────┬───────┘
          │
          ▼
    ┌─────────────┐
    │ CREATE ORDER│
    │ Cart Summary│
    └──────┬──────┘
           │
           ▼
   ┌──────────────────┐
   │  Order Details   │
   │ - Service name   │
   │ - Category       │
   │ - Price          │
   │ - Artist info    │
   └─────┬────────────┘
         │
         ▼
   ┌──────────────┐
   │ CHAT & INFO  │
   │ Ask artist   │
   │ about detail │
   └──────┬───────┘
          │
          ▼
   ┌──────────────┐
   │  PAYMENT     │
   │  Process pay │
   └──────┬───────┘
          │
          ▼
   ┌──────────────┐
   │  IN PROGRESS │
   │  Track status│
   └──────┬───────┘
          │
          ▼
   ┌──────────────┐
   │  COMPLETED   │
   │  Leave review│
   │  Give rating │
   └──────────────┘
```

**Demo Script:**
```
"Saya sebagai buyer, masuk ke halaman Services. 

Saya lihat berbagai service dari artists.
Saya interested dengan 'Custom Portrait Painting' dari Artist X.

Saya click service itu. Detail page muncul:
- Lihat thumbnail image dari artist (preview kualitas)
- Baca description
- Lihat profile artist (rating, review dari pembeli lain)
- Lihat kategori + harga:
  * Sketch Portrait: 200.000
  * Watercolor: 400.000
  * Oil Painting: 600.000

Saya interested dengan Watercolor (400K).
Saya click 'Order' atau 'Commission'.

Form muncul:
- Service: Custom Portrait
- Category: Watercolor (400.000)
- Notes/Requirement: (saya bisa input detail, fotoku, dll)

Submit → Order dibuat.

Sekarang saya bisa chat langsung dengan artist itu:
'Hi, saya mau watercolor portrait based on photo ini...'

Artist reply real-time dengan pertanyaan/klarifikasi.

Nanti setelah setuju, saya bisa process payment.

Setelah selesai, saya bisa leave review + rating untuk artist."
```

---

#### 3. **ADMIN WORKFLOW**

**Dashboard & Moderation**

```
┌──────────────┐
│ Admin Panel  │
└──────┬───────┘
       │
       ├─► User Management
       │   ├─ View users
       │   ├─ Ban/approve
       │   └─ Reset password
       │
       ├─► Content Moderation
       │   ├─ Review services
       │   ├─ Review artworks
       │   └─ Remove if violation
       │
       ├─► Reports & Analytics
       │   ├─ Total transactions
       │   ├─ Revenue
       │   ├─ Most popular services
       │   └─ User growth
       │
       └─► System Settings
           ├─ Commission rates
           ├─ Category management
           └─ Platform rules
```

---

## 📱 FEATURE WALKTHROUGH

### FEATURE 1: ARTWORKS GALLERY

**What:**
- Showcase finished artwork
- Gallery-style display
- Searchable & filterable

**Demo Flow:**
```
Home → Browse Artworks
├─ Grid view of artworks
├─ Filter by category (Painting, Digital Art, etc)
├─ Search by title/artist
│
Click artwork:
├─ Full image
├─ Artist profile
├─ Description
├─ Reviews/Ratings
└─ Option: Contact artist for commission
```

**Key Points:**
- Showcase portfolio
- Build artist reputation
- Gateway to commission (services)

---

### FEATURE 2: SERVICES LISTING ⭐ (MAIN FOCUS)

**What:**
- Artists offer custom commission services
- Flexible pricing per category/option
- Real-time order management

**The Flow - Creating a Service:**

```
SCENARIO: Portrait Artist Setup Service

Step 1: Fill Basic Info
├─ Title: "Custom Digital Portrait"
├─ Description: "I'll create a digital portrait of you, 
│   can be realistic or stylized"
├─ Base Price: 500,000 (starting price)
└─ Expected Duration: "5-7 days"

Step 2: Upload Thumbnail/Preview Image
├─ This is IMPORTANT for attraction
├─ Shows style & quality to buyers
├─ Max 2MB, formats: JPG, PNG, GIF

Step 3: Add Service Categories/Variants
├─ Add Category #1:
│  └─ Name: "Full Body Colored" → Price: 800,000
├─ Add Category #2:
│  └─ Name: "Bust Portrait Colored" → Price: 600,000
├─ Add Category #3:
│  └─ Name: "Sketch Bust" → Price: 300,000

Result: 1 Service, 3 Price Options
```

**Visual Example:**
```
SERVICE PAGE (Customer View):
┌─────────────────────────────────┐
│ [Thumbnail Image]               │
├─────────────────────────────────┤
│ Custom Digital Portrait         │
│ By: Artist Name ⭐⭐⭐⭐         │
├─────────────────────────────────┤
│ Description...                  │
├─────────────────────────────────┤
│ Available Options:              │
│ ☐ Full Body Colored  - 800K     │
│ ☐ Bust Portrait - 600K          │
│ ☐ Sketch Bust - 300K            │
├─────────────────────────────────┤
│ [Select option & Order]         │
└─────────────────────────────────┘
```

**Why Categories with Different Prices?**

```
Traditional (Bad):
├─ Create separate service untuk setiap option
├─ "Custom Portrait 1" vs "Custom Portrait 2"
├─ Confusing untuk customer
└─ Duplicate service info

This Project (Good):
├─ 1 Service dengan multiple categories
├─ Jelas = sama service, beda variant
├─ Customer pilih variant yang diinginkan
└─ Harga flexible per variant
```

---

### FEATURE 3: ORDER & COMMISSION SYSTEM

**Order Lifecycle:**

```
PENDING (Initial)
    ↓
APPROVED (Artist accepted)
    ↓
IN_PROGRESS (Artist working)
    ↓
COMPLETED (Work done, awaiting delivery)
    ↓
DELIVERED (Delivered to buyer)
    ↓
REVIEW & RATING
```

**Order Details:**
```
Order ID: #12345
Service: Custom Portrait
Category Selected: Watercolor (400K)
Artist: Budi (⭐⭐⭐⭐⭐)
Buyer: Andi
Status: IN_PROGRESS
Deadline: Jan 15, 2026

ORDER NOTES:
"I want portrait style like (linked reference image).
Face should be centered. Include background with my hobby items."

CHAT HISTORY:
Jan 5, 10:30 AM - Andi:
"Hi Budi, seneng dengan style kamu. 
Bisa bikin portrait seperti attached photo?"

Jan 5, 11:00 AM - Budi:
"Halo! Bisa banget. Stylenya keren! 
Butuh detail lagi - background preferencenya apa?"

Jan 5, 11:15 AM - Andi:
"Preferably nature background atau abstract?"

Jan 5, 11:30 AM - Budi:
"Keduanya bisa. Saya rekomen nature, lebih cocok dengan style kamu.
Saya mulai draft hari ini, estimasi selesai Jan 13."

Jan 5, 11:45 AM - Andi:
"Sip, terima kasih!!"
```

**Payment Integration:**
```
Before Order Completion:
├─ Payment status visible
├─ Artist can see payment received
└─ Money held in escrow until delivery

After Delivery:
├─ Buyer marks as received
├─ Funds release to artist
└─ Buyer can leave review
```

---

### FEATURE 4: IMAGE MANAGEMENT (NEW)

**Service Image/Thumbnail:**

```
CREATE SERVICE:
├─ Choose file
├─ Validation:
│  ├─ Must be image (JPG, PNG, GIF)
│  ├─ Max size 2MB
│  └─ Auto reject if invalid
├─ Upload → stored in storage/app/public/services/
├─ Database save path: "services/uuid-hash.jpg"
└─ Display via: asset('storage/services/uuid-hash.jpg')

EDIT SERVICE:
├─ See current thumbnail
├─ Option 1: Keep existing
│  └─ Leave file input empty
├─ Option 2: Replace with new
│  ├─ Select new file
│  ├─ Old file auto-deleted from storage
│  ├─ New file stored
│  └─ Path updated in database
└─ Shows success/error message

SAFETY:
├─ Files stored OUTSIDE webroot initially
├─ Served via symlink (secure)
├─ Size limit prevents abuse
└─ Format validation prevents malicious files
```

**Why This Matters:**

```
Without proper image management:
❌ Old files pile up (storage waste)
❌ Images might not display (path issues)
❌ Security vulnerabilities (invalid files)
❌ Slow page load (large images)

With proper management:
✅ Old files auto-deleted
✅ Images display correctly
✅ Secure file handling
✅ Performance optimized
```

---

## 🎬 LIVE DEMO SCRIPT

### DEMO PART 1: ARTIST CREATING SERVICE (8 minutes)

**Setup:** Login as Artist

```
"Sekarang saya akan demo menjadi artist. Saya sudah login.

Saya go ke Dashboard → Services section.

Saya click 'Create Service'. Form muncul dengan fields:

Title: [Custom Pet Portrait] ← (type)
Description: [I will create beautiful digital portrait 
              of your beloved pet...] ← (type)

Base Price: [750000] ← (type in Indonesian Rupiah)
Duration: [5-7 business days] ← (type)

Terus ada File Upload untuk THUMBNAIL/PREVIEW IMAGE:
- Saya click 'Choose File'
- Saya select portrait-style-sample.jpg dari komputer saya
- File showing di preview ✓

Categories Section (DYNAMIC - Paling Important):
Saya lihat button 'Add Category'

Category #1:
- Input 'Sketch Portrait'
- Price: 300000
- Click 'Add'
- Category #1 muncul di list ✓

Category #2:
- Input 'Colored Digital'
- Price: 600000
- Click 'Add'
- Category #2 muncul di list ✓

Category #3:
- Input 'High Detail Oil Style'
- Price: 900000
- Click 'Add'
- Category #3 muncul di list ✓

Summary sebelum submit:
- 1 Service
- 1 Thumbnail image
- 3 Categories dengan 3 price points

Saya click 'Create Service' → Processing...

Success! Service created.
Redirect ke service detail page. Saya lihat:
- Thumbnail image tampil ✓
- Title, description visible ✓
- 3 Categories dengan harga masing-masing ✓

Service sekarang LIVE untuk buyers browse dan order."
```

---

### DEMO PART 2: BUYER VIEWING & ORDERING (5 minutes)

**Setup:** Login as Buyer (or browse as guest)

```
"Sekarang switch ke perspective buyer.

Saya go ke Services → Browse.
Saya lihat grid dari berbagai services.

Saya searching 'Pet Portrait'.
Hasil muncul - saya lihat service yang baru kita create.

Saya click service itu:

SERVICE DETAIL PAGE muncul:
┌─────────────────────────┐
│ [Portrait Thumbnail]    │ ← Image yang kita upload
├─────────────────────────┤
│ Custom Pet Portrait     │
│ By: Budi (Rating: ⭐⭐⭐⭐⭐)
│ Est. Delivery: 5-7 days │
├─────────────────────────┤
│ Description of service  │
├─────────────────────────┤
│ Available Options:      │
│ ☐ Sketch Portrait - 300K│
│ ☐ Colored Digital - 600K│
│ ☐ Oil Style - 900K      │
├─────────────────────────┤
│ [Select Option & Order] │
└─────────────────────────┘

Saya interested dengan 'Colored Digital - 600K'.
Saya click option + Order button.

Form muncul:
- Service: Custom Pet Portrait
- Category: Colored Digital
- Price: 600,000 Rp
- Notes: [I want portrait of my dog, Fluffy. Attached photos below]

[Attach photo of dog]

Submit Order → Order created!

Confirmation page:
'Order created successfully! #ORD-12345'
'You can now chat with artist.'

Chat section:
Me: 'Hi! Saya order Colored Digital portrait dari dog saya.'

[Waiting for artist response...]

(In real scenario, artist akan reply dalam hitungan menit)"
```

---

### DEMO PART 3: EDIT SERVICE (4 minutes)

**Setup:** Back to Artist Dashboard

```
"Saya balik ke artist perspective.

Setelah beberapa hari, saya mau update service saya.
Mungkin saya mau improve thumbnail, atau add kategori baru.

Go to Dashboard → My Services → Edit.

EDIT SERVICE FORM:
- All existing data pre-loaded
  * Title, description, price, duration ✓
  * Current thumbnail image showing ✓
  * Existing categories loading ✓

SCENARIO: Replace thumbnail dengan versi yang lebih bagus

Di thumbnail section:
- [Current Image] showing
- File input: [Choose File]
- Saya select: new-portfolio-sample.jpg

Status: [Active] ← dropdown untuk active/inactive

SCENARIO: Update categories - add category baru

Categories section (Pre-loaded dari database):
Existing:
- Sketch Portrait - 300K
- Colored Digital - 600K
- Oil Style - 900K

Saya add category baru:
- Input: 'Quick Sketch'
- Price: 150000
- Click Add

Saya bisa juga remove category yang tidak diinginkan:
- Click 'X' di Oil Style
- Oil Style dihapus dari list

Result sekarang:
- Sketch Portrait - 300K
- Colored Digital - 600K
- Quick Sketch - 150K

Submit Changes → Processing...

Success! Service updated.
- New thumbnail saved, old thumbnail auto-deleted ✓
- Categories updated ✓
- Changes live immediately ✓

Back to service page:
- New thumbnail tampil
- New category list visible
- All changes reflected"
```

---

## 🔄 KEY CONCEPTS FOR DEMO

### 1. **Image Upload Flow**
```
User Select File
    ↓
Browser Validation (type, size)
    ↓
Upload to Server
    ↓
Server Validation (again, for security)
    ↓
Store in storage/app/public/services/
    ↓
Save Path to Database: "services/uuid.jpg"
    ↓
Display via: asset('storage/services/uuid.jpg')
```

### 2. **Category with Pricing**
```
Frontend (JavaScript):
├─ Collect category name + price
├─ JSON encode: [{name: "Sketch", price: 300000}, ...]
└─ Send as hidden form input

Backend (Controller):
├─ Decode JSON
├─ Loop through categories
├─ Find/create category in DB
├─ Attach to service with price in pivot
└─ Save to database

Database (Relationships):
Service (1)  →  ServiceCategories (Many)  ←  Category (Many)
             with pivot.price
```

### 3. **Edit = Detach Old, Attach New**
```
Edit Service Categories:

Old state: [Sketch, Colored, Oil]
New state: [Sketch, Colored, Quick Sketch]

Process:
1. Detach all → [empty]
2. Attach new → [Sketch, Colored, Quick Sketch]

(Instead of trying to sync/update, safer to delete & recreate)
```

---

## ✨ POINTS TO HIGHLIGHT DURING PRESENTATION

### 1. **What Makes Artspace Different:**
```
Problem: 
- Artists sulit menawarkan multiple options dengan harga berbeda
- Buyers confuse dengan banyak service listing

Solution (Artspace):
- 1 Service = Multiple categories/variants
- Clear structure: Same service, different options
- Flexible pricing per variant
```

### 2. **Image Upload Importance:**
```
Why Thumbnail Matters:
├─ First impression untuk buyers
├─ Showcase artist style & quality
├─ Significantly increase commission rate
└─ Professional appearance

Technical Excellence:
├─ Proper file validation
├─ Secure storage outside webroot
├─ Old files cleaned up
└─ Fast, reliable display
```

### 3. **User Experience Flow:**
```
ARTIST: Straightforward creation
├─ Add service
├─ Upload thumbnail
├─ Set categories + prices
└─ Live immediately

BUYER: Easy browsing & ordering
├─ See thumbnail preview
├─ Choose variant
├─ Order with clear price
└─ Communicate with artist
```

---

## 📝 DEMO CHECKLIST

Before Demo:
```
☐ Create test artist account with WhatsApp number
☐ Prepare sample images (portrait) for upload
☐ Prepare test buyer account
☐ Test service creation end-to-end
☐ Test image display
☐ Test category creation & pricing
☐ Test edit flow (change image + categories)
☐ Test order creation
☐ Prepare screenshot backups (if demo fails)
```

During Demo:
```
☐ Speak clearly & slowly
☐ Point at screen when explaining
☐ Explain what you're doing before doing it
☐ Show database results if possible (artisan tinker)
☐ Handle errors gracefully ("Let me try again...")
☐ Answer questions from dosen
☐ Timing: ~20 minutes total demo
```

---

## 💡 EXPECTED QUESTIONS & ANSWERS

**Q: Bagaimana kalau file terlalu besar?**
```
A: System ada validasi:
   ├─ Max file size 2MB
   ├─ Browser reject jika lebih besar
   └─ Server double-check untuk security
```

**Q: Bagaimana kalau file format invalid?**
```
A: Validation mencegah:
   ├─ Only image files allowed (jpg, png, gif)
   ├─ Other formats rejected
   └─ Prevents malicious file upload
```

**Q: Old image di storage tidak dihapus?**
```
A: System auto-delete:
   ├─ Saat update service dengan image baru
   ├─ Old image deleted dari storage
   ├─ Only current image kept
   └─ Saves storage space
```

**Q: Multiple categories - bagaimana di database?**
```
A: Using pivot table:
   ├─ service_categories table
   ├─ Stores: service_id, category_id, price
   ├─ One service can have many categories
   └─ Each category dapat harga berbeda
```

**Q: Bagaimana buyer tahu harga untuk setiap option?**
```
A: Clear display:
   ├─ Service detail page list semua categories
   ├─ Setiap category show price
   ├─ Buyer select category sebelum order
   └─ Price locked ketika order dibuat
```

---

## 🎓 LEARNING OUTCOMES

After presentation, audience should understand:

```
✅ How artists can offer multiple commission options
✅ How flexible pricing works with pivot tables
✅ Importance of proper image management
✅ Full user journey: Artist → Buyer → Order
✅ Why this architecture is scalable & maintainable
✅ Real-world problem solving (image storage, pricing flexibility)
```

---

## 📊 TIMING BREAKDOWN

```
Presenter B Total: ~25 minutes

├─ Introduction (2 min)
│  └─ Overview what I'll show

├─ Feature 1: Artworks Gallery (2 min)
│  └─ Brief overview

├─ Feature 2: Services (detailed) (5 min)
│  ├─ Explain categories + pricing concept
│  └─ Why it's better than alternatives

├─ Feature 3: Order System (2 min)
│  └─ How orders flow

├─ Feature 4: Image Management (2 min)
│  └─ Upload/edit/delete flow

├─ LIVE DEMO (12 min)
│  ├─ Artist creates service (5 min)
│  ├─ Buyer orders service (3 min)
│  └─ Artist edits service (4 min)

├─ Key Highlights (1 min)
│  └─ Summary of important points

└─ Ready for Q&A
```

---

**Prepared by:** Product & Demo Lead  
**Last Updated:** January 5, 2026  
**Duration:** ~25 minutes
