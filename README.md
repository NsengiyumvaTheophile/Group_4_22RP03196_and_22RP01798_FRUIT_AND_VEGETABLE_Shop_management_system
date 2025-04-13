 Fruits and Vegetable Shop Management System
 -------------------------------------------


 CREDENTIALS
 _____________

 Admin Access
- **Username:** nsengiyumvatheophile12@gmail.com
- **Password:** 123theo@

### User Management

#### Creating Admin Users
1. Register a new user normally through the system
2. Access phpMyAdmin and open the `final_project` database
3. Select the `users` table
4. Find the newly registered user and click edit
5. Enable the admin role for that user
6. The user will automatically become an admin user

#### Creating Regular Users
- Register normally through the system
- Regular users can browse and purchase products

## Project Description

### Overview
This is a comprehensive Fruits and Vegetable Shop Management System built with Laravel 9.x and styled with Tailwind CSS. The system allows customers to browse a variety of fruits and vegetables, add them to their shopping cart, and place orders. The admin panel enables shopkeepers to manage products, track orders, and view order history.

### Key Features

#### User Features
- User registration and authentication
- Product browsing and searching
- Shopping cart management
- Order placement and tracking
- User profile management

#### Admin Features
- Product management (CRUD operations)
- Order management and status updates
- Order approval system
- Dashboard for monitoring sales and activities

#### Technical Features
- Modern Laravel 9.x framework
- Tailwind CSS for responsive and modern UI
- Laravel Breeze for authentication
- Laravel Sanctum for API security
- MySQL database
- RESTful API endpoints
- Secure payment processing
- Responsive design for all devices

### System Pages

1. **Homepage**
   - Featured fruits and vegetables display
   - Quick access to popular products

2. **Product Listing Page**
   - Comprehensive display of all available fruits and vegetables
   - Filtering and sorting options

3. **Product Detail Page**
   - Detailed product information
   - Price and description
   - Add to cart functionality

4. **Shopping Cart**
   - Product quantity management
   - Price calculation
   - Total cost summary

5. **Order Page**
   - Shipping information collection
   - Order confirmation
   - Payment processing

6. **Admin Dashboard**
   - Product management interface
   - Order tracking system
   - Sales statistics and reports

## Requirements

- PHP >= 8.0.2
- Composer
- Node.js and NPM
- MySQL or compatible database

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd MINPROj
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Copy the environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in the `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=final_project
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations:
```bash
php artisan migrate
```

8. Build assets:
```bash
npm run build
```

## Development

To start the development server:
```bash
php artisan serve
```

For watching and compiling assets:
```bash
npm run dev
```

## Testing

Run the tests using:
```bash
php artisan test
```













