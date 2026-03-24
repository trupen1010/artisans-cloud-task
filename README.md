# Artisans Cloud Task - Education Management System

A modern Laravel 13 application for managing educational institutions including teachers, students, parents, announcements, and role-based permissions.

## Features

- **User Management** - Teachers, Students, Parents with role-based access
- **Announcement System** - School-wide communication with email notifications
- **Role & Permission Management** - Granular access control system
- **Modern Tech Stack** - Laravel 13, PHP 8.4, MySQL
- **AI-Enhanced Development** - Laravel Boost integration for enhanced productivity

## Requirements

- **PHP**: 8.4 or higher
- **MySQL**: 8.0 or higher
- **Composer**: 2.0 or higher
- **Git**: Latest version

## Quick Start

### 1. Clone Repository

```bash
git clone https://github.com/trupen1010/artisans-cloud-task.git
cd artisans-cloud-task
```

### 2. Automated Setup

The fastest way to get started is using our automated setup script:

```bash
composer run setup
```

This single command will:
- Install PHP dependencies
- Copy `.env.example` to `.env`
- Generate application key
- Run database migrations
- Install Node.js dependencies
- Build frontend assets

### 3. Database Configuration

Edit your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=artisans_cloud_task
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Create Database

```bash
mysql -u your_username -p
CREATE DATABASE artisans_cloud_task;
exit
```

### 5. Run Migrations & Seeders

```bash
php artisan migrate
```
```bash
php artisan db:seed --class=PermissionTableSeeder
```

### 6. Start Development

```bash
# Or start individual services
php artisan serve              # Laravel development server
php artisan queue:work        # Queue worker
```

The application will be available at `http://localhost:8000`

## Manual Installation

If you prefer manual installation or the automated setup fails:

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup

```bash
# Create database (ensure MySQL is running)
mysql -u root -p
CREATE DATABASE artisans_cloud_task;
exit

# Update .env with your database credentials
# Then run migrations
php artisan migrate
```

## Development Workflow

### Starting Development Environment

Use the convenient development script that starts all services:

```bash
composer run dev
```

This starts:
- **Laravel Server** (Port 8000) - Main application
- **Queue Worker** - Background job processing

### Running Tests

```bash
# Run all tests
composer run test
# or
php artisan test

# Run specific test
php artisan test --filter=UserTest

# Run with coverage
php artisan test --coverage
```

### Code Quality

```bash
# Fix code style automatically
./vendor/bin/pint
```

## Package Information

### Core Framework
- **Laravel Framework**: 13.1.1
- **PHP Version**: 8.4

### Development Tools
- **Laravel Boost**: 2.3.4 - AI-enhanced development tools
- **Laravel Pail**: 1.2.6 - Beautiful logs
- **Laravel Pint**: 1.29.0 - Code styling
- **Pest Testing**: 4.4.3 - Modern testing framework

## Project Structure

```
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   │   ├── User.php         # User management
│   │   ├── Teacher.php      # Teacher model
│   │   ├── Student.php      # Student model
│   │   ├── ParentModel.php  # Parent model
│   │   ├── Announcement.php # Announcements
│   │   ├── Role.php         # User roles
│   │   └── Permission.php   # Permissions
│   └── Helpers/             # Helper functions
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/            # Database seeders
│   └── factories/          # Model factories
├── resources/
│   ├── views/              # Blade templates
│   ├── js/                 # JavaScript files
│   └── css/                # CSS files
├── routes/
│   └── web.php             # Web routes
└── tests/                  # Test files
```

## Environment Configuration

The application supports multiple environment configurations:

### Local Development (.env.local)
```env
APP_ENV=local
APP_DEBUG=true
LOG_LEVEL=debug
```

### Production (.env.production)
```env
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
```

### Key Configuration Options

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_NAME` | Application name | Laravel |
| `APP_URL` | Base application URL | http://localhost |
| `DB_DATABASE` | Database name | artisans_cloud_task |
| `MAIL_MAILER` | Mail driver | log |
| `QUEUE_CONNECTION` | Queue driver | database |

## Available Commands

### Composer Scripts

```bash
# Complete setup from scratch
composer run setup

# Start development environment
composer run dev

# Run tests
composer run test
```

### Artisan Commands

```bash
# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Refresh database with seeders
php artisan migrate:fresh --seed

# Clear application cache
php artisan optimize:clear

# View all routes
php artisan route:list

# Create new models, controllers, etc.
php artisan make:model ModelName
php artisan make:controller ControllerName
php artisan make:test TestName
```