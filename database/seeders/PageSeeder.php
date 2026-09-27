<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'key' => 'meta_title',
                'title_en' => 'Meso Travels — Mesopotamia Revealed',
                'title_ar' => 'ميسو ترافلز — بلاد الرافدين كما لم ترها',
            ],
            [
                'key' => 'meta_description',
                'title_en' => "Meso Travels creates thoughtful journeys through Iraq's ancient cities, living faith and everyday culture.",
                'title_ar' => 'تقدّم ميسو ترافلز رحلات مدروسة عبر مدن العراق القديمة وتراثه الديني وثقافته الحية.',
            ],
            [
                'key' => 'hero_eyebrow',
                'title_en' => 'Mesopotamia Revealed · Iraq',
                'title_ar' => 'بلاد الرافدين كما لم ترها · العراق',
            ],
            [
                'key' => 'hero_heading',
                'title_en' => 'Come closer. Iraq has stories to tell.',
                'title_ar' => 'اقترب أكثر. لدى العراق حكايات يرويها.',
            ],
            [
                'key' => 'hero_sub',
                'title_en' => 'Thoughtful journeys through ancient cities, living faith and the warmth of everyday Iraq—planned by people who know the country from within.',
                'title_ar' => 'رحلات مدروسة عبر المدن القديمة والإيمان الحي ودفء الحياة العراقية اليومية، يخطط لها أشخاص يعرفون البلد من الداخل.',
            ],
            [
                'key' => 'hero_cta',
                'title_en' => 'Explore the first journey',
                'title_ar' => 'اكتشف رحلتنا الأولى',
            ],
            [
                'key' => 'intro_eyebrow',
                'title_en' => 'Why Iraq',
                'title_ar' => 'لماذا العراق؟',
            ],
            [
                'key' => 'intro_heading',
                'title_en' => 'This is the land between two rivers—and one of the richest human stories on earth.',
                'title_ar' => 'هذه أرض ما بين النهرين، وموطن إحدى أغنى حكايات الإنسان على وجه الأرض.',
            ],
            [
                'key' => 'intro_body',
                'title_en' => 'Meso Travels Approach',
                'title_ar' => 'رؤية ميسو ترافلز',
                'body_en' => "Meso Travels is for curious travellers who want more than a list of sites. We bring history, faith and contemporary life into the same journey, with time to understand the places and people along the way.\n\nOur aim is simple: thoughtful pacing, meaningful context and a welcome that feels personal.",
                'body_ar' => "ميسو ترافلز موجّه للمسافرين الفضوليين الذين يبحثون عن أكثر من قائمة مواقع. نجمع التاريخ والإيمان والحياة المعاصرة في رحلة واحدة، مع وقت كافٍ لفهم الأماكن والتعرّف إلى الناس على امتداد الطريق.\n\nغايتنا بسيطة: إيقاع مريح، وسياق غني بالمعنى، وترحيب يلامس الضيف شخصياً.",
            ],
            [
                'key' => 'journey_eyebrow',
                'title_en' => 'The first journey',
                'title_ar' => 'الرحلة الأولى',
            ],
            [
                'key' => 'places_eyebrow',
                'title_en' => 'Along the way',
                'title_ar' => 'على امتداد الطريق',
            ],
            [
                'key' => 'places_heading',
                'title_en' => 'Five places. Many Iraqs.',
                'title_ar' => 'خمس وجهات. وعراق متعدد الوجوه.',
            ],
            [
                'key' => 'categories_eyebrow',
                'title_en' => 'Ways to see Iraq',
                'title_ar' => 'طرق لاكتشاف العراق',
            ],
            [
                'key' => 'categories_heading',
                'title_en' => 'Follow what moves you.',
                'title_ar' => 'اتبع ما يلهمك.',
            ],
            [
                'key' => 'approach_eyebrow',
                'title_en' => 'The Meso Travels approach',
                'title_ar' => 'نهج ميسو ترافلز',
            ],
            [
                'key' => 'approach_heading',
                'title_en' => 'Travel with context. Leave with connection.',
                'title_ar' => 'سافر بفهم أعمق. وعُد بصلة أبقى.',
            ],
            [
                'key' => 'cta_eyebrow',
                'title_en' => 'Meso Travels',
                'title_ar' => 'ميسو ترافلز',
            ],
            [
                'key' => 'cta_heading',
                'title_en' => 'Iraq is not one story. Come hear more of it.',
                'title_ar' => 'العراق ليس حكاية واحدة. تعال لتسمع المزيد.',
            ],
            [
                'key' => 'cta_body',
                'title_en' => 'Departure dates and booking details are coming soon.',
                'title_ar' => 'مواعيد الرحلات وتفاصيل الحجز ستتوفر قريباً.',
            ],
            [
                'key' => 'cta_button',
                'title_en' => 'Start with our first route',
                'title_ar' => 'ابدأ بمسار رحلتنا الأولى',
            ],
            [
                'key' => 'footer_tagline',
                'title_en' => 'Mesopotamia Revealed',
                'title_ar' => 'بلاد الرافدين كما لم ترها',
            ],
            [
                'key' => 'footer_copyright',
                'title_en' => '© Meso Travels',
                'title_ar' => '© ميسو ترافلز',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['key' => $page['key']], $page);
        }
    }
}