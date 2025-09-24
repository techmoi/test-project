# Laravel Product Management Project

This is a Laravel-based product management system 

---

## Features

- Product CRUD (Create, Read, Update, Delete)
- Product Categories management
- Admin Login
- Input validation
- Database seeding for initial admin and sample data

---

## Requirements

- PHP >= 8.2
- Composer
- MySQL
- Laravel 12

---

## Installation & Setup


Follow the steps below to set up the project on your local machine:

1. Clone the Repository
git clone https://github.com/techmoi/test-project.git
cd test-project

2. Install Dependencies
composer install

3. Environment Setup

Copy .env.example to .env

cp .env.example .env


Generate the application key

php artisan key:generate


Configure your database settings in the .env file.

4. Run Migrations & Seed the Database
php artisan migrate --seed


The seeder will create an initial admin user and some sample data.

5. Serve the Application
php artisan serve


The application will be available at:
http://127.0.0.1:8000

👤 Admin Login

Default admin credentials (created via seeder):

Email: admin@example.com

Password: password123

⚠️ You can change these credentials in the seeder file before running the migration/seed.
