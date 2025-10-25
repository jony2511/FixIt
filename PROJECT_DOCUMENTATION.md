# FixIt - Maintenance & E-Commerce Platform
## Complete Project Documentation for Academic Presentation

---

## 📋 Table of Contents
1. [Project Overview](#project-overview)
2. [Technology Stack](#technology-stack)
3. [Project Architecture](#project-architecture)
4. [Database Schema](#database-schema)
5. [User Roles & Permissions](#user-roles--permissions)
6. [Main Features](#main-features)
7. [Application Flow](#application-flow)
8. [Routes Explanation](#routes-explanation)
9. [Key Components](#key-components)
10. [Security Features](#security-features)
11. [Payment Integration](#payment-integration)
12. [Email System](#email-system)
13. [AI Integration](#ai-integration)
14. [Testing & Deployment](#testing--deployment)

---

## 1. 📌 Project Overview

**FixIt** is a comprehensive web-based maintenance request management and e-commerce platform built with Laravel 11. It serves educational institutions, businesses, and organizations for:

- **Maintenance Management**: Submit, track, and manage facility repair requests
- **E-Commerce**: Purchase maintenance tools and replacement parts
- **User Management**: Multi-role system (Admin, Technician, Regular User)
- **Communication**: Real-time notifications, comments, and AI chatbot
- **Payment Processing**: Integrated SSLCommerz payment gateway

### Purpose
This academic project demonstrates modern web development practices including:
- MVC architecture
- RESTful API design
- Database relationships
- Authentication & authorization
- Third-party integrations
- Responsive UI/UX

---

## 2. 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 11.31.0 (PHP 8.2.12)
- **Database**: MySQL
- **ORM**: Eloquent
- **Authentication**: Laravel Breeze
- **Session Management**: Database driver

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js
- **Icons**: Font Awesome
- **Build Tool**: Vite

### Third-Party Services
- **Payment Gateway**: SSLCommerz (Bangladesh)
- **AI Service**: Google Gemini API
- **Email**: Gmail SMTP
- **PDF Generation**: DomPDF

### Development Tools
- **Server**: PHP built-in server / XAMPP
- **Version Control**: Git
- **Package Manager**: Composer (PHP), NPM (JavaScript)

---

## 3. 🏗️ Project Architecture

### MVC Pattern

```
┌─────────────┐
│   Browser   │ ← User Interface
└──────┬──────┘
       │ HTTP Request
       ▼
┌─────────────┐
│   Routes    │ ← web.php (URL to Controller mapping)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Controller  │ ← Business Logic (RequestController, AdminController, etc.)
└──────┬──────┘
       │
       ├──────→ ┌─────────┐
       │        │  Model  │ ← Database Interaction (User, Request, Product)
       │        └─────────┘
       │
       └──────→ ┌─────────┐
                │  View   │ ← Blade Templates (dashboard.blade.php, etc.)
                └─────────┘
```

### Directory Structure

```
FixIt/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Handle requests and business logic
│   │   │   ├── AdminController.php
│   │   │   ├── RequestController.php
│   │   │   ├── ShopController.php
│   │   │   ├── OrderController.php
│   │   │   └── ...
│   │   ├── Middleware/           # Request filtering
│   │   │   └── EnsureUserIsAdmin.php
│   │   └── Requests/             # Form validation
│   ├── Models/                   # Database models (ORM)
│   │   ├── User.php
│   │   ├── Request.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   └── ...
│   ├── Notifications/            # Email/notification classes
│   │   ├── OrderStatusChangedNotification.php
│   │   └── RequestAssignedNotification.php
│   └── Services/                 # Business services
│       └── SSLCommerzService.php
├── config/                       # Configuration files
│   ├── database.php
│   ├── mail.php
│   └── services.php
├── database/
│   ├── migrations/               # Database schema versions
│   └── seeders/                  # Sample data
├── public/                       # Publicly accessible files
│   ├── css/
│   ├── js/
│   └── images/
├── resources/
│   ├── views/                    # Blade templates
│   │   ├── admin/
│   │   ├── requests/
│   │   ├── shop/
│   │   └── layouts/
│   └── css/
├── routes/
│   ├── web.php                   # Web routes
│   └── auth.php                  # Authentication routes
├── storage/                      # Generated files
│   ├── app/
│   ├── logs/
│   └── framework/
├── .env                          # Environment configuration
└── composer.json                 # PHP dependencies
```

---

## 4. 🗄️ Database Schema

### Main Tables

#### 1. **users**
```sql
- id (primary key)
- name
- email (unique)
- password
- role (enum: 'admin', 'technician', 'user')
- phone
- address
- department
- employee_id
- bio
- avatar
- is_active (boolean)
- email_verified_at
- remember_token
- created_at, updated_at
```

#### 2. **requests** (maintenance requests)
```sql
- id (primary key)
- user_id (foreign key → users)
- assigned_to (foreign key → users, nullable)
- category_id (foreign key → categories)
- title
- description
- priority (enum: 'low', 'medium', 'high', 'urgent')
- status (enum: 'pending', 'in_progress', 'completed', 'rejected')
- location
- estimated_cost
- actual_cost
- completion_notes
- completed_at
- created_at, updated_at
```

#### 3. **request_files**
```sql
- id (primary key)
- request_id (foreign key → requests)
- file_path
- file_type
- file_size
- created_at, updated_at
```

#### 4. **comments**
```sql
- id (primary key)
- request_id (foreign key → requests)
- user_id (foreign key → users)
- comment_text
- is_internal (boolean)
- created_at, updated_at
```

#### 5. **products**
```sql
- id (primary key)
- name
- slug (unique)
- description
- price
- stock_quantity
- category_id (foreign key → categories)
- image
- is_active (boolean)
- created_at, updated_at
```

#### 6. **orders**
```sql
- id (primary key)
- user_id (foreign key → users)
- order_number (unique)
- total_amount
- status (enum: 'pending', 'processing', 'shipped', 'delivered', 'cancelled')
- payment_status (enum: 'pending', 'paid', 'failed')
- payment_method
- transaction_id
- shipping_address
- billing_address
- customer_name
- customer_email
- customer_phone
- created_at, updated_at
```

#### 7. **order_items**
```sql
- id (primary key)
- order_id (foreign key → orders)
- product_id (foreign key → products)
- product_name
- quantity
- price
- subtotal
- created_at, updated_at
```

#### 8. **carts**
```sql
- id (primary key)
- user_id (foreign key → users)
- product_id (foreign key → products)
- quantity
- created_at, updated_at
```

#### 9. **categories**
```sql
- id (primary key)
- name
- slug (unique)
- description
- type (enum: 'request', 'product')
- created_at, updated_at
```

#### 10. **blogs**
```sql
- id (primary key)
- title
- slug (unique)
- excerpt
- content
- category
- author_id (foreign key → users)
- image
- views
- is_published (boolean)
- published_at
- created_at, updated_at
```

### Database Relationships

```
User ──┬──> Many Requests (as creator)
       ├──> Many Requests (as assigned technician)
       ├──> Many Orders
       ├──> Many Comments
       ├──> Many Cart Items
       └──> Many Blogs (as author)

Request ──┬──> Many Comments
          ├──> Many Files
          ├──> Belongs to User (creator)
          ├──> Belongs to User (assigned_to)
          └──> Belongs to Category

Product ──┬──> Many Cart Items
          ├──> Many Order Items
          └──> Belongs to Category

Order ──┬──> Many Order Items
        └──> Belongs to User

Category ──┬──> Many Requests
           └──> Many Products
```

---

## 5. 👥 User Roles & Permissions

### 1. **Admin** (System Administrator)
**Full System Access**

Capabilities:
- ✅ Manage all users (create, edit, delete, change roles)
- ✅ View all maintenance requests across the system
- ✅ Assign technicians to requests
- ✅ Manage categories (request & product)
- ✅ Manage products (CRUD operations)
- ✅ Manage orders (view, update status)
- ✅ Manage blogs (create, edit, publish)
- ✅ View system reports and analytics
- ✅ Manage testimonials
- ✅ View contact form submissions
- ✅ Access admin dashboard with statistics

Routes: `/admin/*`
Middleware: `auth`, `verified`, `admin`

### 2. **Technician** (Maintenance Staff)
**Request Management & Execution**

Capabilities:
- ✅ View assigned maintenance requests
- ✅ Update request status (start, complete, reject)
- ✅ Add comments and notes to requests
- ✅ Suggest products for repairs
- ✅ Upload completion photos/documents
- ✅ View all pending requests
- ✅ Submit their own requests
- ✅ Shop and purchase products
- ❌ Cannot access admin panel
- ❌ Cannot manage users or system settings

Routes: `/requests/*`, `/assigned-requests`

### 3. **User** (Regular User/Student/Employee)
**Basic Platform Access**

Capabilities:
- ✅ Submit maintenance requests
- ✅ View their own requests
- ✅ Add comments to their requests
- ✅ Browse and purchase products
- ✅ Manage shopping cart
- ✅ Place orders and track shipments
- ✅ View order history
- ✅ Download invoices
- ✅ Update profile information
- ✅ Read blogs
- ✅ Submit contact forms
- ❌ Cannot view other users' requests
- ❌ Cannot assign technicians
- ❌ Cannot access admin features

Routes: `/requests/*`, `/shop/*`, `/cart/*`, `/orders/*`

### Guest (Unauthenticated)
- ✅ View home page
- ✅ View about page
- ✅ Browse products (read-only)
- ✅ Read blogs
- ✅ Submit contact forms
- ❌ Cannot submit requests
- ❌ Cannot purchase products
- ❌ Must login/register for full access

---

## 6. ⚡ Main Features

### A. Maintenance Request System

**Flow**: User Submit → Admin Assign → Technician Work → Complete

1. **Request Submission** (`/requests/create`)
   - Multi-step form with validation
   - File upload support (photos, documents)
   - Priority selection (low, medium, high, urgent)
   - Category selection (IT, Electrical, Plumbing, etc.)
   - Location details

2. **Request Tracking** (`/requests/{id}`)
   - Real-time status updates
   - Comment thread (public & internal)
   - File attachments view
   - Assignment history
   - Completion notes

3. **Request Management**
   - Admin dashboard showing all requests
   - Filter by status, priority, category
   - Search functionality
   - Bulk actions
   - Analytics and reports

### B. E-Commerce Shop

1. **Product Browsing** (`/shop`)
   - Grid/list view
   - Category filtering
   - Search functionality
   - Price sorting
   - Stock availability display

2. **Shopping Cart** (`/cart`)
   - Add/remove items
   - Quantity adjustment
   - Real-time price calculation
   - Stock validation
   - Clear cart option

3. **Checkout Process** (`/checkout`)
   - Address collection
   - Order summary
   - Payment method selection
   - SSLCommerz payment gateway
   - Order confirmation

4. **Order Management** (`/orders`)
   - Order history
   - Status tracking
   - Invoice download (PDF)
   - Delivery tracking
   - Cancel option (if pending)

### C. User Dashboard

**Layout**: Sidebar navigation + Main content area

Features:
- Statistics cards (requests, orders, notifications)
- Recent activity feed
- Quick action buttons
- Notification bell with dropdown
- Profile management
- Role-based menu items

### D. Admin Panel

**URL**: `/admin`

Sections:
1. **Dashboard** - Overview statistics
   - Total users, requests, orders, products
   - Revenue charts
   - Recent activity

2. **User Management** - `/admin/users`
   - User list with search/filter
   - Edit roles and permissions
   - Activate/deactivate accounts
   - View user details
   - Delete users (with validation)

3. **Request Management** - Accessible via main dashboard
   - View all requests
   - Assign technicians
   - Track progress

4. **Product Management** - `/admin/products`
   - CRUD operations
   - Stock management
   - Category assignment
   - Image upload
   - Activate/deactivate

5. **Order Management** - `/admin/orders`
   - View all orders
   - Update order status
   - Process refunds
   - Generate reports

6. **Blog Management** - `/admin/blogs`
   - Create/edit blog posts
   - Rich text editor
   - Publish/unpublish
   - Category management
   - View analytics

7. **Category Management** - `/admin/categories`
   - Request categories
   - Product categories
   - CRUD operations

8. **Reports** - `/admin/reports`
   - Request statistics
   - Revenue reports
   - User activity
   - Export to Excel/PDF

### E. Notification System

**Real-time Updates** via Laravel Notifications

Events triggering notifications:
- Request submitted → Notify admins
- Request assigned → Notify technician
- Request status changed → Notify requester
- Order placed → Notify admin
- Order status updated → Notify customer
- Comment added → Notify request participants

Display:
- Bell icon with unread count
- Dropdown notification list
- Mark as read functionality
- Auto-refresh every 30 seconds

### F. AI Chatbot Integration

**Technology**: Google Gemini API

Features:
- Maintenance assistance
- Troubleshooting guidance
- Product recommendations
- FAQ responses
- Natural language understanding

Usage: Click chat icon → Type question → Get AI response

### G. Blog System

**Public access** for knowledge sharing

Features:
- Category-based organization
- Search functionality
- View counter
- Comment system
- Related posts
- Social sharing
- Responsive images

### H. Contact System

**Public form** for inquiries

Fields:
- Full name
- Email
- Phone (optional)
- Message

Admin features:
- View all submissions
- Mark as read/unread
- Reply via email
- Delete submissions

---

## 7. 🔄 Application Flow

### User Registration & Login Flow

```
┌─────────────┐
│   Landing   │
│    Page     │
└──────┬──────┘
       │
       ├─── Not Logged In ───┐
       │                     ▼
       │              ┌─────────────┐
       │              │  Register   │
       │              │  /register  │
       │              └──────┬──────┘
       │                     │
       │                     ▼
       │              ┌─────────────┐
       │              │ Email Verify│
       │              └──────┬──────┘
       │                     │
       ├─── Logged In ───────┤
       │                     │
       ▼                     ▼
┌─────────────┐       ┌─────────────┐
│  Dashboard  │       │  Dashboard  │
│  /dashboard │       │  /dashboard │
└─────────────┘       └─────────────┘
```

### Maintenance Request Flow

```
USER                    ADMIN                   TECHNICIAN

┌──────────┐
│ Submit   │
│ Request  │
└────┬─────┘
     │
     ▼
┌──────────┐           ┌──────────┐
│ Pending  │──────────>│  Review  │
│  Status  │           │  Assign  │
└──────────┘           └────┬─────┘
                            │
                            ▼
                       ┌──────────┐           ┌──────────┐
                       │ Assigned │──────────>│  Accept  │
                       │          │           │   Work   │
                       └──────────┘           └────┬─────┘
                                                   │
┌──────────┐                                       ▼
│  Track   │<──────────────────────────────┌──────────┐
│ Progress │                               │   Work   │
└────┬─────┘                               │   Start  │
     │                                     └────┬─────┘
     │                                          │
     ▼                                          ▼
┌──────────┐                               ┌──────────┐
│ Receive  │<──────────────────────────────│ Complete │
│  Update  │                               │  Submit  │
└──────────┘                               └──────────┘
```

### E-Commerce Purchase Flow

```
┌─────────────┐
│   Browse    │
│  Products   │
│   /shop     │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│  Add to     │
│    Cart     │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│  View Cart  │
│   /cart     │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│  Checkout   │
│  /checkout  │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│  Payment    │
│ SSLCommerz  │
└──────┬──────┘
       │
       ├─── Success ───┐
       │               ▼
       │        ┌─────────────┐
       │        │   Order     │
       │        │ Confirmed   │
       │        │ + Email +   │
       │        │   Invoice   │
       │        └─────────────┘
       │
       └─── Failed ────┐
                       ▼
                ┌─────────────┐
                │   Payment   │
                │   Failed    │
                │  Retry?     │
                └─────────────┘
```

---

## 8. 🛣️ Routes Explanation

### Public Routes (No Authentication Required)

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
// Landing page with hero section, statistics, services

Route::get('/about', [HomeController::class, 'about'])->name('about');
// About page with company information

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
// Product listing (browsable without login)

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
// Blog listing page

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
// Contact form submission
```

### Authenticated Routes (Login Required)

```php
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    // Main user dashboard with activity feed
    
    // Maintenance Requests
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    // List all requests (filtered by role)
    
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    // Form to create new request
    
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    // Submit new request
    
    Route::get('/requests/{request}', [RequestController::class, 'show'])->name('requests.show');
    // View single request details
    
    Route::post('/requests/{request}/assign', [RequestController::class, 'assign'])->name('requests.assign');
    // Admin assigns technician
    
    Route::post('/requests/{request}/start', [RequestController::class, 'start'])->name('requests.start');
    // Technician starts work
    
    Route::post('/requests/{request}/complete', [RequestController::class, 'complete'])->name('requests.complete');
    // Technician marks complete
    
    // Shopping Cart
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
    // Add product to cart
    
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    // Remove item from cart
    
    // Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    // Checkout page
    
    Route::post('/orders', [OrderController::class, 'placeOrder'])->name('orders.place');
    // Place order and initiate payment
    
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    // View order details
    
    Route::get('/user/orders/{order}/invoice', [UserDashboardController::class, 'downloadInvoice'])->name('user.orders.invoice');
    // Download PDF invoice
});
```

### Admin Routes (Admin Role Required)

```php
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    // Admin dashboard with analytics
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    // List all users
    
    Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    // Change user role
    
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    // Delete user
    
    // Product Management
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    
    // Order Management
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    // Update order status (processing, shipped, delivered)
});
```

### Payment Routes (Special Handling)

```php
// Protected - initiate payment (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
});

// Public - callback routes (SSLCommerz redirects here)
Route::match(['get', 'post'], '/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::match(['get', 'post'], '/payment/fail', [PaymentController::class, 'paymentFail'])->name('payment.fail');
Route::match(['get', 'post'], '/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
```

---

## 9. 🧩 Key Components

### Controllers

#### 1. **AdminController.php**
Handles all admin panel operations:
- `dashboard()` - Admin statistics and analytics
- `users()` - User management
- `products()` - Product CRUD
- `orders()` - Order management
- `reports()` - Generate reports
- `updateUserRole()` - Change user permissions
- `toggleProductActive()` - Enable/disable products

#### 2. **RequestController.php**
Manages maintenance requests:
- `index()` - List requests (role-filtered)
- `create()` - Show request form
- `store()` - Save new request
- `show()` - Display request details
- `assign()` - Assign technician
- `start()` - Mark work started
- `complete()` - Mark completed
- `addComment()` - Add comment/note
- `suggestProducts()` - Recommend products for repair

#### 3. **ShopController.php**
E-commerce functionality:
- `index()` - Product listing with filters
- `show()` - Product details page

#### 4. **OrderController.php**
Order processing:
- `checkout()` - Display checkout form
- `placeOrder()` - Create order and initiate payment
- `index()` - User's order history
- `show()` - Order details

#### 5. **PaymentController.php**
Payment gateway integration:
- `initiatePayment()` - Start SSLCommerz session
- `paymentSuccess()` - Handle successful payment
- `paymentFail()` - Handle failed payment
- `paymentCancel()` - Handle cancelled payment
- `paymentIPN()` - Instant Payment Notification

#### 6. **CartController.php**
Shopping cart management:
- `index()` - Display cart
- `add()` - Add item
- `update()` - Change quantity
- `remove()` - Delete item
- `clear()` - Empty cart

### Models

#### 1. **User.php**
```php
// Relationships
public function requests() // Requests created by user
public function assignedRequests() // Requests assigned to technician
public function orders() // User's orders
public function comments() // User's comments
public function carts() // Cart items

// Methods
public function isAdmin() // Check if admin
public function isTechnician() // Check if technician
public function hasRole($role) // General role check
```

#### 2. **Request.php**
```php
// Relationships
public function user() // Request creator
public function assignedTo() // Assigned technician
public function category() // Request category
public function comments() // Request comments
public function files() // Uploaded files

// Scopes
public function scopePending($query) // Filter pending
public function scopeCompleted($query) // Filter completed

// Accessors
public function getStatusColorAttribute() // Bootstrap color
public function getPriorityBadgeAttribute() // Priority styling
```

#### 3. **Product.php**
```php
// Relationships
public function category()
public function orderItems()
public function carts()

// Methods
public function decreaseStock($quantity) // Reduce stock
public function increaseStock($quantity) // Restore stock
public function isInStock() // Check availability
```

#### 4. **Order.php**
```php
// Relationships
public function user()
public function items() // Order items

// Methods
public function generateOrderNumber() // Unique order ID
public function calculateTotal() // Sum order items
public function canBeCancelled() // Check if cancellable
```

### Middleware

#### 1. **EnsureUserIsAdmin.php**
```php
public function handle($request, Closure $next)
{
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized access');
    }
    return $next($request);
}
```
- Protects admin routes
- Returns 403 if not admin

### Blade Components

#### Layouts
- `app.blade.php` - Main public layout
- `sidebar.blade.php` - Authenticated user layout
- `admin.blade.php` - Admin panel layout

#### Components
- `<x-notification-bell />` - Notification dropdown
- `<x-footer />` - Site footer
- `<x-product-card :product="$product" />` - Product display

---

## 10. 🔒 Security Features

### 1. Authentication
- Laravel Breeze (built-in authentication)
- Email verification required
- Password hashing with bcrypt
- Remember me functionality
- Password reset via email

### 2. Authorization
- Role-based access control (RBAC)
- Middleware protection on routes
- Policy-based permissions
- CSRF protection on forms
- Admin-only routes guarded

### 3. Input Validation
```php
// Example from RequestController
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'priority' => 'required|in:low,medium,high,urgent',
    'category_id' => 'required|exists:categories,id',
    'files.*' => 'nullable|file|max:10240|mimes:jpg,png,pdf,doc,docx'
]);
```

### 4. SQL Injection Prevention
- Eloquent ORM (parameterized queries)
- No raw SQL without binding
- Input sanitization

### 5. XSS Protection
- Blade `{{ }}` auto-escapes output
- `{!! !!}` used only for trusted HTML
- Content Security Policy headers

### 6. File Upload Security
- MIME type validation
- File size limits
- Secure storage in `storage/app`
- Unique filename generation

### 7. Session Management
- Database session driver
- HTTPS recommended in production
- Session timeout (120 minutes)
- Secure cookie settings

---

## 11. 💳 Payment Integration

### SSLCommerz Setup

**Configuration** (`.env`):
```
SSLCOMMERZ_STORE_ID=your_store_id
SSLCOMMERZ_STORE_PASSWORD=your_password
SSLCOMMERZ_API_URL=https://sandbox.sslcommerz.com
SSLCOMMERZ_MODE=sandbox
```

### Payment Flow

1. **User clicks "Checkout"**
   - Order created with status "pending"
   - Payment status "pending"

2. **System calls SSLCommerzService**
   ```php
   $sslCommerz = new SSLCommerzService();
   $paymentUrl = $sslCommerz->initiatePayment($order);
   ```

3. **User redirected to SSLCommerz**
   - Enter card details
   - Complete payment

4. **SSLCommerz redirects back**
   - Success: `/payment/success`
   - Failed: `/payment/fail`
   - Cancelled: `/payment/cancel`

5. **Order updated**
   ```php
   if ($paymentSuccess) {
       $order->update([
           'payment_status' => 'paid',
           'transaction_id' => $transactionId,
           'status' => 'processing'
       ]);
       
       // Send confirmation email with PDF invoice
       Mail::to($order->customer_email)->send(new OrderConfirmation($order));
   }
   ```

### Payment Security
- Transaction validation
- Hash verification
- IPN (Instant Payment Notification)
- Secure order number generation
- Amount verification

---

## 12. 📧 Email System

### Configuration

**SMTP Settings** (`.env`):
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="FixIt"
```

### Email Notifications

#### 1. **Order Confirmation**
```php
class OrderConfirmation extends Notification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Confirmed - #' . $this->order->order_number)
            ->greeting('Hello ' . $this->order->customer_name)
            ->line('Your order has been confirmed!')
            ->line('Order Number: ' . $this->order->order_number)
            ->line('Total Amount: BDT ' . number_format($this->order->total_amount, 2))
            ->action('View Order', url('/orders/' . $this->order->id))
            ->attach($pdfInvoice); // PDF attachment
    }
}
```

#### 2. **Request Status Update**
- Sent when request status changes
- Includes request details
- Link to view request

#### 3. **Password Reset**
- Laravel's built-in password reset
- Secure token generation
- 60-minute expiry

### Email Templates
- Located in `resources/views/emails/`
- Blade-based HTML emails
- Responsive design
- Consistent branding

---

## 13. 🤖 AI Integration

### Google Gemini API

**Setup**:
```
GEMINI_API_KEY=your_api_key
```

**Usage in AIChatController**:
```php
public function chat(Request $request)
{
    $userMessage = $request->input('message');
    
    $client = new \GuzzleHttp\Client();
    $response = $client->post('https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent', [
        'headers' => [
            'Content-Type' => 'application/json',
            'x-goog-api-key' => config('services.gemini.api_key')
        ],
        'json' => [
            'contents' => [
                ['parts' => [['text' => $userMessage]]]
            ]
        ]
    ]);
    
    $aiReply = json_decode($response->getBody(), true);
    return response()->json(['reply' => $aiReply]);
}
```

**Features**:
- Maintenance troubleshooting
- Product recommendations
- General inquiries
- Context-aware responses

---

## 14. 🧪 Testing & Deployment

### Test Accounts

**Admin**:
- Email: `admin@fixit.com`
- Password: `password`

**Technician**:
- Email: `tech@fixit.com`
- Password: `password`

**User**:
- Email: `user@fixit.com`
- Password: `password`

### Seeding Database
```bash
php artisan migrate:fresh --seed
```

### Running the Application
```bash
# Development server
php artisan serve

# Access at: http://127.0.0.1:8000
```

### Production Deployment Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up real SSLCommerz credentials
- [ ] Configure production mail server
- [ ] Enable HTTPS
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set proper file permissions
- [ ] Configure backup system

---

## 📊 Key Metrics for Presentation

### Technical Achievements
- ✅ 228 routes defined
- ✅ 15+ database tables
- ✅ 25+ Blade templates
- ✅ 10+ controllers
- ✅ Multi-role authentication system
- ✅ Real-time notifications
- ✅ Payment gateway integration
- ✅ AI chatbot integration
- ✅ PDF invoice generation
- ✅ Email system with attachments
- ✅ Responsive design (mobile-first)
- ✅ RESTful API structure

### Business Value
- Streamlines maintenance operations
- Reduces request resolution time
- Improves communication
- Enables online parts ordering
- Provides comprehensive reporting
- Enhances user experience
- Scalable architecture

---

## 🎯 Common Interview Questions & Answers

### Q1: Why did you choose Laravel?
**Answer**: Laravel is a modern, full-stack PHP framework that provides:
- Built-in authentication system (Breeze)
- Eloquent ORM for database interaction
- Blade templating engine
- Excellent documentation
- Large community support
- Security features out of the box
- Easy integration with third-party services

### Q2: Explain the MVC pattern in your project
**Answer**: 
- **Model** (app/Models/): Represents database tables and business logic (User, Request, Product)
- **View** (resources/views/): Blade templates for UI (dashboard.blade.php, shop.blade.php)
- **Controller** (app/Http/Controllers/): Handles requests and coordinates Model-View (RequestController, ShopController)

Example: When user visits `/requests`, the route calls `RequestController@index`, which fetches data from `Request` model and passes it to `requests/index.blade.php` view.

### Q3: How does authentication work?
**Answer**: 
1. User registers via `/register` route
2. Password is hashed with bcrypt before storing
3. Email verification sent
4. User logs in via `/login`
5. Session created and stored in database
6. Middleware checks authentication on protected routes
7. Role-based access controlled by custom middleware

### Q4: Explain the payment integration
**Answer**:
1. User completes checkout, order created with "pending" status
2. SSLCommerzService generates payment request with order details
3. User redirected to SSLCommerz payment page
4. After payment, SSLCommerz redirects to our callback URL
5. We validate transaction, update order status
6. Email sent with PDF invoice
7. IPN validates payment authenticity

### Q5: How do notifications work?
**Answer**:
- Laravel's built-in notification system
- Database channel stores notifications
- Real-time updates via AJAX polling (every 30 seconds)
- Bell icon shows unread count
- Click notification marks as read
- Email notifications for important events

### Q6: What security measures did you implement?
**Answer**:
1. CSRF protection on all forms
2. Password hashing with bcrypt
3. SQL injection prevention (Eloquent ORM)
4. XSS prevention (Blade escaping)
5. Role-based access control
6. File upload validation
7. Email verification
8. Session security

### Q7: How would you scale this application?
**Answer**:
1. Database: Implement caching (Redis)
2. Queue system for emails and notifications
3. CDN for static assets
4. Load balancer for multiple servers
5. Database replication (master-slave)
6. Optimize queries (eager loading)
7. Implement API rate limiting

### Q8: Explain your database design
**Answer**:
- Normalized structure (3NF)
- Foreign key relationships
- Indexes on frequently queried columns
- Soft deletes for data integrity
- Timestamps for audit trail
- Pivot tables for many-to-many relationships
- Cascading deletes where appropriate

---

## 🚀 Future Enhancements

Potential improvements to discuss:
1. Mobile app (React Native)
2. Real-time chat (WebSocket)
3. Advanced analytics dashboard
4. Multi-language support
5. SMS notifications
6. Barcode scanning for products
7. Technician mobile app
8. Customer feedback system
9. Warranty tracking
10. Preventive maintenance scheduling

---

## 📝 Conclusion

This FixIt platform demonstrates:
- Full-stack web development skills
- Database design expertise
- Security best practices
- Third-party API integration
- Modern UI/UX design
- Project management
- Problem-solving abilities

**Total Development Time**: ~2-3 months (estimated)
**Lines of Code**: ~15,000+ (PHP, Blade, JavaScript, CSS)
**Technologies Used**: 10+ (Laravel, MySQL, Tailwind, Alpine.js, etc.)

---

*This documentation covers all aspects of the FixIt project. Use it as a reference for your academic presentation and to answer your teacher's questions confidently.*
