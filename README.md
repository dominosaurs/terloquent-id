# 🇮🇩 Terloquent ID

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/terloquent/id)](https://packagist.org/packages/terloquent/id)

**Eloquent models for Indonesian administrative regions — no database required.**

Powered by [Sushi](https://github.com/calebporzio/sushi), **Terloquent ID** lets you query provinces, cities, districts, and villages instantly, right from your Laravel app.

## ✨ Features

- 🇮🇩 Built-in Indonesian administrative data: **Province**, **City**, **District**, **Village**
- ⚡ Works like normal Eloquent models (`where`, `first`, `whereLike`, etc.)
- 🧠 No migrations, no seeding — just install and query
- 🗃️ Auto-cached via Sushi for fast performance
- 📦 Data sourced from [laravolt/indonesia](https://github.com/laravolt/indonesia)

## 🚀 Installation

```bash
composer require terloquent/id
```

> Requires the [`pdo_sqlite` PHP extension](https://www.php.net/manual/en/ref.pdo-sqlite.php).

Use it immediately:

```php
use TerloquentID\City;

$city = City::whereLike('name', '%Samarinda%')->firstOrFail();
```

That’s it — no setup, migrations, or database needed.

## 🧩 Data & Updates

- Uses CSV data from [Laravolt Indonesia](https://github.com/laravolt/indonesia).
- Data updates are handled through **pull requests** — users can’t modify it at runtime.

## ⚙️ Under the Hood

- Backed by [Sushi](https://github.com/calebporzio/sushi): data is loaded from CSV into an in-memory SQLite cache.
- Relationships follow Indonesia’s hierarchy:
  `Province → City → District → Village`

## 👥 Perfect For

- Laravel developers building apps for the Indonesian market
- Address pickers, region filters, or dashboards
- Projects that need region data but want to skip database setup

## 🚧 Limitations

- Only administrative regions are included (no postal codes, coordinates, etc.)
- Runtime edits are not supported
- No roadmap yet — but contributions are welcome!

## ❤️ Acknowledgements

- [Caleb Porzio — Sushi](https://github.com/calebporzio/sushi)
- [Laravolt — Indonesia data](https://github.com/laravolt/indonesia)

> Made with ❤️ by [🍕](https://github.com/sensasi-delight).
