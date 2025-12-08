# 🔐 ADMIN DASHBOARD - Complete CRUD & Capabilities

## 📊 ADMIN DASHBOARD OVERVIEW

### Dashboard Landing Page (`/admin/dashboard`)
**Header Section:**
- Welcome message: "Welcome, {Admin Name}"
- Role badge: "Administrator"
- Quick action buttons

**Stats Cards (4 columns):**
1. **Total Users**
   - Count: number of all users (admin, artist, buyer)
   - Icon: Users icon
   - Subtext: "Registered accounts"
   - Color: Indigo

2. **Active Artists**
   - Count: number of users with role='artist'
   - Icon: Palette/brush icon
   - Subtext: "Offering services"
   - Color: Pink/Emerald

3. **Pending Orders**
   - Count: orders with status='pending'
   - Icon: Shopping bag icon
   - Subtext: "Awaiting acceptance"
   - Color: Amber/Yellow

4. **Open Reports**
   - Count: reports with status='open' or 'in_review'
   - Icon: Flag icon
   - Subtext: "Unresolved issues"
   - Color: Red

**Quick Action Buttons (below stats):**
- "👥 Manage Users" → `/users`
- "📋 View Orders" → `/orders`
- "🚩 View Reports" → `/reports`
- "⚙️ Manage Categories" → `/categories`

---

## 🎯 ADMIN CRUD CAPABILITIES

### **1. USERS MANAGEMENT** (Complete CRUD)
**Route:** `/users` (protected by AdminOnly middleware)

#### **1.1 READ - List Users (`/users`)**
**Display Type:** Table with pagination
**Columns:**
- Checkbox (select multiple for bulk actions)
- ID
- Name
- Email
- Role (badge: admin/artist/client with color coding)
- Join Date (created_at)
- Status (Active/Inactive)
- Actions (View, Edit, Delete)

**Filters/Search:**
- Search by name, email
- Filter by role (dropdown: All / Admin / Artist / Client)
- Sort by: Name, Email, Date joined

**Table Features:**
- Pagination: 10, 25, 50 items per page
- Sortable columns (click header)
- Hover highlight rows
- Bulk delete checkbox + confirm modal

**Actions per row:**
- View icon → `/users/{id}` (detail page)
- Edit icon → `/users/{id}/edit` (edit form)
- Delete icon → Confirm modal → soft delete

---

#### **1.2 CREATE - Add New User (`/users/create`)**
**Form Fields:**
```
Name (required, text input)
Email (required, email input, must be unique)
Password (required, password input, min 8 chars)
Confirm Password (required, must match)
Role (required, dropdown: Admin / Artist / Client)
Bio (optional, textarea, max 500 chars)
Avatar (optional, file upload, jpg/png/webp, max 5MB)
```

**Form Validation:**
- Email unique check
- Password strength indicator (visual feedback)
- File size/type validation
- Live validation error display

**Submit Actions:**
- Create button (primary, indigo)
- Cancel button (secondary, back to list)
- Success message + redirect to list
- Error message + stay on form

**Created by:** Admin
**Default:** Role must be selected, password auto-generated or manual

---

#### **1.3 UPDATE - Edit User (`/users/{id}/edit`)**
**Form Fields:** Same as CREATE
**Editable:**
- Name
- Email
- Password (optional, leave blank to keep current)
- Confirm Password
- Role (can change user role)
- Bio
- Avatar (preview current image, can replace)

**Validation:**
- Email unique check (excluding current user)
- Password only if both password fields filled
- Same file validation as CREATE

**Submit:**
- Update button → Save changes
- Cancel → back to list
- Success: redirect to list with flash message
- Error: stay on form with error message

**Audit Trail (optional):**
- Show "Last updated: {date} by {admin}"
- Show "Created: {date}"

---

#### **1.4 DELETE - Remove User (`/users/{id}` - DELETE action)**
**Trigger:** Delete button on list or detail page

**Confirmation Modal:**
```
Title: "Delete User"
Message: "Are you sure you want to delete {username}? This action cannot be undone."
Data preview: Name, Email, Role

Buttons:
- Cancel (gray, secondary)
- Delete (red, danger)
```

