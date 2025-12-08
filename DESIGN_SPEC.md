# ArtSpace - Complete Feature & Design Documentation

## 📋 FITUR UTAMA APLIKASI

### 1. AUTHENTICATION & AUTHORIZATION
**Fitur:**
- Registrasi role-based (Buyer/Artist)
- Login dengan role detection
- Auto-redirect ke dashboard sesuai role
- Logout & session management

**Role yang ada:**
- Admin (manage user, orders, reports)
- Artist (upload artwork, create services, manage orders)
- Buyer/Client (browse, order, payment, review)

---

## 🎨 CRUD OPERATIONS PER RESOURCE

### **1. USERS Management (Admin Only)**
**CRUD:**
- ✅ CREATE: `/users/create` - Form untuk add user (name, email, password, role, bio, avatar)
- ✅ READ: `/users` - List semua users dengan pagination + `/users/{id}` - Detail user
- ✅ UPDATE: `/users/{id}/edit` - Edit user data
- ✅ DELETE: Delete button di list/detail (soft/hard delete)

**Fields:** user_id, name, email, role, bio, avatar, created_at
**Relationships:** Has many artworks, services, orders, chats

---

### **2. ARTWORKS Management (Artist/Admin)**
**CRUD:**
- ✅ CREATE: `/artworks/create` - Upload artwork dengan title, description, category, image
- ✅ READ: `/artworks` - Grid/card view semua artworks + `/artworks/{id}` - Detail dengan full image
- ✅ UPDATE: `/artworks/{id}/edit` - Edit title, description, category, replace image
- ✅ DELETE: Delete button (hapus dari storage juga)

**Fields:** artwork_id, user_id (artist), title, description, image_url, category_id, created_at
**Search:** By title/description
**Relationships:** Belongs to Artist (User), Category

---

### **3. SERVICES Management (Artist/Admin)**
**CRUD:**
- ✅ CREATE: `/services/create` - Form untuk post service (title, description, base_price, duration, category, status)
- ✅ READ: `/services` - Card/list view semua services + `/services/{id}` - Detail service
- ✅ UPDATE: `/services/{id}/edit` - Edit all fields termasuk status (active/inactive)
- ✅ DELETE: Delete service

**Fields:** service_id, user_id (artist), title, description, base_price, expected_duration, category_id, status, created_at
**Search:** By title/description
**Relationships:** Belongs to Artist (User), Category, HasMany Orders

---

### **4. ORDERS Management (Buyer/Artist/Admin)**
**CRUD:**
- ✅ CREATE: `/orders/create` - Buyer select service + artist + request message + optional price override
- ✅ READ: `/orders` - List orders dengan status + `/orders/{id}` - Detail order
- ✅ UPDATE: `/orders/{id}/edit` - Update description, price, status (pending→accepted→in_progress→finished→cancelled)
- ✅ DELETE: Delete order

**Fields:** order_id, client_id, artist_id, service_id, description_request, price, status, created_at
**Search:** By description
**Status flow:** pending → accepted → in_progress → finished / cancelled
**Relationships:** Belongs to Client, Artist, Service; HasMany Payments, OrderChats, Reviews

---

### **5. PAYMENTS Management (Buyer/Artist/Admin)**
**CRUD:**
- ✅ CREATE: `/payments/create` - Buyer upload payment proof (image + amount)
- ✅ READ: `/payments` - List payments + `/payments/{id}` - Detail dengan preview proof image
- ✅ UPDATE (confirm): Artist/Admin confirm payment → payment_status: "waiting_confirmation" → "paid"
- ✅ DELETE: Delete payment record

**Fields:** payment_id, order_id, amount, method, payment_status, payment_proof (image), payment_date
**Payment Status:** waiting_confirmation → paid
**Relationships:** Belongs to Order; Triggers order status change to "in_progress"

---

### **6. REVIEWS Management (Buyer only)**
**CRUD:**
- ✅ CREATE: `/reviews/create` - Only after order finished; rating (1-5) + comment
- ✅ READ: `/reviews` - List all reviews + `/reviews/{id}` - Detail review
- ✅ UPDATE: `/reviews/{id}/edit` - Buyer edit own review (rating, comment)
- ✅ DELETE: Delete own review / admin delete any

