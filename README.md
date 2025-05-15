# Sales Page Laravel Application

## Overview
This is a **Sales Page Laravel Application** designed to provide a seamless e-commerce experience. It integrates multiple payment gateways, including **M-Pesa, PayPal, MTN, and Stripe**, while offering features such as coupons, discounts, blogs, and downloadable books.

## Features
- **User Authentication & Authorization**
  - Secure login and registration
  - Role-based access control

- **Payment Integrations**
  - **M-Pesa** (for Kenyan mobile payments)
  - **PayPal** (for global transactions)
  - **MTN Mobile Money** (for African transactions)
  - **Stripe** (for credit card payments)

- **E-commerce Functionalities**
  - Add to cart and checkout
  - Order management system
  - Coupon and discount system
  - Downloadable books (PDF, EPUB, etc.)

- **Blog Module**
  - Write and manage blog posts
  - Comments and reviews

- **Admin Dashboard**
  - Manage users and roles
  - Monitor transactions and sales
  - Manage blog content

## Installation Guide

### Prerequisites
Ensure you have the following installed:
- **PHP 8.x**
- **Composer**
- **Laravel 9+**
- **MySQL/MariaDB**
- **Node.js & NPM** (for frontend dependencies)

### Setup Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/salespage.git
   cd salespage
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install && npm run dev
   ```
3. Configure environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Set up the database:
   ```bash
   php artisan migrate --seed
   ```
5. Start the development server:
   ```bash
   php artisan serve
   ```

## Configuration
### Payment Gateways
Update your `.env` file with the required credentials:
```env
MPESA_CONSUMER_KEY=your_consumer_key
MPESA_CONSUMER_SECRET=your_consumer_secret
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_SECRET=your_paypal_secret
MTN_API_KEY=your_mtn_api_key
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
```

## Usage
- **User Registration/Login**: Register as a customer or admin.
- **Making a Purchase**: Add items to cart and choose a payment method.
- **Using Coupons**: Apply discounts at checkout.
- **Downloading Books**: Purchase and access downloadable content.
- **Admin Panel**: Manage users, transactions, and content.

## API Endpoints
| Method | Endpoint           | Description |
|--------|-------------------|-------------|
| POST   | `/api/login`       | User login |
| POST   | `/api/register`    | User registration |
| GET    | `/api/products`    | Fetch all products |
| GET    | `/api/checout\delivary`    | Fetch Delivary |
| POST   | `/api/payment/mpesa`  | Process M-Pesa payment |
| POST   | `/api/payment/paypal` | Process PayPal payment |
| POST   | `/api/payment/mtn`    | Process MTN payment |
| POST   | `/api/payment/stripe` | Process Stripe payment |
| POST   | `Admin part` | Dashboard for Admin |

## Contributing
Feel free to fork this project and submit pull requests. Contributions are welcome!

## License
This project is licensed under the **MIT License**.

## Contact
For inquiries and support, reach out via:
- **Email:** edwinkiuma@gmail.com
- **GitHub Issues**: [Open an issue](https://github.com/edwin659898/salespage/issues)