**Delete Options:**
- Soft delete: Mark as deleted, keep data
- Hard delete: Remove from database completely

**Post-deletion:**
- Show toast: "User deleted successfully"
- Redirect to users list
- Removed user no longer visible in list (unless showing soft-deleted)

**Relationships handling:**
- User's artworks: transferred to admin OR marked as archived
- User's orders: kept in database with user reference
- User's reviews: kept as is
- User's chats: kept as archived

---

### **2. ORDERS MANAGEMENT** (Supervise/Modify)
**Route:** `/orders`

#### **2.1 READ - List Orders (`/orders`)**
**Display Type:** Table with pagination

**Columns:**
- Order ID
- Buyer (client name)
- Artist (artist name)
- Service (service title)
- Price
- Status (badge with color)
- Payment Status (sub-badge)
- Date Created
- Actions

**Filters/Search:**
- Search by order ID, buyer name, artist name
- Filter by status: All / Pending / Accepted / In Progress / Finished / Cancelled
- Filter by payment status: All / Waiting Confirmation / Paid
- Date range filter (from-to)

**Sorting:**
- By date (newest/oldest)
- By price (low-high)
- By status

**Bulk Actions:**
- Select multiple orders
- Bulk cancel (with reason modal)
- Bulk mark as finished

---

#### **2.2 READ - Order Detail (`/orders/{id}`)**
**Display Layout:**
```
Header:
- Order ID: #ORD-{id}
- Status badge (large, colored)
- Payment status badge

Main Info:
- Buyer info: name, email, avatar
- Artist info: name, email, avatar
- Service: title, description, base price
- Order details: price, description, created_at, updated_at

Timeline:
- Created: {date}
- Status changes: pending → accepted → in_progress → finished
- Payments: list of payment records

Related sections:
- Chat messages (link to `/order_chat?order_id={id}`)
- Payments (list of payment records)
- Reviews (if finished, show review if exists)
```

**Admin Actions on Detail:**
- Edit button → `/orders/{id}/edit`
- Change status dropdown (admin can force status change)
- Add note/comment
- View payment proofs
- View chat history
- Delete order (danger button, bottom)

---

#### **2.3 UPDATE - Edit Order (`/orders/{id}/edit`)**
**Editable by Admin:**
- Description/request (textarea)
- Price (number, can override)
- Status (dropdown: pending → accepted → in_progress → finished → cancelled)
- Add admin note (text area, internal only)

**Admin Privileges:**
- Can force status change (bypassing normal workflow)
- Can modify price after creation
- Can add internal notes/comments
- Can reassign artist (if needed for emergency)

**Submit:**
- Save changes
- Show "Updated by: {admin name}, {time}"
- Notify both buyer and artist of changes

---

#### **2.4 DELETE - Cancel/Remove Order**
**Trigger:** Delete button on detail

**Confirmation Modal:**
```
Title: "Cancel Order"
Message: "Cancel this order? Related payments will be marked as cancelled."

Options:
- Reason dropdown: Customer requested / Artist unavailable / Payment issues / Other
- Admin notes: textarea for internal note

Buttons:
- Keep (cancel modal)
- Cancel Order (red)
```

**Post-cancellation:**
- Order status → 'cancelled'
- Payments → marked as cancelled
- Notify buyer and artist
- Redirect to orders list

---

### **3. REPORTS MANAGEMENT** (Review & Resolve)
**Route:** `/reports`

#### **3.1 READ - List Reports (`/reports`)**
**Display Type:** Table

**Columns:**
- Report ID
- Reported User (name with avatar)
- Reporter (name)
- Order (order ID link)
- Report Status (badge: open / in_review / resolved)
- Severity (auto-calculated or flagged)
- Date Created
- Actions

**Filters/Search:**
- Search by report ID, user names, order ID
- Filter by status: All / Open / In Review / Resolved
- Filter by severity (optional)
- Date range

