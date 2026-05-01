# University Community Library CMS

## Implemented scope

- Public website for articles (visitors + registered users).
- Protected library PDF downloads for authenticated users only.
- Admin dashboard for:
  - User management (role and active status)
  - Article management (create/edit/delete + pin on top)
  - PDF library management (upload/hide/remove)

## Storage provider strategy

`LIBRARY_STORAGE_PROVIDER` controls provider selection:

- `local` (active now, fully implemented)
- `google_drive` (config placeholder ready)
- `onedrive` (config placeholder ready)

Current behavior:

- Upload/download works for `local`.
- If `google_drive` or `onedrive` is selected, app returns a clear message that cloud integration is pending confirmation.

## Default seeded users

- Admin: `admin@university.local` / `admin12345`
- Student: `student@university.local` / `student12345`

## Setup

1. `php artisan migrate:fresh --seed`
2. `php artisan serve`
3. Open homepage and login with seeded admin account.
