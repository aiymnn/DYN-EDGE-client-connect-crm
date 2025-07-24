# ClientConnect CRM - Customer Relationship Management System

🚧 **This project is still under development for testing and learning purposes.**

ClientConnect CRM is a **Laravel-based Customer Relationship Management system** where:

- **Admins** can manage staff, customers, interactions, tickets, and generate reports.
- **Staff** can view and manage their assigned tickets, view customers, and log interactions.
- This project practices **Laravel 12, Tailwind CSS, role-based access, CSV & PDF exports, and CRM workflows.**

---

## ⚙️ Tech Stack

- **Laravel 12**
- **Tailwind CSS**
- **Laravel Breeze** for authentication
- **Laravel Excel** for CSV export
- **dompdf** for PDF export
- **MySQL**
- **Git + GitHub**

---

## 🖼️ Screenshots

### 🔐 Login
![Login](https://github.com/aiymnn/DYN-EDGE-client-connect-crm/blob/development/docs/screenshorts/login.png?raw=true)

---

## 🛠️ Features

---

## 👑 Admin

### 1️⃣ Dashboard with Metrics

- Total customers
- Recent interactions
- Ticket status overview with charts

![Dashboard](https://github.com/aiymnn/DYN-EDGE-client-connect-crm/blob/development/docs/screenshorts/dashboard.png?raw=true)

---

### 2️⃣ Staff Management

- Add new staff
- Edit staff details
- Assign roles (admin, staff)
- Soft delete & restore staff

![Staffs](https://github.com/aiymnn/DYN-EDGE-client-connect-crm/blob/development/docs/screenshorts/staffs.png?raw=true)

---

### 3️⃣ Customer Management

- Add customer with name, email, IC, phone, address, and notes
- Edit customer information
- Delete or restore customer records

![Customers](https://github.com/aiymnn/DYN-EDGE-client-connect-crm/blob/development/docs/screenshorts/customers.png?raw=true)

---

### 4️⃣ Interaction Tracking

- Log customer interactions (call, email, meeting)
- Add notes for each interaction
- Track by customer and interaction type

![Interactions](https://github.com/aiymnn/DYN-EDGE-client-connect-crm/blob/development/docs/screenshorts/interactions.png?raw=true)

---

### 5️⃣ Helpdesk Ticketing System

- Create and manage tickets for customer issues
- Fields: title, description, status, priority
- Assign tickets to specific staff
- Staff view only their assigned tickets

![Tickets](https://github.com/aiymnn/DYN-EDGE-client-connect-crm/blob/development/docs/screenshorts/tickets.png?raw=true)

---

### 6️⃣ Reporting

- Generate reports for customers and tickets
- Export reports as CSV (Laravel Excel) or PDF (dompdf)
- Filter by date range and ticket status

![Reports](https://github.com/aiymnn/DYN-EDGE-client-connect-crm/blob/development/docs/screenshorts/reports.png?raw=true)

---

## 👩‍💼 Staff

### 1️⃣ View Dashboard
- View assigned tickets
- See pending and active issues

### 2️⃣ Manage Assigned Tickets
- View, update, and resolve tickets assigned by admin

### 3️⃣ View Customers
- Access customer details to follow up

### 4️⃣ Log Interactions
- Add follow-up notes or call logs related to customers

---

## 📧 Email Notifications

Uses [Mailtrap](https://mailtrap.io) for testing:

- Password reset notifications
- Ticket updates (can extend for real deployment)

---

## 🗄️ Database Dump for Easy Import

For faster testing, you can import the provided database dump:

- **Dump Location:** `docs/clientconnect_crm.sql`
- Includes demo customers, staff, tickets, and interactions.

### 🔑 Admin Login

Use the following credentials:

- **Email:** `admin@example.com`
- **Password:** `password`

---

### 📥 Import Steps

**Using TablePlus / DBeaver:**

1️⃣ Create a new database, e.g., `clientconnect_crm`.

2️⃣ Import `docs/clientconnect_crm.sql` into your database.

3️⃣ Update your `.env` to match the database name and credentials:

```env
DB_DATABASE=clientconnect_crm
DB_USERNAME=root
DB_PASSWORD=

```

---

## 🚀 How to Clone & Setup

To run this project locally:

```bash
# Clone repository
git clone https://github.com/aiymnn/DYN-EDGE-client-connect-crm.git

cd DYN-EDGE-client-connect-crm

# (Optional) Switch to development branch if needed
# git checkout development

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Build frontend assets
npm run build

# Copy environment file and configure environment variables
cp .env.example .env

# Generate app key
php artisan key:generate

# Set your .env with:
# - MySQL database credentials
# - Mailtrap credentials for email testing

# Run migrations and seeders
php artisan migrate --seed

# Serve the application
php artisan serve

# (Optional) Run queue worker for email and queued jobs
php artisan queue:work