**Quick Actions:**
- Bulk mark as "in_review"
- Bulk mark as "resolved"
- Bulk delete

---

#### **3.2 READ - Report Detail (`/reports/{id}`)**
**Display:**
```
Header:
- Report ID: #REP-{id}
- Status badge
- Severity indicator

Report Info:
- Reported User: name, avatar, role, email
- Reporter: name, avatar, email
- Related Order: order ID, link to order detail
- Report Message: full text
- Attachments (if any): list of uploaded files

Timeline:
- Created: {date}
- Status updates: open → in_review → resolved
- Admin actions: who viewed, who updated
```

**Admin Actions:**
- Mark as "in_review" button
- Mark as "resolved" button
- Add admin comment/note
- Assign to another admin (if applicable)
- View related order details
- Contact reporter (email link)
- Contact reported user (email link)
- Delete report (danger)

---

#### **3.3 UPDATE - Change Report Status (`/reports/{id}` - PATCH)**
**Status Transitions:**
1. **open** → **in_review**
   - Admin viewing/investigating
   - Notify reporter: "Your report is under review"

2. **in_review** → **resolved**
   - Admin took action
   - Can add resolution reason (dropdown + text)
   - Notify both reporter and reported user
   - Optional: Ban/Warn user if needed

3. **Resolved** → Can reopen if needed

**Admin Actions on Report:**
- Add internal comment (not visible to reporter)
- Assign outcome: 
  - "Dismissed - no violation"
  - "Warning issued to reported user"
  - "User suspended"
  - "User banned"
  - "Order refunded"
  - "Custom action"

---

#### **3.4 DELETE - Remove Report (`/reports/{id}` - DELETE)**
**Confirmation:**
```
Title: "Delete Report"
Message: "Remove this report? Any actions taken will remain."

Buttons:
- Cancel
- Delete
```

---

### **4. CATEGORIES MANAGEMENT** (CRUD)
**Route:** `/categories`

#### **4.1 READ - List Categories (`/categories`)**
**Display Type:** Table or card grid

**Columns (Table):**
- Category ID
- Name
- Description (truncated)
- # of Artworks (count)
- # of Services (count)
- Created Date
- Actions

**Features:**
- Search by name
- Sort by name, date, count
- Pagination

---

#### **4.2 CREATE - Add Category (`/categories/create`)**
**Form:**
```
Name (required, text, max 50 chars)
Description (optional, textarea, max 500 chars)
```

**Submit:** Create → redirect to list

---

#### **4.3 UPDATE - Edit Category (`/categories/{id}/edit`)**
**Form:**
```
Name
Description
```

**Submit:** Update → redirect to list

---

#### **4.4 DELETE - Remove Category (`/categories/{id}` - DELETE)**
**Validation:**
- If category has artworks/services: show warning "This category has {X} items. Are you sure?"
- Option to reassign items to another category

**Delete:** Soft delete or hard delete (configurable)

---

### **5. NOTIFICATIONS SYSTEM** (Admin Control)
**Route:** `/admin/notifications` (optional, if admin needs to see all user notifications)

**Admin Capabilities:**
- View all system notifications
- Send system-wide announcement (all users get notification)
- Manage notification templates (optional)

---

### **6. DASHBOARD ANALYTICS** (Optional Advanced)
**Charts/Reports (if implemented):**
- Orders over time (line chart)
- Revenue trends (if payment system active)
- User growth (line chart)
- Top artists (bar chart)
- User distribution (pie chart: admin/artist/client)

---

## 🚀 ADMIN ACTION SUMMARY TABLE

