# FixIt Shop - E-commerce Feature Documentation

## Overview
The FixIt Shop is a fully integrated e-commerce system that allows users to purchase maintenance-related products, with seamless integration to service requests where technicians can recommend replacement products.

## Features Implemented

### 1. Product Management (Admin)
- **Location**: `/admin/products`
- **Features**:
  - Complete CRUD operations for products
  - Product activation/deactivation toggle
  - Image upload support
  - Stock management with automatic status updates
  - Category-based organization
  - Warranty and brand information

### 2. Customer Shopping Experience
- **Product Browsing** (`/shop`):
  - Product grid view with images
  - Advanced filtering (category, price range, stock status)
  - Search functionality
  - Sorting options (newest, name, price)
  - Pagination

- **Product Details** (`/shop/{product}`):
  - Detailed product information
  - Stock availability
  - Add to cart functionality
  - Related products suggestions
  - Warranty information

### 3. Shopping Cart
- **Location**: `/cart`
- **Features**:
  - Works for both logged-in and guest users (session-based)
  - Real-time cart count in navigation
  - Quantity updates
  - Price calculations
  - Remove items
  - Clear cart option
  - Stock validation

### 4. Checkout & Orders
- **Checkout** (`/checkout`):
  - Shipping information form
  - Payment method selection (COD ready, online payment coming soon)
  - Order summary
  - Order notes

- **Order Management** (`/orders`):
  - Order history for users
  - Order tracking with visual timeline
  - Order details page
  - Status updates (pending → processing → shipped → delivered)
  - Payment status tracking

### 5. Admin Order Management
- **Location**: `/admin/orders`
- **Features**:
  - View all customer orders
  - Update order status
  - Update payment status
  - View order details
  - Customer information

### 6. Service Request Integration ⭐
**New Feature**: Technicians can now suggest replacement products directly from service requests!

- **For Technicians/Admins**:
  - Product suggestion interface on request detail page
  - Shows products from the same category
  - Select multiple products to recommend
  - Add replacement notes
  - Visual product cards with images and prices

- **For Customers**:
  - View suggested products on their service request
  - One-click "Add to Cart" for suggested products
  - Quick link to view product details
  - Technician notes displayed

## Database Structure

### Products Table
```
- id
- name
- description
- category_id (linked to categories)
- price
- quantity
- brand
- image
- warranty
- is_active
- stock_status (in_stock, low_stock, out_of_stock)
- timestamps
```

### Carts Table
```
- id
- user_id (nullable for guest carts)
- session_id (for guest users)
- product_id
- quantity
- price
- timestamps
```

### Orders Table
```
- id
- order_number (auto-generated)
- user_id
- total_amount
- payment_method (cod, online)
- payment_status (pending, paid, failed)
- order_status (pending, processing, shipped, delivered, cancelled)
- shipping_name
- shipping_phone
- shipping_address
- shipping_city
- shipping_postal_code
- notes
- delivered_at
- timestamps
```

### Order Items Table
```
- id
- order_id
- product_id
- quantity
- price
- subtotal
- timestamps
```

### Requests Table (Updated)
```
... existing fields ...
- suggested_products (JSON array of product IDs)
- replacement_notes
```

## Routes

### Public Routes
```php
GET  /shop                  - Browse products
GET  /shop/{product}        - Product details
GET  /cart                  - View cart
POST /cart/{product}        - Add to cart
PUT  /cart/{cart}           - Update cart item
DELETE /cart/{cart}         - Remove cart item
DELETE /cart                - Clear cart
```

### Authenticated Routes
```php
GET  /checkout              - Checkout page
POST /orders                - Place order
GET  /orders                - Order history
GET  /orders/{order}        - Order details
POST /requests/{request}/suggest-products - Suggest products (technician)
```

### Admin Routes
```php
GET    /admin/products                      - List products
GET    /admin/products/create               - Create product form
POST   /admin/products                      - Store product
GET    /admin/products/{product}/edit       - Edit product form
PUT    /admin/products/{product}            - Update product
DELETE /admin/products/{product}            - Delete product
PUT    /admin/products/{product}/toggle-active - Toggle status
GET    /admin/orders                        - List orders
PUT    /admin/orders/{order}/status         - Update order status
```

## Sample Products Seeded
The database has been seeded with 23 sample products across 5 categories:
- **Plumbing**: Pipe wrenches, faucet kits, PVC cutters, fill valves
- **Electrical**: Multimeters, wire strippers, LED bulbs, circuit breakers
- **HVAC**: Air filters, thermostats, refrigerant gauges
- **Carpentry**: Drills, tool belts, chisels, circular saws
- **Painting**: Roller kits, brush sets, sprayers, tape, drop cloths

All products include:
- Realistic pricing ($12.99 - $199.99)
- Brand names (DeWalt, Stanley, Fluke, etc.)
- Warranty information
- Stock quantities with proper stock status

## Usage Flow

### Customer Journey
1. Browse products in the shop
2. Search/filter by category, price, or stock
3. View product details
4. Add products to cart
5. Review cart and update quantities
6. Proceed to checkout (login if needed)
7. Enter shipping information
8. Select payment method (COD)
9. Place order
10. Track order status
11. View order history

### Technician Journey (Product Suggestion)
1. Review service request
2. Identify items needing replacement
3. Click "Suggest Replacement Products" section
4. Select relevant products from category
5. Add notes about why products are recommended
6. Submit suggestions
7. Customer receives notification and can purchase directly

### Admin Journey
1. Add/manage products via admin panel
2. Upload product images
3. Set prices and stock quantities
4. Activate/deactivate products
5. View all orders
6. Update order and payment status
7. Track order fulfillment

## Key Features Highlights

✅ **Guest Cart Support**: Users can add items before logging in
✅ **Smart Stock Management**: Automatic stock status updates (in_stock, low_stock, out_of_stock)
✅ **Product Images**: Full image upload and display support
✅ **Order Tracking**: Visual timeline showing order progress
✅ **Service Integration**: Revolutionary product suggestion feature for technicians
✅ **Responsive Design**: Works perfectly on mobile and desktop
✅ **Real-time Cart Count**: Navigation shows current cart item count
✅ **Safety Checks**: Stock validation before checkout
✅ **Order Numbers**: Auto-generated unique order numbers (ORD20251010001)

## Future Enhancements
- Online payment gateway integration
- Product reviews and ratings
- Wishlist functionality
- Product comparison
- Email notifications for orders
- Admin sales analytics dashboard
- Bulk product import
- Product variants (size, color)
- Promotional codes/discounts
- Inventory alerts for low stock

## Testing
To test the complete flow:
1. Run: `php artisan db:seed --class=ProductSeeder` (already done)
2. Visit `/shop` to browse products
3. Add items to cart
4. Complete checkout process
5. As admin, visit `/admin/products` and `/admin/orders`
6. As technician, open a service request and suggest products

---

**Congratulations!** FixIt now has a complete e-commerce platform integrated with maintenance services! 🎉
