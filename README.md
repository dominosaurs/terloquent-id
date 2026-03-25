# 🇮🇩 Terloquent ID

[![Tests](https://github.com/dominosaurs/terloquent-id/actions/workflows/ci.yml/badge.svg)](https://github.com/dominosaurs/terloquent-id/actions/workflows/ci.yml)
[![Latest Stable Version](https://img.shields.io/packagist/v/terloquent/id.svg?style=flat-square)](https://packagist.org/packages/terloquent/id)
[![PHP Version Require](https://img.shields.io/packagist/php-v/terloquent/id.svg?style=flat-square)](https://packagist.org/packages/terloquent/id)
[![License](https://img.shields.io/packagist/l/terloquent/id.svg?style=flat-square)](https://packagist.org/packages/terloquent/id)

**Eloquent models for Indonesian administrative regions — no database required.**

Powered by [Sushi](https://github.com/calebporzio/sushi), **Terloquent ID** lets you query provinces, regencies/cities, districts, and villages instantly — without any migrations or seeders.

## ✨ Features

- 🇮🇩 Ready-to-use Indonesian administrative data: **Province**, **Regency**, **District**, **Village**
- ⚡ Works like standard Eloquent models (`where`, `first`, `whereLike`, etc.)
- 🧠 No migrations or seeding required
- 🗃️ Auto-cached via Sushi for fast performance
- 📦 Uses external CSV data from [dominosaurs/id-administrative-divisions](https://github.com/dominosaurs/id-administrative-divisions)

## 🚀 Installation

```bash
composer require terloquent/id
```

> Requires the [`pdo_sqlite` PHP extension](https://www.php.net/manual/en/ref.pdo-sqlite.php).

Start using it right away:

```php
use TerloquentID\Regency;

$regency = Regency::whereLike('name', '%Samarinda%')->firstOrFail();
```

No setup. No migrations. No database.

## 🧩 Data Source

The administrative data is sourced from the open dataset repository:
👉 [**dominosaurs/id-administrative-divisions**](https://github.com/dominosaurs/id-administrative-divisions)

This repository provides CSV files representing Indonesia’s full administrative hierarchy:

```text
Province → Regency → District → Village
```

It may also include additional metadata such as:

- Official region codes (Kemendagri / BPS)
- Coordinates (latitude, longitude)
- Postal codes
- Other optional attributes

> Users cannot modify the data at runtime.
> To suggest updates or corrections, please open a pull request to [dominosaurs/id-administrative-divisions](https://github.com/dominosaurs/id-administrative-divisions).

## ⚙️ Under the Hood

- Built on [Sushi](https://github.com/calebporzio/sushi), which loads CSV data into an in-memory SQLite cache.
- Relationships mirror the Indonesian hierarchy:
  `Province → Regency → District → Village`

## 🛠️ Artisan Commands

TerloquentID provides a few handy Artisan commands to help you manage local administrative data:

| Command                            | Description                                                                                  |
| ---------------------------------- | -------------------------------------------------------------------------------------------- |
| `php artisan terloquent-id:status` | 📊 Show the current status of the administrative data (path, last update, commit info, etc.) |
| `php artisan terloquent-id:clear`  | 🧹 Clear all locally stored data and cache.                                                  |

## 👥 Perfect For

- Laravel developers building Indonesia-focused applications
- Address forms, location filters, or dashboards
- Projects that need regional data without managing a database

## ❤️ Acknowledgements

- [Caleb Porzio — Sushi](https://github.com/calebporzio/sushi)
- All contributors to [dominosaurs/id-administrative-divisions](https://github.com/dominosaurs/id-administrative-divisions)

> Made with ❤️ by [🍕 dominosaurs](https://github.com/dominosaurs)
