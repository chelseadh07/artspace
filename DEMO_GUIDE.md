# ArtSpace - CRUD Demo Guide

## Quick Start
```bash
php artisan serve
```
Visit `http://localhost:8000`

## Test Credentials

### Admin Role
- **Email:** `admin@test.com`
- **Password:** `admin123`
- **Dashboard:** `/admin/dashboard`
- **Features to demo:**
  - View `/users` - list all users (create/edit/delete)
  - View `/admin/orders` - manage all orders
  - View `/reports` - manage user reports

### Artist Role
- **Email:** `artist@test.com`
- **Password:** `artist123`
- **Dashboard:** `/artist/dashboard`
- **Features to demo:**
  - Upload artworks: `/artworks` (create/edit/delete)
  - Create services: `/services` (create/edit/delete)
  - View incoming orders: `/orders`
  - Confirm payments: `/payments`

### Buyer (Client) Role
- **Email:** `buyer@test.com`
- **Password:** `buyer123`
- **Dashboard:** `/buyer/dashboard`
- **Features to demo:**
  - Browse artworks: `/artworks`
  - Browse services: `/services`
  - Create orders: `/orders/create`
  - Upload payment proofs: `/payments`
  - Review completed orders: `/reviews/create`
  - Chat with artist: `/order_chat`

## Pre-Seeded Data
- **Categories:** Painting, Sculpture, Digital Art, Photography, Graphic Design
- **Sample Artworks:** 
  - "Sunset Dreams" (Painting)
  - "Digital Portrait" (Digital Art)
- **Sample Services:**
  - "Custom Portrait Painting" ($150)
  - "Digital Logo Design" ($100)

## CRUD Flow Examples

### 1. Admin Creating a User
1. Login as admin
2. Navigate to `/users`
3. Click "Create User"
4. Fill form and submit
5. View created user in list

### 2. Artist Uploading Artwork
1. Login as artist
2. Click "Upload Artwork" on dashboard
3. Fill title, description, select category, upload image
4. View in `/artworks`

### 3. Buyer Creating an Order
1. Login as buyer
2. Go to `/services`
3. Select "Custom Portrait Painting"
4. Go to `/orders/create`
5. Select service and artist
6. Order created with status "pending"

### 4. Artist Confirming Payment
1. Login as artist
2. View `/payments`
3. View payment proof
4. Click "Confirm Payment"
5. Order status changes to "in_progress"

### 5. Buyer Leaving a Review
1. Login as buyer
2. After order is finished, go to `/orders`
3. Click on order and go to `/reviews/create`
4. Rate and comment
5. Review visible in `/reviews`

## Database Reset
If you want to reset all data and reseed:
```bash
php artisan migrate:fresh --seed
```

## All Routes
Run `php artisan route:list` to see all available routes (76 total).

## Notes
- Role-based access is enforced via middleware
- Unauthorized access returns 403 Forbidden
- Forms validate input and show errors
- File uploads (images, avatars, payment proofs) stored in `storage/app/public`
- Pagination enabled on list views
