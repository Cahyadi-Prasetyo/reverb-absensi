# Laravel Application

Laravel 12 application setup tanpa Docker.

## Requirements

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM

## Installation

1. Clone repository ini
2. Install dependencies:
```bash
composer install
npm install
```

3. Copy file environment:
```bash
copy .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Jalankan migrasi database:
```bash
php artisan migrate
```

6. Link storage:
```bash
php artisan storage:link
```

## Development

Jalankan development server:

```bash
php artisan serve
```

Untuk Vite development server (di terminal terpisah):

```bash
npm run dev
```

Aplikasi akan berjalan di `http://localhost:8000`

## Build untuk Production

```bash
npm run build
```

## License

MIT License