**Fields:** id, order_id, client_id, rating (1-5), comment, created_at
**Constraints:** One review per order max
**Relationships:** Belongs to Order, Client

---

### **7. REPORTS Management (User/Admin)**
**CRUD:**
- ✅ CREATE: `/reports/create` - User submit report for another user (pada order yg mereka terlibat)
- ✅ READ: `/reports` - List reports (admin only view all) + detail view
- ✅ UPDATE (status): Admin update report status: open → in_review → resolved
- ✅ DELETE: Reporter / admin delete report

**Fields:** report_id, reported_user_id, reporter_user_id, order_id, message, status, created_at
**Report Status:** open → in_review → resolved
**Relationships:** Belongs to Reported User, Reporter User, Order

---

### **8. NOTIFICATIONS Management (Per-User)**
**CRUD:**
- ✅ READ: `/notifications` - User view own notifications (list with pagination)
- ✅ UPDATE (mark read): Mark notification as read
- ✅ DELETE: Delete notification

**Fields:** id, user_id, message, is_read, created_at
**Auto-trigger:** Order created, payment uploaded, order status changed, review left, report submitted
**Relationships:** Belongs to User

---

### **9. ORDER CHAT Management (Buyer/Artist)**
**CRUD:**
- ✅ CREATE: `/order_chat` - Send message + optional file attachment
- ✅ READ: `/order_chat?order_id={id}` - View chat thread for specific order
- ✅ DELETE: Delete own message / admin delete any

**Fields:** id, order_id, sender_id, message, file_url, created_at
**File types:** jpg, jpeg, png, webp, pdf (max 8MB)
**Relationships:** Belongs to Order, Sender (User)

---

### **10. CATEGORIES Management (Admin)**
**CRUD:**
- ✅ READ: `/categories` - List categories
- ✅ CREATE: `/categories/create` - Add category
- ✅ UPDATE: `/categories/{id}/edit` - Edit category
- ✅ DELETE: Delete category

**Fields:** category_id, name, description
**Relationships:** HasMany Artworks, Services

---

### **11. PROFILE Management (All Authenticated Users)**
**CRUD:**
- ✅ READ: `/profile` - View own profile
- ✅ UPDATE: `/profile` - Edit name, email, password, bio, avatar
- ✅ DELETE: `/profile` - Delete account (soft delete)

---

## 🎯 DASHBOARD PER ROLE

### **Admin Dashboard**
Display:
- Total users, artists, clients count
- Total orders (pending count)
- Total services
- Total payments
- Open reports count
Quick links: Manage Users, Manage Orders, View Reports

### **Artist Dashboard**
Display:
- My artworks count
- My services count
- Incoming orders count
- Pending payments count
Quick links: Manage Artworks, Manage Services, View Orders

### **Buyer Dashboard**
Display:
- My orders count
- Pending payments
- Available services
- My reviews
Quick links: Browse Services, Create Order, View Payments

---

## 🎨 UI/UX DESIGN SPECIFICATION - Modern Minimalist (Black Background)

### **Color Palette**
```
Primary:
- Background: #0a0a0a (very dark/black)
- Secondary BG: #1a1a1a (slightly lighter black)
- Accent: #6366f1 (indigo) or #ec4899 (pink) - for CTA, highlights
- Text: #f5f5f5 (off-white)
- Text secondary: #a0a0a0 (light gray)
- Border: #333333 (dark gray)
- Success: #10b981 (emerald)
- Warning: #f59e0b (amber)
- Danger: #ef4444 (red)
```

### **Typography**
```
Font family: "Inter", "Helvetica Neue", sans-serif (modern, clean)
Heading: font-weight 600-700, letter-spacing -0.5px
Body: font-weight 400, line-height 1.6
Sizes:
  - H1: 32px
  - H2: 24px
  - H3: 20px
  - Body: 14px
  - Small: 12px
```

### **Navigation Bar**
```
Layout: Horizontal top bar
- Left: Logo + brand name "ArtSpace"
- Center: Nav links (conditional by role)
- Right: User dropdown + notifications icon + logout
- Style: Fixed, sticky, black background (#0a0a0a) with subtle border-bottom (#333)
- Height: 64px
- Icons: 24px, white/indigo on hover
```

