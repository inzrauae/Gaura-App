# Gaura Laravel Deployment on cPanel (GitHub + SSH)

This setup is designed for these constraints:

- cPanel document root is fixed to `public_html`
- Composer is not pre-installed
- npm/Node.js is not available on cPanel
- `ext-fileinfo` may be missing
- do not run `php artisan config:cache` on shared hosting
- fix Windows CRLF in `.env` files via `sed -i 's/\r$//'`

## 1) Local build before pushing

From `backend` on your local machine:

```bash
npm install
npm run build
```

This generates `public/build`, which is committed to GitHub for cPanel usage.

## 2) Files added for deployment

- `.env.production` (production DB/app settings)
- `cpanel-index.php` (public_html index bridge to `~/repo-name/backend`)
- `deploy.sh` (first deploy)
- `update.sh` (future updates)

## 3) First deploy from cPanel terminal

Run this single command in cPanel SSH terminal:

```bash
curl -fsSL https://raw.githubusercontent.com/inzrauae/Gaura-App/branch-name/backend/deploy.sh | GITHUB_TOKEN='your_github_token' bash -s -- branch-name repo-name
```

Arguments after `bash -s --` are:

1. branch name (default: `branch-name`)
2. target folder under home (default: `repo-name`)

After deploy:

- application code is in `~/repo-name/backend`
- `public_html/index.php` points to that Laravel app
- `public_html/.htaccess` is copied from Laravel `public/.htaccess`
- `public_html/build` and `public_html/storage` are symlinked

## 4) What deploy.sh does

1. Clones repository into `~/repo-name` (supports private clone with `GITHUB_TOKEN`)
2. Installs Composer via PHP if missing (`~/composer.phar`)
3. Runs:
   - `composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-fileinfo`
4. Copies `.env.production` to `.env`
5. Fixes CRLF line endings in `.env`
6. Runs Laravel setup:
   - `php artisan key:generate --force`
   - `php artisan storage:link`
   - `php artisan migrate --force`
   - `php artisan optimize:clear`
   - `php artisan route:cache`
   - `php artisan view:cache`
7. Copies `cpanel-index.php` and `.htaccess` into `public_html`
8. Symlinks `build/` and `storage/` into `public_html`
9. Sets permissions (`755` directories, `775` writable dirs)

## 5) Future updates

After pushing new code to GitHub, run:

```bash
bash ~/repo-name/backend/update.sh branch-name repo-name
```

## 6) Notes

- `config:cache` is intentionally not used.
- Sample seed data is disabled; production deploys do not run database seeders.
- Ensure the DB user in `.env.production` is exactly what cPanel created.
- If your repo is private, keep token use to terminal commands (avoid committing token anywhere).
