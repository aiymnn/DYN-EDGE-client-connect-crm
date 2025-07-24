<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

## ClientConnect CRM

ClientConnect CRM is a Laravel-based web application to manage customer relationships effectively. It includes customer management, interaction tracking, helpdesk ticketing, CSV and PDF reporting, and a dashboard for key metrics.

---

## 🚀 Features

- User Authentication (Laravel Breeze)
- Customer Management (CRUD)
- Interaction Tracking
- Helpdesk Ticketing with assignment to team members
- Dashboard with metrics and charts
- CSV Export (Laravel Excel)
- PDF Export (dompdf)
- Tailwind CSS styling
- Role-based access control (Admin, Staff)

---

## 🛠️ Tech Stack

- **Framework:** Laravel 12
- **Styling:** Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **Exports:** Laravel Excel, dompdf
- **Version Control:** Git + GitHub

---

## ⚙️ Installation

```bash
git clone https://github.com/your-username/clientconnect-crm.git
cd clientconnect-crm

composer install
npm install
npm run build

cp .env.example .env
php artisan key:generate

# Configure your .env with your MySQL database credentials
# and Mailtrap credentials (for email testing)

php artisan migrate --seed

php artisan serve