### **LAYOUT TEMPLATES**

#### **1. Dashboard (Hero Section)**
```
Hero area:
- Full width background with gradient overlay (black → dark indigo)
- Title: "Welcome, {Username}"
- Subtitle: Role description
- CTA buttons

Stats cards below (grid 2-4 columns):
- Icon (left side, indigo background circle)
- Label (gray text)
- Big number (white, bold)
- Subtle hover effect (bg slightly lighter)
```

#### **2. List/Index Pages (Resources)**
```
Header:
- Page title (H2)
- "Create New" button (right side, indigo background)
- Search bar (if applicable)

Content area:
- Table OR Grid (depending on resource type)

Table:
- Header row: gray background (#1a1a1a), white text, slight border
- Data rows: hover effect (bg #1a1a1a)
- Action buttons: small, icon+text or icon only
- Pagination: bottom center, minimalist (prev/next + page numbers)

Grid (Artworks/Services):
- 3-4 columns (responsive: 1 mobile, 2 tablet, 3-4 desktop)
- Card style: border (#333), hover elevation (scale 1.02, shadow)
- Card image: aspect ratio 1:1 or 4:3, object-fit cover
- Card title: white, truncate 1 line
- Card meta: gray text, small font
- Card footer: 2-3 action buttons
```

#### **3. Form Pages (Create/Edit)**
```
Layout:
- Max width 600px, centered, with side padding
- Page title: "Create {Resource}" or "Edit {Resource}"
- Optional: Breadcrumb or back link

Form fields:
- Label: gray text, 12px, margin-bottom 4px
- Input: 
  - Background: #1a1a1a
  - Border: #333 (2px)
  - Border-radius: 6px
  - Padding: 10px 14px
  - Text color: white
  - Focus: border-color #6366f1, subtle shadow
  - Placeholder: gray (#666)
- Select dropdown: same style as input
- Textarea: min-height 120px, same styling
- File input: custom styled button (indigo), preview image if applicable

Buttons:
- Primary (Submit): indigo background, white text, padding 12px 24px, hover darker indigo
- Secondary (Cancel/Back): transparent with gray border, white text

Validation:
- Error message: red color (#ef4444), 12px font, below field
- Success message: green (#10b981)
```

#### **4. Detail Pages (Show)**
```
Layout:
- Header: Title (H2), Edit/Delete buttons (right)
- Breadcrumb or back link

Content sections:
- Info block: key-value pairs
  - Key: gray text, 12px
  - Value: white text, 14px
  - Divider: subtle border (#333)
- Image (if applicable): full width or 50% width, rounded corners, border
- Related items: "Related {Resource}" section with mini cards

Action area (bottom):
- Primary action button
- Secondary buttons
```

#### **5. Specific Component Styles**

**Status Badge:**
```
Inline pill shape
- Background: varies by status (pending: #f59e0b, active: #10b981, paid: #10b981, etc)
- Text: white, 12px font-weight 600
- Padding: 4px 12px
- Border-radius: 20px
```

**Image/Avatar:**
```
- Border-radius: 8px
- Border: 1px #333
- Hover: subtle shadow effect
- Fallback: gray background with icon
```

**Buttons:**
```
Style: Rounded corners (6px)
States:
- Default: indigo bg, white text
- Hover: darker indigo, slight scale up
- Active: even darker
- Disabled: gray bg, gray text
- Outline (secondary): transparent, border indigo, indigo text
- Danger: red background, white text
- Size: Small (10px 16px), Medium (12px 24px), Large (14px 32px)
```

**Card:**
```
- Background: #1a1a1a
- Border: 1px #333
- Border-radius: 8px
- Padding: 16px or 20px
- Hover: scale 1.01, shadow, border #6366f1
```

**Spacing:**
```
Consistent 8px grid:
- Section gaps: 32px
- Element gaps: 16px
- Inner padding: 16px-20px
- Margins: 8px, 12px, 16px, 20px, 24px, 32px
```

---

## 📱 RESPONSIVE DESIGN

**Breakpoints:**
- Mobile: < 640px (single column, full-width)
- Tablet: 640px - 1024px (2 columns, adjusted padding)
- Desktop: > 1024px (3-4 columns, optimal padding)

**Navigation:** 
- Mobile: hamburger menu
- Desktop: full horizontal nav

