# 🇮🇩 Terloquent ID

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/terloquent/id)](https://packagist.org/packages/terloquent/id)

**Eloquent models for Indonesian administrative regions — no database required.**

Powered by [Sushi](https://github.com/calebporzio/sushi), **Terloquent ID** lets you query provinces, cities, districts, and villages instantly — without any migrations or seeders.

## ✨ Features

- 🇮🇩 Ready-to-use Indonesian administrative data: **Province**, **City**, **District**, **Village**
- ⚡ Works like standard Eloquent models (`where`, `first`, `whereLike`, etc.)
- 🧠 No migrations or seeding required
- 🗃️ Auto-cached via Sushi for fast performance
- 📦 Uses external CSV data from [sensasi-delight/id-administrative-divisions](https://github.com/sensasi-delight/id-administrative-divisions)

## 🚀 Installation

```bash
composer require terloquent/id
```

> Requires the [`pdo_sqlite` PHP extension](https://www.php.net/manual/en/ref.pdo-sqlite.php).

Start using it right away:

```php
use TerloquentID\City;

$city = City::whereLike('name', '%Samarinda%')->firstOrFail();
```

No setup. No migrations. No database.

## 🧩 Data Source

The administrative data is sourced from the open dataset repository:
👉 [**sensasi-delight/id-administrative-divisions**](https://github.com/sensasi-delight/id-administrative-divisions)

This repository provides CSV files representing Indonesia’s full administrative hierarchy:

```text
Province → City → District → Village
```

It may also include additional metadata such as:

- Official region codes (Kemendagri / BPS)
- Coordinates (latitude, longitude)
- Postal codes
- Other optional attributes

> Users cannot modify the data at runtime.
> To suggest updates or corrections, please open a pull request to [sensasi-delight/id-administrative-divisions](https://github.com/sensasi-delight/id-administrative-divisions).

## ⚙️ Under the Hood

- Built on [Sushi](https://github.com/calebporzio/sushi), which loads CSV data into an in-memory SQLite cache.
- Relationships mirror the Indonesian hierarchy:
  `Province → City → District → Village`

## 👥 Perfect For

- Laravel developers building Indonesia-focused applications
- Address forms, location filters, or dashboards
- Projects that need regional data without managing a database

## ❤️ Acknowledgements

- [Caleb Porzio — Sushi](https://github.com/calebporzio/sushi)
- All contributors to [sensasi-delight/id-administrative-divisions](https://github.com/sensasi-delight/id-administrative-divisions)

> Made with ❤️ by [🍕 sensasi-delight](https://github.com/sensasi-delight)
