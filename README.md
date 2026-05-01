# جمعيتي - Jam3iyati

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)
![Vue](https://img.shields.io/badge/Vue-3-green?logo=vue.js)
![Inertia](https://img.shields.io/badge/Inertia.js-purple)
![Tailwind](https://img.shields.io/badge/Tailwind-CSS-blue?logo=tailwindcss)
![License](https://img.shields.io/badge/License-MIT-yellow)

**نظام SaaS متعدد المستأجرين لتسيير الجمعيات بالمغرب**

*Système SaaS multi-tenant pour la gestion des associations marocaines*

</div>

---

## نظرة عامة

**جمعيتي** هو نظام إدارة شامل للجمعيات المغربية، مبني بـ Laravel 11 + Vue 3 + Inertia.js. يدعم تعدد الجمعيات (Multi-tenant) واللغتين العربية (RTL) والفرنسية.

## المميزات

- Multi-tenant - عزل تام لبيانات كل جمعية
- ثنائي اللغة (عربي/فرنسي)
- إدارة الأعضاء (CRUD كامل)
- المعاملات المالية (مداخيل/مصاريف)
- الاشتراكات مع حساب تلقائي
- الاجتماعات وتتبع الحضور
- المشاريع والوثائق
- التقارير القابلة للطباعة
- SuperAdmin + Tenant Admin

## التقنيات

- Backend: Laravel 11 (PHP 8.2+)
- Frontend: Vue 3 + Inertia.js
- Styling: Tailwind CSS
- Database: SQLite
- Build: Vite

## التثبيت

```bash
git clone https://github.com/azzdinehanine/jam3iyati-saas.git
cd jam3iyati-saas
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm run build
php artisan serve
```

راجع [INSTALL.md](INSTALL.md) للدليل الكامل.

## حسابات تجريبية

**SuperAdmin:** admin@jam3iyati.ma / Admin@2026  
**Tenant Admin:** test@jam3iyati.ma / Test@2026

## الترخيص

MIT License

---

صُنع بـ ❤️ للجمعيات المغربية / Made for Moroccan associations
