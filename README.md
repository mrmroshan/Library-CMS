# Library CMS

University Community Library CMS built with Laravel.

## What this project includes

- Public website for articles and announcements
- Protected PDF library downloads for registered users
- Admin dashboard for:
  - User management
  - Article management (including pin-to-top)
  - PDF upload/hide/remove
  - Category management for library books
- Automatic thumbnail generation for library books

## Project structure

- `backend/` - Laravel application source code
- `.cursor/rules/` - Project-specific AI coding rules

## Local setup

1. Open terminal in `backend/`
2. Install dependencies:
   - `composer install`
3. Copy env and generate key:
   - `cp .env.example .env`
   - `php artisan key:generate`
4. Run migrations and seeders:
   - `php artisan migrate --seed`
5. Start development server:
   - `php artisan serve`

## Demo admin credentials

- Email: `admin@university.local`
- Password: `admin12345`

## Additional docs

- `backend/ADMIN_USER_GUIDE.md`
- `backend/PROJECT_OVERVIEW.md`
