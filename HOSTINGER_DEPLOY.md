# نشر Meso Travels على Hostinger بدون SSH

## الحزمة التي تُرفع

استخدم ZIP الناتج عن التجهيز، وليس Download ZIP الخاص بكود GitHub؛ كود GitHub وحده لا يحتوي vendor ولا build. الحزمة تشمل ملفات التشغيل المستعادة في bootstrap، كود app كاملًا، قوالب Blade، vendor للإنتاج، CSS/JS المبنية، الأصول الثابتة وكل مجلدات التخزين اللازمة. لا يوجد ملف عام لتشغيل Artisan أو shell أو migrations.

أصل هذا العمل هو مستودع `safaa98-iraq/hasan`. كان Laravel 11.56.1 وقد حُذف bootstrap من main. أُعيدت ملفات التشغيل ورُقي Laravel إلى 12.69.3 وcommonmark إلى 2.10.3 لمعالجة تنبيهات Composer الأمنية. Blade وVite 6 وTailwind 3 وAlpine باقية. لا تتغير بنية قاعدة البيانات الحالية في هذه الترقية.

## تجهيز الحزمة

على Mac، من جذر المشروع:

```bash
bash scripts/prepare-hostinger.sh
```

الأدوات: PHP **8.4.1+**، Composer 2، Node 22+ وnpm، Python 3. يلزم للموقع إضافات Ctype، cURL، DOM، Fileinfo، Filter، GD مع JPEG/PNG/WebP، Hash، Iconv، JSON، Libxml، Mbstring، OpenSSL، PCRE، PDO وpdo_mysql، Session، Tokenizer وXML. يلزم pdo_sqlite على جهاز التجهيز لاختبار الحزمة فقط. يستخدم سكربت SQL خادم MariaDB الموجود في XAMPP على Mac، ببيانات مؤقتة وsocket منفصل وشبكة معطلة. لا يستخدم قاعدة المشروع أو خادم XAMPP الجاري.

بدون أدوات XAMPP يمكن تجهيز حزمة تحديث لقاعدة مستوردة مسبقًا:

```bash
bash scripts/prepare-hostinger.sh --without-sql
```

السكربت يثبت من composer.lock بدون dev ومن package-lock.json باستخدام npm ci، ويبني في مجلد مؤقت، ويفحص الأمان والمنصة وZIP، ثم يفك ZIP في مجلد مؤقت آخر لاختبار HTTP والدخول والرفع. لا يغير ملف .env المحلي أو الملفات المقفلة، ولا ينسخ الصور المرفوعة أو بيانات قاعدة محلية. يتوقف إذا فشل أي فحص. ينشئ مجلدًا جديدًا لكل تشغيل:

```text
dist/hostinger/<وقت-ومعرّف>/
├── meso-hostinger.zip
├── VERIFICATION.json
├── SHA256SUMS
├── HOSTINGER_DEPLOY.md
└── database-first-install.sql   ← فقط عند توليده على Mac
```

`VERIFICATION.json` يصف الفحوص وحدودها. عند استخدام without-sql يظهر DATABASE-NOT-INCLUDED.txt. يختبر السكربت SQL بتوليده من migrations في MariaDB مؤقت ثم استيراده في قاعدة مؤقتة ثانية. الملف يحتوي الجداول وسجل migrations فقط، دون مستخدمين أو محتوى، ولا يشغل seeders.

بديل بلا Terminal حتى على جهازك: بعد وصول التعديلات إلى GitHub افتح Actions → Prepare Hostinger package → Run workflow. ويمكن تنزيل artifact من تشغيل PR الناجح. فك ملف artifact على جهازك أولًا للحصول على `meso-hostinger.zip`؛ لا ترفع غلاف artifact إلى public_html. حزمة Actions تستخدم without-sql ومناسبة لقاعدتك المستوردة بالفعل؛ SQL للتثبيت الأول يُجهز على Mac بالأمر الكامل أعلاه.

## مكان فك الحزمة في Hostinger

في File Manager افتح والد public_html الخاص بالدومين، مثل `domains/YOUR_DOMAIN/`. ارفع meso-hostinger.zip وفكّه **هناك**:

```text
مجلد الدومين/
├── meso-app/
│   ├── .env                         ← الخاص بالاستضافة، خارج الويب
│   ├── .env.hostinger.example
│   ├── app/ bootstrap/ config/ database/ lang/ resources/ routes/
│   ├── vendor/
│   └── storage/
│       ├── app/public/               ← الصور العامة المرفوعة
│       ├── app/private/              ← الملفات الخاصة
│       ├── framework/cache/data/
│       ├── framework/sessions/
│       ├── framework/views/
│       └── logs/
└── public_html/
    ├── index.php                    ← يشير إلى ../meso-app ويضبط public_path
    ├── .htaccess
    └── build/ assets/ css/ js/ favicon.ico robots.txt
```

لا تنشئ public_html/public_html أو meso-app/meso-app. لا توزع app أو vendor في جذر الدومين. احتفظ بـ.htaccess المخفي، وأزل صفحة الاستضافة الافتراضية المتعارضة بعد الاحتفاظ بنسخة منها. لا تنقل meso-app داخل public_html. إذا لم يسمح مدير الملفات بالوصول إلى الخارج، افتح Access all files أو اطلب تهيئة document root من الدعم.

**إذا الموقع وقاعدة البيانات موجودان الآن:** احتفظ بـmeso-app/.env وstorage وبقاعدة البيانات. خذ نسخًا احتياطية؛ فك الحزمة الجديدة في مجلد مؤقت خارج الويب ثم حدّث مجلدات الكود وvendor وملفات public_html. لا تستبدل meso-app كاملًا بطريقة تمسح .env أو storage. احذف ملفات الكاش القديمة فقط من bootstrap/cache، وملفات Blade من storage/framework/views. حافظ على المجلدات. لا تحذف storage/app أو الجلسات. لا تستورد SQL التثبيت الأول على قاعدة قائمة.

تأكد بعد الفك من وجود vendor/composer/autoload_real.php وapp/Http/Controllers/Auth/EmailVerificationPromptController.php وapp/View/Components/AppLayout.php وresources/views/auth/login.blade.php. الحزمة تتحقق من هذه الملفات تلقائيًا؛ وجود ملف autoload.php وحده لا يكفي.

## إعداد .env والصلاحيات