**Tables:**
- Mobile: stack vertically or horizontal scroll
- Desktop: normal table layout

**Grids:**
- Mobile: 1 column
- Tablet: 2 columns
- Desktop: 3-4 columns

---

## 🎯 ICON USAGE

Use modern icon set (e.g., Heroicons, Feather Icons)
- Create: Plus circle
- View: Eye
- Edit: Pencil
- Delete: Trash
- Back: Arrow left
- Settings: Gear
- Notifications: Bell
- User: User circle
- Home: Home
- Orders: Shopping bag
- Payments: Credit card
- Reviews: Star
- Reports: Flag
- Messages: Message square

Icon size: 20px (nav), 24px (buttons), 16px (inline)

---

## 💡 INTERACTION PATTERNS

**Hover States:**
- Cards: scale 1.02, shadow increase
- Buttons: darker color, shadow
- Links: indigo color, underline

**Transitions:**
- All transitions: 200ms ease
- Properties: background-color, border-color, transform, box-shadow

**Loading:**
- Spinner: indigo color, centered
- Skeleton loaders for list items

**Confirmations:**
- Modal dialog for delete actions
- Background blur/overlay (#000 with 50% opacity)
- Buttons: Cancel (left), Delete/Confirm (right, red)

**Notifications/Alerts:**
- Toast messages: bottom right
- Auto-dismiss after 4s
- Success (green), Error (red), Info (blue), Warning (yellow)

---

## 🔄 WORKFLOW VISUALIZATION (for complex pages)

**Order Status Flow (visual timeline):**
```
pending → accepted → in_progress → finished/cancelled

Each step displayed as:
- Circle (completed: filled indigo, current: outline indigo, future: gray)
- Line connecting steps
- Label below each step
```

**Payment Status:**
```
waiting_confirmation → paid

Icon: upload proof → check mark (green)
```

---

## ✨ SPECIAL PAGES

**Profile Page:**
```
- Avatar large (150x150), centered top
- Name, email, bio, role badge
- Edit button
- Form fields when editing
- Delete account button (danger)
```

**Chat Page:**
```
- Message list: 
  - Own messages: right align, indigo background
  - Other messages: left align, gray background (#1a1a1a)
  - Timestamp: small gray text
  - File attachment: card with download link
- Input area (bottom): textarea + file upload + send button
- Typing indicator: animated dots
```

**Review Create/Edit:**
```
- Stars rating selector (clickable, fill with indigo on hover)
- Textarea for comment
- Submit button
```

**Payment Proof:**
```
- Large image preview (center)
- Status badge above image
- Amount displayed
- Confirm button (if artist/admin and not confirmed)
- Date uploaded
```

---

## 🎨 FINAL DESIGN CHECKLIST

- ✅ Dark theme throughout (black #0a0a0a, dark gray #1a1a1a)
- ✅ Indigo accents (#6366f1) for all interactive elements
- ✅ Clean typography (Inter font)
- ✅ Consistent 8px spacing grid
- ✅ Rounded corners (6-8px) on all elements
- ✅ Smooth transitions (200ms)
- ✅ Clear visual hierarchy (size, color, weight)
- ✅ Accessibility (sufficient contrast, large touch targets)
- ✅ Responsive design (1-4 columns depending on screen)
- ✅ Minimalist approach (no unnecessary decoration)
- ✅ Clear call-to-action buttons
- ✅ Loading, error, and success states
- ✅ Hover and focus states on all interactive elements

---

## 🚀 SUMMARY FOR DESIGN PROMPT

Use this summary when creating your design prompt to AI or designer:

"Modern minimalist web app with black background (#0a0a0a). 
Indigo accents (#6366f1) for interactive elements.
Dark gray (#1a1a1a) for secondary surfaces.
Clean typography (Inter font).
Consistent 8px grid spacing.
6-8px rounded corners on cards and buttons.
Role-based dashboards with stats cards.
Grid/card layouts for resources (artworks, services, orders).
Forms with dark inputs and clear validation.
Responsive design (mobile: 1 col, tablet: 2 col, desktop: 3-4 col).
Status badges and visual indicators.
Smooth 200ms transitions.
Clear hover and focus states.
Dark mode throughout, no light mode."
