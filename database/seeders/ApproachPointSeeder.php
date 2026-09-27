<?php

namespace Database\Seeders;

use App\Models\ApproachPoint;
use Illuminate\Database\Seeder;

class ApproachPointSeeder extends Seeder
{
    public function run(): void
    {
        $points = [
            [
                'order' => 1,
                'title_en' => 'Local insight',
                'title_ar' => 'المعرفة المحلية',
                'description_en' => 'Routes designed by people who know Iraq from within — every road, room and welcome is vetted locally.',
                'description_ar' => 'مسارات يصممها من يعرفون العراق من الداخل — كل طريقٍ وكل غرفةٍ وكل ترحيبٍ يُنتقى بأيدي محلية.',
            ],
            [
                'order' => 2,
                'title_en' => 'Thoughtful pacing',
                'title_ar' => 'إيقاعٌ مدروس',
                'description_en' => 'Days with room to breathe — time enough to stop, to sit, and to let a city speak to you.',
                'description_ar' => 'أيامٌ فيها متسعٌ للتنفس — وقتٌ كافٍ للتوقف والجلوس وترك المدينة تحدّثك.',
            ],
            [
                'order' => 3,
                'title_en' => 'Respect first',
                'title_ar' => 'الاحترام أولاً',
                'description_en' => 'In sacred places and living communities alike, the first rule is courtesy — we move as guests.',
                'description_ar' => 'في الأماكن المقدسة والمجتمعات الحيّة سواءً، القاعدة الأولى هي الأدب — نتحرك كضيوف.',
            ],
        ];

        foreach ($points as $point) {
            ApproachPoint::updateOrCreate(['order' => $point['order']], $point);
        }
    }
}