في تثبيت جديد انسخ meso-app/.env.hostinger.example إلى meso-app/.env واملأ placeholders. عند تحديث موقع موجود عدّل إعداداته الحالية ولا تستبدل المفتاح. القالب لا يحتوي أسرارًا حقيقية:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR_DOMAIN
DB_CONNECTION=mysql
DB_HOST=YOUR_DATABASE_HOST
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_DATABASE_USER
DB_PASSWORD="YOUR_DATABASE_PASSWORD"
SESSION_DRIVER=file
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
CACHE_STORE=file
QUEUE_CONNECTION=sync
PUBLIC_MEDIA_FALLBACK=true
```

خذ DB_HOST من hPanel؛ غالبًا localhost لكن القيمة الفعلية أولى. احذف DB_SOCKET الخاص بـMac وأي DB_URL قد يتجاوز القيم أعلاه. استخدم علامات اقتباس وراعِ قواعد dotenv للأحرف الخاصة. اختر PHP 8.4 محدثًا أو 8.5، وفعّل HTTPS قبل تسجيل الدخول. يحتفظ إعداد Hash بدعم كلمات المرور الحالية bcrypt وArgon2.

APP_KEY جديد **للتثبيت الأول فقط بلا بيانات مشفرة**، يولد على جهازك:

```bash
php -r 'echo "base64:".base64_encode(random_bytes(32)).PHP_EOL;'
```

انسخه إلى .env الخاص بالاستضافة واحفظه في مدير أسرار. احتفظ بـAPP_KEY الحالي وAPP_PREVIOUS_KEYS إن كنت تحدث أو ترحل موقعًا قائمًا. لا تضفها إلى GitHub أو الحزمة.

الملفات 644 والمجلدات 755 عادة؛ .env بصلاحية 600 أو 640 بحسب مستخدم PHP. يجب أن يكتب PHP إلى storage بجميع مجلداته وbootstrap/cache؛ استخدم المجموعة الصحيحة أو 775 عند الحاجة فقط، **لا تستخدم 777**. ابدأ memory_limit بـ256M وupload_max_filesize بـ8M وpost_max_size بـ16M وراقب صورك الفعلية. لا يلزم Redis أو عامل طوابير أو عملية مستمرة. البريد لإعادة تعيين كلمات المرور يحتاج SMTP حقيقيًا؛ املأ إعداداته في القالب أو .env الموجود. لا تفترض عمله باستخدام placeholders.

## قاعدة البيانات والحساب

إذا استوردت القاعدة بالفعل، لا تعد الاستيراد. لا يتصل التجهيز بقاعدة Hostinger. لتثبيت أول فقط: أنشئ قاعدة MySQL/MariaDB ومستخدمًا في hPanel، ثم استورد database-first-install.sql عبر phpMyAdmin على قاعدة **فارغة**. لا تستخدمه كتحديث. المحتوى المحلي لا يُنسخ؛ أدخل المحتوى من الإدارة أو انقل نسخة موقعك الحالية ووسائطها في خطوة مستقلة بعد مراجعتها.

الحساب الحالي يبقى صالحًا. لإنشاء أول حساب فقط دون SSH، نفّذ على Mac:

```bash
php scripts/hostinger-admin.php "$HOME/Desktop/meso-admin.sql"
```

الأداة محلية فقط، تطلب كلمة مرور مخفية وتأكيدًا بحد أدنى 12 حرفًا، وتكتب SQL خاصًا بصلاحية 600 يحوي hash bcrypt، دون كلمة المرور الأصلية. استورده مرة واحدة عبر phpMyAdmin ثم احذف الملف الخاص. لا ترفعه إلى public_html. لا توجد كلمة مرور افتراضية أو حساب مُضمّن. النسخة الحالية من المستودع تمنح حسابات الدخول الوصول إلى لوحة الإدارة؛ يبقى التسجيل العام مغلقًا بواسطة REGISTRATION_ENABLED=false.

## الصور والتخزين

لا تحتاج storage:link أو symlinks. PUBLIC_MEDIA_FALLBACK=true يجعل /storage/... يعرض فقط ملفات الصور من meso-app/storage/app/public بعد تحقق المسار الحقيقي والامتداد وMIME. لا يُعرض private ولا تُنفذ PHP أو SVG. لا تنشئ public_html/storage؛ إذا كان موجودًا، احتفظ بصوره المطلوبة في المجلد العام الخاص ثم أزل الرابط/المجلد العام حتى تمر الطلبات عبر Laravel. الصور العامة القديمة تنقل منفصلة مع الحفاظ على المسارات، بعد مراجعة الحاجة إليها. الحزمة لا تنقلها تلقائيًا.

## التحقق على الدومين

1. افتح / و/ar و/login. الرئيسية تقرأ قاعدة البيانات؛ نجاح /up وحده لا يثبت DB أو الواجهة.
2. سجل الدخول فعليًا وافتح /admin، ثم ارفع صورة من إدارة الأماكن وتحقق من ظهورها في صفحة المكان وعبر /storage/... ومن بقاء الجلسة والخروج.
3. تأكد من تحميل CSS/JS من /build/assets ومن عدم وجود hot أو روابط localhost.
4. تأكد أن /.env و/vendor/autoload.php وملفات private غير متاحة. لا تفعّل APP_DEBUG للعامة.
5. عند 500 اقرأ آخر production.ERROR من meso-app/storage/logs. قبل بدء Laravel، سجل PHP في مجلد .logs عبر Access all files؛ فعّل logErrors وE_ALL مع displayErrors=Off.

التحقق المحلي يفحص الحزمة بعد فكها وبيئة production بقاعدة SQLite مؤقتة ومفتاح وحساب عشوائيين، بما يشمل الدخول والرفع ورفض الملفات الخاصة. لا يثبت rewrite في Apache/LiteSpeed أو صلاحيات حسابك أو بيانات DB أو SMTP أو HTTPS على Hostinger. يجب تنفيذ فحوص الدومين بعد الرفع.

## التحديث لاحقًا

خذ نسخة DB و.env وstorage، ثم ابنِ ZIP جديدًا من ملفات القفل. حدّث الكود وvendor وbuild مع إبقاء الإعدادات والمفتاح والوسائط. احذف manifests القديمة في bootstrap/cache بعد استبدال vendor، خصوصًا إذا كانت تشير إلى Laravel Pail أو أدوات التطوير. أبقِ build القديم أثناء انتقال الطلبات ثم نظفه لاحقًا. عند إضافة migrations مستقبلًا جهّز SQL ترقية للفارق واختبره على قاعدة مؤقتة من بنية الإصدار السابق؛ ملف first-install لا يصلح لذلك.

مراجع: [ترقية Laravel 12](https://laravel.com/docs/12.x/upgrade)، [متطلبات النشر](https://laravel.com/docs/12.x/deployment)، [سجل PHP في Hostinger](https://www.hostinger.com/support/1583298-where-to-find-your-website-s-error-logs-in-hostinger/).