| Resource | CREATE | READ | UPDATE | DELETE | Special |
|----------|--------|------|--------|--------|---------|
| **Users** | ✅ Add new user | ✅ List all, view detail | ✅ Edit all fields, change role | ✅ Delete user | Manage accounts |
| **Orders** | ❌ (system only) | ✅ List all, view detail | ✅ Force status change, modify price | ✅ Cancel order | Supervise transactions |
| **Reports** | ❌ (users create) | ✅ List all, view detail | ✅ Mark in_review, resolved | ✅ Delete report | Resolve disputes |
| **Categories** | ✅ Create | ✅ List, view | ✅ Edit | ✅ Delete | Organize content |
| **Artworks** | ❌ (artist creates) | ✅ View all | ✅ Edit (force), feature | ✅ Remove | Moderate content |
| **Services** | ❌ (artist creates) | ✅ View all | ✅ Edit (force), approve | ✅ Remove | Moderate services |
| **Payments** | ❌ (buyer creates) | ✅ View all, see proofs | ✅ Mark as paid, reject | ❌ Keep records | Monitor transactions |
| **Reviews** | ❌ (buyer creates) | ✅ View all | ✅ Flag inappropriate | ✅ Delete spam | Moderate reviews |

---

## 💡 ADMIN DASHBOARD WIREFRAME

```
┌─────────────────────────────────────────────────────┐
│  Logo  │  Nav: Users | Orders | Reports | Settings  │ Right: Admin ▼
├─────────────────────────────────────────────────────┤
│                                                       │
│  Welcome, Admin Name                                │
│                                                       │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐ ┌─────────┤
│  │Total Users  │ │ Artists  │ │Pending   │ │ Reports │
│  │    2,458    │ │   156    │ │ Orders   │ │   23    │
│  │             │ │          │ │   45     │ │         │
│  └──────────┘  └──────────┘  └──────────┘ └─────────┤
│                                                       │
│  Quick Actions:                                      │
│  [+ Add User] [View Orders] [View Reports]           │
│                                                       │
├─────────────────────────────────────────────────────┤
│  Recent Activity                                     │
│  ┌─────────────────────────────────────────────────┐│
│  │ Order #1234 finished by Admin                    ││
│  │ User John banned for spam                        ││
│  │ Report #45 resolved                              ││
│  │ New artist registered: Jane Doe                  ││
│  └─────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────┘
```

---

## 🔒 SECURITY & PERMISSIONS

**Admin Can:**
- ✅ Access all resources
- ✅ Edit any user data
- ✅ Modify any order
- ✅ Resolve reports
- ✅ Manage categories
- ✅ View all payments
- ✅ Delete/restore any content
- ✅ Force status changes

**Admin Cannot:**
- ❌ Bypass authentication
- ❌ Escalate to super-admin (if not super-admin)
- ❌ Access server files/config (via UI)
- ❌ Modify application code (via UI)

**Audit Trail:**
- All admin actions logged (who, what, when)
- Deletions are soft-deletes by default
- Access to sensitive data logged

---

## 📱 RESPONSIVE ADMIN DASHBOARD

**Mobile (<640px):**
- Hamburger navigation
- Stats cards stack vertically
- Tables become card view
- Simplified table (fewer columns)
- Actions in dropdown menu

**Tablet (640-1024px):**
- Sidebar navigation (collapsible)
- 2-column grid for stats
- Tables with horizontal scroll
- Normal button/action layout

**Desktop (>1024px):**
- Full sidebar or top nav
- 4-column grid for stats
- Full tables with all columns
- All features visible

---

## 📌 IMPLEMENTATION PRIORITY

1. **MVP (Must Have):**
   - Users CRUD (add, view, edit, delete)
   - Orders list and detail view
   - Reports list and status update
   - Dashboard with stats

2. **Important:**
   - Categories CRUD
   - Order status management
   - Report resolution workflow
   - Search and filters

3. **Nice to Have:**
   - Analytics charts
   - Bulk actions
   - Audit logs
   - Admin notifications

---

## 🎨 UI COMPONENTS FOR ADMIN

**Status Badges:**
```
Pending (yellow)   | Accepted (blue)  | In Progress (indigo)
Finished (green)   | Cancelled (red)  | Resolved (green)
```

**Role Badges:**
```
Admin (purple)  | Artist (pink)  | Client (blue)
```

**Action Buttons (per row):**
```
[👁 View] [✏️ Edit] [🗑️ Delete]
```

**Modals:**
- Confirmation dialogs with reason/note
- Form modals for inline edits
- Preview modals for images/files

