# PROJECT SPECIFIC CONTEXT

- **Tech Stack**: PHP 8.4+, Laravel Package, Caleb Porzio's Sushi (database-less Eloquent), Pest 4.
- **Architecture**: Models (Province, Regency, District, Village) use the `TerloquentBase` trait which integrates with `Sushi`.
- **Data Source**: Data is pulled from an external CSV repository: `https://github.com/dominosaurs/id-administrative-divisions.git`.
- **Central Logic**: `TerloquentBaseHelper` is the central hub for data fetching, CSV parsing, and internal cache management.
- **Workflow**: Development uses `orchestra/testbench`. The `workbench/` directory serves as the primary sandbox environment.
- **Strict Standards**: MUST include `declare(strict_types=1);` in all PHP files. Use strict typing for all properties and methods.