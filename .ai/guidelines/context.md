# PROJECT SPECIFIC CONTEXT

## 🛠 Tech Stack & Standards
- **Environment**: PHP 8.2+ (Matrix testing up to 8.5), Laravel v11-v13, Caleb Porzio's Sushi.
- **Testing**: Pest 4 with `orchestra/testbench`. Workbench directory serves as the primary sandbox.
- **Strictness**: MUST include `declare(strict_types=1);` in all PHP files. Use strict typing for all properties and methods.

## 🏗 Architecture & Data
- **Model Engine**: `Province`, `Regency`, `District`, and `Village` models use the `TerloquentBase` trait, integrating with `Sushi` for database-less Eloquent functionality.
- **Data Sourcing**: CSV files are downloaded **on-demand** per model from raw GitHub URLs. Multi-file or directory-based sourcing is deprecated; each model maps to exactly one remote CSV file.
- **Central Logic**: `AdministrativeDivisionDataHelper` handles file fetching and status, while `TerloquentBaseHelper` manages CSV-to-array parsing and validation.
- **Configuration**: Uses a flat `sources` structure in `config.php` (e.g., `terloquent.sources.provinces`) for direct model-to-URL mapping.

## ⚡ Resilience & Performance
- **Timeout Management**: Default download timeout is set to **60 seconds**, configurable via `TERLOQUENT_DOWNLOAD_TIMEOUT`.
- **Error Handling**: Failed downloads or timeouts trigger a user-friendly `DataSourceUnavailableException`.
- **Caching**: Local CSVs are cached in `storage/framework/cache/terloquent/csv`. Sushi SQLite files are also cached based on environment settings.

## 🧪 Testing Strategy
- **Isolation**: All feature tests MUST use `Http::fake()` (configured globally in `tests/Pest.php`) to eliminate external network dependencies and ensure test stability.
- **Execution**: Always use `composer test` to ensure a clean state (purges workbench skeleton before running Pest).

## ⌨️ Console & Tooling
- **Artisan Prefix**: All package commands use the `terloquent-id:` prefix (e.g., `terloquent-id:status`, `terloquent-id:clear`).
- **CI/CD**: GitHub Actions (`ci.yml`) uses matrix mapping to handle dependency compatibility (Pest 3 for PHP 8.2, Pest 4 for PHP 8.3+).
