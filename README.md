# Meso Travels · ميسو ترافلز

موقع للسياحة الثقافية في العراق، بواجهة عامة عربية وإنجليزية، صفحات للرحلات والوجهات، ولوحة لإدارة المحتوى. مبني على Laravel 12 وBlade، مع تصميم مشترك مستمد من ألوان الصفحة الرئيسية.

**[الدليل العربي الكامل: المميزات، الهيكل، قاعدة البيانات، المسارات، الإدارة والتشغيل](docs/PROJECT_GUIDE_AR.md)**

[نسخة HTML عربية للقراءة والطباعة](docs/PROJECT_GUIDE_AR.html)

Bilingual Arabic/English cultural travel website for Iraq, built with Laravel 12, Blade, Tailwind CSS 3, and Alpine.js. Public pages use shared brand styles and a small vanilla JavaScript navigation script. Admin and account pages share the same palette and typography.

## التشغيل المحلي / Local setup

يتطلب PHP 8.4.1+ وComposer وNode.js/npm وإضافات قاعدة البيانات المناسبة. الأوامر التالية لتثبيت جديد؛ انسخ `.env.example` إلى `.env` فقط إذا لم يكن ملف البيئة موجوداً، ثم اضبط قاعدة البيانات و`APP_URL`.

```bash
composer install
npm ci
npm run build
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

لإنشاء SQLite جديد، أنشئ `database/database.sqlite` واضبط `DB_CONNECTION=sqlite` ومسار `DB_DATABASE`. تفاصيل XAMPP والبريد موجودة في [الدليل](docs/PROJECT_GUIDE_AR.md). يجب أن يكون جذر الويب مجلد `public`.

للمحتوى التجريبي في تثبيت جديد فقط:

```bash
php artisan db:seed
```

إعادة البذر قد تستبدل المحتوى التجريبي المعدل ؛ بذر الحسابات التجريبية محصور في local/testing ويحافظ على كلمات المرور الموجودة. لا تستخدمه كخطوة نشر دورية. بيانات الحساب التجريبي موثقة في الدليل.

## الروابط / Entry points

| المسار | الاستخدام |
| --- | --- |
| `/`، `/ar` | الرئيسية بالإنجليزية والعربية |
| `/journeys/{slug}`، `/journeys/{slug}/ar` | تفاصيل الرحلات المنشورة |
| `/places/{slug}`، `/places/{slug}/ar` | تفاصيل الوجهات المنشورة |
| `/admin` | إدارة المحتوى بعد تسجيل الدخول |
| `/profile` | معلومات الحساب وكلمة المرور وحذف الحساب |

`CONTACT_EMAIL` اختياري لروابط الاستفسار عبر البريد؛ إعداد إرسال رسائل استعادة كلمة المرور مستقل عبر `MAIL_*`. عند عدم ضبط بريد التواصل، يعرض الموقع رسالة توفّر تفاصيل الحجز لاحقاً.

## التحقق / Checks

```bash
php artisan test
npm run build
php artisan route:list --except-vendor
```

الاختبارات معدّة لاستخدام SQLite في الذاكرة من `phpunit.xml`.

Current scope: content management and travel presentation. There is no payment, reservation, departure calendar, or per-record ownership system. All authenticated accounts use one dashboard to edit English and Arabic content together. Public registration is disabled by default. Email verification routes exist but verification is not enforced. Prices are localized display text. Review the full guide before deployment.


## Dashboard access and themes

- Shared login: `/login`; shared dashboard: `/admin`.
- English and Arabic content fields and contact email settings appear together.
- Existing accounts and passwords still work; language-specific bookmarks redirect to shared routes.
- Generated local passwords remain in `storage/app/private/dashboard-accounts.txt` (private; never commit).
- Create/update an account: `php artisan dashboard:account EMAIL`; password entry is hidden.
- Short usage hints and the dark/light toggle remain available.
- `.test` contacts are examples, not real inboxes; public mail links stay disabled until replaced.
- Every authenticated account can manage content. Public registration is disabled by default.

## Hostinger بدون SSH

[دليل النشر والحزمة المختبرة](HOSTINGER_DEPLOY.md). استخدم `bash scripts/prepare-hostinger.sh` على Mac أو workflow **Prepare Hostinger package** في GitHub Actions للحصول على ZIP يشمل vendor والواجهة المبنية. كود GitHub ZIP وحده لا يكفي للتشغيل.
