# Repository Guidelines

## Project Structure & Module Organization

This PHP 8.2+ application uses Laravel 12 and Filament 4 to monitor fiscal printer licenses.

- `app/Models/` contains devices, companies, categories, and users.
- `app/Filament/Resources/` organizes admin features into resource classes, `Pages/`, `Schemas/`, and `Tables/`; dashboard widgets live in `app/Filament/Widgets/`.
- `app/Console/Commands/` contains license notification logic; `routes/console.php` defines its schedule.
- `database/` holds migrations, factories, and seeders.
- `resources/` contains Blade views, CSS, and JavaScript; Vite builds frontend assets into `public/build/`.
- `tests/Unit/` and `tests/Feature/` contain automated tests.

## Build, Test, and Development Commands

- `composer setup` installs PHP and Node dependencies, creates `.env` if missing, generates an application key, runs migrations, and builds assets. Configure your local database before running it.
- `composer dev` starts the HTTP server, queue listener, log viewer, and Vite together.
- `npm run dev` starts Vite only; `npm run build` produces production assets.
- `php artisan migrate` applies database migrations.
- `composer test` clears cached configuration and runs the test suite.
- `php artisan test --filter=ExampleTest` runs matching tests.
- `vendor/bin/pint --dirty` formats changed PHP files.

## Coding Style & Naming Conventions

Follow `.editorconfig`: four spaces, UTF-8, LF endings, and a final newline; YAML uses two spaces except `compose.yaml`. Use Laravel Pint for PHP formatting. Match PSR-4 namespaces to directories, use PascalCase class names and camelCase methods, and preserve snake_case database fields such as `licence_end`. Follow existing Filament patterns such as `DeviceResource`, `DeviceForm`, and `DevicesTable`. Use timestamped migrations for schema changes.

## Testing Guidelines

Tests use PHPUnit 11 with an in-memory SQLite database. Name files `*Test.php` and methods `test_describes_behavior`. Use unit tests for isolated logic and feature tests for application behavior; use `RefreshDatabase` for database-backed tests. Cover changed behavior, especially expiration dates and notification deduplication, and mock Telegram calls. No minimum coverage threshold is configured.

## Commit & Pull Request Guidelines

History uses short descriptive subjects, such as `Companies for devices`; no formal prefix convention is established. Keep commits focused. PRs should explain the change, link relevant issues, list validation commands and results, and include screenshots for Filament UI changes. Describe migration or configuration requirements.

## Security & Configuration

Keep credentials in `.env`; never commit secrets. Update `.env.example` when adding configuration. The scheduler runs `devices:notify-7days` every minute and can send real Telegram messages; use isolated credentials for local notification work.
