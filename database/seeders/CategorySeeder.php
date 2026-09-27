<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'ancient-iraq',
                'order' => 1,
                'roman_numeral' => 'I',
                'title_en' => 'Ancient Iraq',
                'title_ar' => 'العراق القديم',
                'description_en' => 'Six thousand years of writing, law and cities — from the first clay tablets to the walls of Babylon.',
                'description_ar' => 'ستة آلاف عام من الكتابة والقانون والمدن — من أول الألواح الطينية إلى أسوار بابل.',
            ],
            [
                'slug' => 'sacred-iraq',
                'order' => 2,
                'roman_numeral' => 'II',
                'title_en' => 'Sacred Iraq',
                'title_ar' => 'العراق المقدس',
                'description_en' => "Shrines that thrum with faith — Karbala's devotion, Najaf's scholarship and the pilgrimage roads between them.",
                'description_ar' => 'مراقد تنبض بالإيمان — محبّة كربلاء، علمُ النجف، وطرق الزيارة الواصلة بينهما.',
            ],
            [
                'slug' => 'christian-biblical-heritage',
                'order' => 3,
                'roman_numeral' => 'III',
                'title_en' => 'Christian & biblical heritage',
                'title_ar' => 'الإرث المسيحي والكتابي',
                'description_en' => 'From the rivers of Eden to the people of Nineveh — including al-Kifl, where Jewish, Islamic and biblical memory meet.',
                'description_ar' => 'من أنهار عدن إلى أهل نينوى — ومنها الكفل، حيث تلتقي الذاكرة اليهودية والإسلامية والتوراتية.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}