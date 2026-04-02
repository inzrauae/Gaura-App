# Gaura Laravel Backend Deployment (cPanel)

## 1) Local setup (developer machine)

1. Open terminal in `backend`.
2. Install dependencies:
   - `composer install`
3. Create environment file:
   - `copy .env.example .env`
4. Generate app key:
   - `php artisan key:generate`
5. Use SQLite for local quick run (already default), then migrate:
   - `php artisan migrate`
6. Create storage symlink for receipt files:
   - `php artisan storage:link`
7. Start local server:
   - `php artisan serve`
8. API is available at:
   - `http://127.0.0.1:8000/api/expenses`

## 2) API endpoints

- `GET /api/health`
- `GET /api/expenses`
- `POST /api/expenses`
- `GET /api/expenses/{expense}`
- `PUT /api/expenses/{expense}`
- `PATCH /api/expenses/{expense}`
- `DELETE /api/expenses/{expense}`

### POST/PATCH fields

- `expense_date` (required for create, date)
- `category` (`Labor`, `Materials`, `Transport`, `Equipment`, `Other`)
- `title` (string)
- `amount` (number)
- `payment_type` (`company_paid` or `director_paid`)
- `notes` (optional string)
- `receipt` (optional file: jpg/jpeg/png/pdf, max 10MB)

## 3) cPanel production deployment

1. In cPanel, create:
   - MySQL database
   - MySQL user
   - grant all privileges to that user
2. Upload backend files to a folder such as `~/gaura-backend` (not directly inside public_html).
3. In `~/gaura-backend`, run Composer from cPanel terminal/SSH:
   - `composer install --no-dev --optimize-autoloader`
4. Copy `.env.cpanel.example` to `.env` and set real values.
5. Generate app key:
   - `php artisan key:generate --force`
6. Run migrations:
   - `php artisan migrate --force`
7. Create storage link:
   - `php artisan storage:link`
8. Cache for production:
   - `php artisan config:cache`
   - `php artisan route:cache`
   - `php artisan view:cache`

## 4) cPanel document root

Laravel should serve from `public` directory.

Use one of these approaches:

1. Preferred (if your hosting allows custom document root):
   - set domain/subdomain document root to `~/gaura-backend/public`
2. Shared hosting fallback:
   - copy contents of `~/gaura-backend/public` into `~/public_html`
   - edit `index.php` in `public_html` to point to backend paths:
     - `require __DIR__.'/../gaura-backend/vendor/autoload.php';`
     - `$app = require_once __DIR__.'/../gaura-backend/bootstrap/app.php';`

## 5) Connect frontend UI

`code.html` uses:
- `const apiBaseUrl = "http://127.0.0.1:8000/api";`

Before production, change it to your domain API URL, for example:
- `https://your-domain.com/api`

## 6) Troubleshooting

- 500 error:
  - check `storage/logs/laravel.log`
  - ensure `APP_KEY` exists
- permission issues:
  - ensure write access to `storage` and `bootstrap/cache`
- receipt URLs 404:
  - run `php artisan storage:link`
- migration fails:
  - verify DB credentials and privileges in `.env`
