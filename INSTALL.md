# دليل التثبيت / Installation Guide

## المتطلبات / Prerequisites

- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x
- npm >= 9.x
- SQLite (أو MySQL/PostgreSQL)
- Git

## خطوات التثبيت

### 1. استنساخ المشروع

```bash
git clone https://github.com/azzdinehanine/jam3iyati-saas.git
cd jam3iyati-saas
```

### 2. تثبيت الحزم / Install dependencies

```bash
composer install
npm install
```

### 3. إعداد ملف البيئة / Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. إعداد قاعدة البيانات / Database setup

**SQLite (الافتراضي / Default):**

```bash
touch database/database.sqlite
php artisan migrate --seed
```

**MySQL (بديل / Alternative):**

عدّل `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jam3iyati
DB_USERNAME=root
DB_PASSWORD=
```

ثم:

```bash
php artisan migrate --seed
```

### 5. بناء الواجهة / Build frontend

**للإنتاج / Production:**

```bash
npm run build
```

**للتطوير / Development:**

```bash
npm run dev
```

### 6. تشغيل الخادم / Run server

```bash
php artisan serve
```

ثم افتح المتصفح على: http://localhost:8000

## الحسابات الافتراضية

بعد تنفيذ `php artisan db:seed`:

| الدور | البريد | كلمة المرور |
|------|--------|----------------|
| SuperAdmin | admin@jam3iyati.ma | Admin@2026 |
| Tenant Admin | test@jam3iyati.ma | Test@2026 |

## حل المشاكل الشائعة

### `Permission denied` على storage

```bash
chmod -R 775 storage bootstrap/cache
```

### خطأ `vite manifest not found`

```bash
npm run build
```

### إعادة تعيين البيانات

```bash
php artisan migrate:fresh --seed
```

### تنظيف الذاكرة المؤقتة

```bash
php artisan optimize:clear
```

## النشر على خادم إنتاج / Production deployment

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

تأكد من ضبط `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

## الدعم

لأي مشكلة، افتح Issue على GitHub:
https://github.com/azzdinehanine/jam3iyati-saas/issues
