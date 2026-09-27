# Meso Travels · ميسو ترافلز

موقع للسياحة الثقافية في العراق، بواجهة عامة عربية وإنجليزية، صفحات للرحلات والوجهات، ولوحة لإدارة المحتوى. مبني على Laravel 11 وBlade، مع تصميم مشترك مستمد من ألوان الصفحة الرئيسية.

**[الدليل العربي الكامل: المميزات، الهيكل، قاعدة البيانات، المسارات، الإدارة والتشغيل](docs/PROJECT_GUIDE_AR.md)**

[نسخة HTML عربية للقراءة والطباعة](docs/PROJECT_GUIDE_AR.html)

Bilingual Arabic/English cultural travel website for Iraq, built with Laravel 11, Blade, Tailwind CSS 3, and Alpine.js. Public pages use shared brand styles and a small vanilla JavaScript navigation script. Admin and account pages share the same palette and typography.

## التشغيل المحلي / Local setup

يتطلب PHP 8.2+ وComposer وNode.js/npm وإضافات قاعدة البيانات المناسبة. الأوامر التالية لتثبيت جديد؛ انسخ `.env.example` إلى `.env` فقط إذا لم يكن ملف البيئة موجوداً، ثم اضبط قاعدة البيانات و`APP_URL`.

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

Current scope: content management and travel presentation. There is no payment, reservation, departure calendar, or per-record ownership system. Dashboard accounts are explicitly assigned to English or Arabic; cross-language dashboard access is denied. Public registration is disabled by default. Email verification routes exist but verification is not enforced. Prices are localized display text. Review the full guide before deployment.


## Dashboard access and themes

- English login: `/admin/en/login` — local account `admin-en@mesotravels.test`.
- Arabic login: `/admin/ar/login` — local account `admin-ar@mesotravels.test`.
- Generated local passwords: `storage/app/private/dashboard-accounts.txt` (private; never commit).
- Real accounts: `php artisan dashboard:account EMAIL en` or `ar`; password entry is hidden.
- Each dashboard includes short translated usage hints and its own contact email settings.
- `.test` contacts are local examples, not real inboxes; public mail links stay disabled until replaced.
- Dark/light mode follows the system initially and remembers your selection across pages.
- On another installation, run `php artisan migrate` and provision authorized dashboard accounts. Existing accounts are not automatically elevated.
# hasan
