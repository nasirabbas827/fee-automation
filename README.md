# fee_automation  

A lightweight PHP application that streamlines the management of fee vouchers, categories, scholarships, and user accounts for educational institutions.  

---  

## Overview  

`fee_automation` provides an admin‑driven interface for creating and tracking fee vouchers, assigning them to students, and generating monthly/annual reports. The system is built around a simple MySQL database and can be deployed on any standard LAMP/LEMP stack.  

---  

## Features  

| ✅ | Feature |
|---|---|
| ✔️ | **Admin authentication** – secure login with session handling |
| ✔️ | **Category management** – add, edit, view fee categories |
| ✔️ | **User management** – create, edit, delete staff or student accounts |
| ✔️ | **Voucher handling** – generate, edit, view, and revoke fee vouchers |
| ✔️ | **Scholarship support** – define scholarships and link them to vouchers |
| ✔️ | **Reporting** – monthly, student‑wise, and overall fee reports (PDF/HTML) |
| ✔️ | **Responsive UI** – clean CSS styling (`css/style.css`) |
| ✔️ | **Support page** – contact form for technical assistance (`contact_support.php`) |
| ✔️ | **Extensible configuration** – central `config.php` for DB credentials and app settings |

---  

## Tech Stack  

| Layer | Technology |
|-------|------------|
| Backend | PHP 7.4+ |
| Database | MySQL / MariaDB (see `Database/fee_db.sql`) |
| PDF Generation | FPDF (included in `fpdf/`) |
| Front‑end | HTML5, CSS3 (custom stylesheet) |
| Server | Apache / Nginx (any LAMP/LEMP environment) |

---  

## Installation  

1. **Clone the repository**  

   ```bash
   git clone https://github.com/yourusername/fee_automation.git
   cd fee_automation
   ```

2. **Create the database**  

   ```bash
   mysql -u root -p < Database/fee_db.sql
   ```

   > *If you prefer a different database name, edit the `DB_NAME` constant in `config.php` accordingly.*

3. **Configure the application**  

   Open `config.php` (and `admin/config.php` if you keep a separate admin config) and set your database credentials:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'YOUR_DB_USER');
   define('DB_PASS', 'YOUR_DB_PASSWORD');
   define('DB_NAME', 'fee_automation');
   ```

   > Replace `YOUR_DB_USER` and `YOUR_DB_PASSWORD` with your own credentials.

4. **Set up the web server**  

   - **Apache**: Ensure `mod_rewrite` is enabled and point the virtual host document root to the project folder.  
   - **Nginx**: Use a `location /` block that points to the project directory and passes PHP files to `php-fpm`.  

5. **Adjust file permissions** (if required)

   ```bash
   sudo chown -R www-data:www-data .
   sudo chmod -R 755 .
   ```

6. **Optional – Composer dependencies**  

   The core project does not require Composer packages, but if you add extensions later, run:

   ```bash
   composer install
   ```

---  

## Usage  

1. **Access the admin portal**  

   Open your browser and navigate to:  

   ```
   http://your-domain.com/admin/admin_login.php
   ```

   Use the default credentials (change them after first login):

   - **Username:** `admin`
   - **Password:** `admin123`

2. **Dashboard**  

   After login you will land on `admin/admin_home.php`, where you can:

   - Add **categories** (`admin/add_categories.php