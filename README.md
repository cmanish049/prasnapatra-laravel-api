# Prasnapatra API

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About

Prasnapatra API is a Laravel 12 REST API built with modern best practices and essential configurations for reliable, production-grade applications.

## Tech Stack

- **Framework**: Laravel 12
- **Language**: PHP 8.5+
- **Database**: SQLite (development), MySQL/PostgreSQL (production)
- **Authentication**: Laravel Sanctum
- **Testing**: Pest 4
- **Code Quality**: 
  - Larastan (Static Analysis)
  - PHP Pint (Formatting)
  - Rector (Automated Refactoring)
- **Frontend Bundling**: Vite
- **CSS**: Tailwind CSS v4

## Features

- ✅ **Strict Eloquent Models** - Prevents lazy loading, attribute discarding, and missing attribute access in development
- ✅ **Immutable Dates** - Uses CarbonImmutable for date handling
- ✅ **Destructive Command Protection** - Blocks dangerous commands in production
- ✅ **API Authentication** - Laravel Sanctum for token-based authentication
- ✅ **Database Migrations** - Clean migrations for users and personal access tokens
- ✅ **Comprehensive Testing** - Pest testing framework with factories and seeders
- ✅ **Code Quality Tools** - Static analysis, formatting, and automated refactoring

## Requirements

- PHP 8.5 or higher
- Composer
- Node.js & npm
- Laravel Herd (for local development)

## Installation

### 1. Clone and Setup

```bash
composer install
npm install
```

### 2. Generate Application Key

```bash
composer run setup
```

This command will:
- Install dependencies
- Create `.env` file
- Generate application key
- Run database migrations
- Build frontend assets

### 3. Running Locally

```bash
composer run dev
```

This starts:
- Laravel development server
- Vite asset bundler
- Queue listener
- Application logs

## API Documentation

### Authentication

All API endpoints (except `/api/register` and `/api/login`) require authentication via Bearer token:

```http
Authorization: Bearer {token}
```

Obtain tokens via Sanctum authentication endpoints.

### Available Routes

Routes are defined in:
- `routes/api.php` - API endpoints
- `routes/web.php` - Web-facing routes
- `routes/console.php` - Artisan commands

## Development

### Code Quality

Run code quality tools before committing:

```bash
# Format code (automatically fixes issues)
composer run pint

# Check formatting without changes (dry-run)
composer run pint:check

# Format only changed files
composer run pint:dirty

# Static analysis
composer run larastan

# Automated refactoring
composer run rector
```

### Testing

Run the test suite:

```bash
composer run test
```

Run specific tests:

```bash
php artisan test --filter=TestName
```

## Database

### Migrations

Run migrations:

```bash
php artisan migrate
```

Create a new migration:

```bash
php artisan make:migration create_table_name
```

### Seeders

Seed the database:

```bash
php artisan db:seed
```

## Project Structure

```
├── app/
│   ├── Http/Controllers/    # API controllers
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   ├── factories/           # Model factories
│   └── seeders/             # Database seeders
├── routes/
│   ├── api.php              # API routes
│   ├── web.php              # Web routes
│   └── console.php          # Console commands
├── config/                  # Configuration files
├── tests/                   # Test suite (Pest)
└── storage/                 # Application storage
```

## Configuration

### Environment Variables

Key environment variables in `.env`:

```
APP_NAME=Prasnapatra
APP_ENV=local|production
APP_DEBUG=true|false
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite|mysql
DB_DATABASE=database.sqlite

SANCTUM_STATEFUL_DOMAINS=localhost

QUEUE_CONNECTION=sync|redis
```

See `config/` directory for detailed configuration options.

## Deployment

### Production Checklist

1. Set application to production mode:
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   ```

2. Generate application key (if not done):
   ```bash
   php artisan key:generate
   ```

3. Run migrations:
   ```bash
   php artisan migrate --force
   ```

4. Cache configuration, routes, and views:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

5. Install production dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   npm run build
   ```

## Debugging

### Tinker Console

Access Laravel Tinker for interactive debugging:

```bash
php artisan tinker
```

### Logs

Application logs are stored in `storage/logs/`. View recent logs:

```bash
tail -f storage/logs/laravel.log
```

### Debugbar

In development, the Laravel Debugbar is available at the bottom of each page, showing queries, timing, and more.

## Contributing

We welcome contributions! Please read our contribution guidelines before submitting pull requests.

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

If you discover a security vulnerability, please email [security@example.com](mailto:security@example.com) instead of using the issue tracker.

## License

Prasnapatra API is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
