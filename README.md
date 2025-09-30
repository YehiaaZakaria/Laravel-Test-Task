# User Management System

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-purple.svg)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

A modern, responsive user management system built with Laravel 10. Features complete CRUD operations, profile picture management, international phone number support with country codes, and WhatsApp integration.

## 🚀 Features

- ✅ **Complete User Management** - Create, read, update, delete users
- 📸 **Profile Picture Upload** - Image upload with validation and storage
- 🌍 **International Phone Numbers** - Country code dropdown with validation
- 📱 **WhatsApp Integration** - Direct messaging links from user profiles
- 🎨 **Modern UI/UX** - Bootstrap 5 with responsive design
- ✔️ **Form Validation** - Comprehensive server-side validation
- 📄 **Pagination** - Easy browsing through user lists
- 🕒 **Timezone Support** - Configured for Egypt timezone (Africa/Cairo)


## 🛠️ Tech Stack

- **Backend**: Laravel 10, PHP 8.1+
- **Frontend**: Bootstrap 5, Select2, JavaScript
- **Database**: MySQL 5.7+
- **APIs**: REST Countries API for country data
- **Storage**: Laravel Storage for file management

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js & NPM

## ⚡ Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/user-management-system.git
   cd user-management-system
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database in `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and setup storage**
   ```bash
   php artisan migrate
   php artisan storage:link
   ```

6. **Build assets and start server**
   ```bash
   npm run dev
   php artisan serve
   ```

Visit `http://localhost:8000/users` to access the application.

## 📖 Usage

### Managing Users
- **View All Users**: Browse paginated user list with search functionality
- **Add New User**: Complete form with profile picture upload
- **Edit User**: Update user information and profile picture
- **Delete User**: Remove users with confirmation dialog
- **User Details**: View complete user profile with WhatsApp contact option

### Phone Number Features
- **Country Selection**: Searchable dropdown with country flags
- **Automatic Validation**: Phone number format validation per country
- **WhatsApp Links**: One-click messaging to user's WhatsApp

## 🏗️ Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   └── UserController.php      # Main CRUD controller
│   └── Models/
│       └── User.php                # User model with relationships
├── resources/views/users/
│   ├── index.blade.php             # User listing page
│   ├── create.blade.php            # Create user form
│   ├── edit.blade.php              # Edit user form
│   └── show.blade.php              # User profile view
├── database/migrations/
│   └── create_users_table.php      # Database schema
└── public/storage/                 # Profile pictures storage
```

## 🔧 Configuration

### Timezone Settings
```php
// config/app.php
'timezone' => 'Africa/Cairo',
```

### File Upload Settings
- **Allowed formats**: JPG, PNG, GIF
- **Maximum size**: 2MB
- **Storage path**: `storage/app/public/profile_pictures/`

### Validation Rules
- **Name**: Required, max 255 characters
- **Email**: Required, valid email format, unique
- **Phone**: Optional with country code
- **Profile Picture**: Required, image validation


## 👨‍💻 Author

**Your Name**
- GitHub: (https://github.com/YehiaaZakaria)
- LinkedIn: (https://linkedin.com/in/yehia-zakaria-mohyee)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP framework
- [Bootstrap](https://getbootstrap.com) - CSS framework
- [Select2](https://select2.org) - Enhanced select boxes
- [REST Countries API](https://restcountries.com) - Country data API

## 📞 Support

If you have any questions or need help, please:
- Open an issue on GitHub
- Contact me via email: yehiazakaria539@gmail.com

---

⭐ **Star this repository if you found it helpful!**
