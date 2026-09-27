<?php

namespace Database\Seeders;

use App\Models\Journey;
use App\Models\JourneyStop;
use App\Models\Place;
use Illuminate\Database\Seeder;

class JourneySeeder extends Seeder
{
    public function run(): void
    {
        $places = Place::pluck('id', 'slug');

        // Journey 1
        $journey1 = Journey::updateOrCreate(
            ['slug' => 'between-rivers-and-revelation'],
            [
                'order' => 1,
                'title_en' => 'Between Rivers & Revelation',
                'title_ar' => 'بين النهرين والوحي',
                'subtitle_en' => 'A round trip from Baghdad through the ancient, sacred and living landscapes of central Iraq.',
                'subtitle_ar' => 'رحلةٌ دائرية من بغداد عبر مشاهد العراق القديمة والمقدسة والحيّة في وسطه.',
                'description_en' => 'Six stops from the Abbasid heart of Baghdad, out to the walls of Babylon and the Euphrates shrine of al-Kifl, then on to the devotion of Karbala and the scholarship of Najaf — before the road turns home.',
                'description_ar' => 'ست محطات، من قلب بغداد العباسي إلى أسوار بابل وضريح الكفل على الفرات، ثم إلى محبّة كربلاء وعلم النجف — قبل أن يعود الطريق إلى الوطن.',
                'price_en' => '$1,850 / person',
                'price_ar' => '1,850$ للشخص',
                'duration_en' => '8 Days / 7 Nights',
                'duration_ar' => '8 أيام / 7 ليال',
                'image_path' => 'images/hero/hero.svg',
                'gallery' => [
                    'images/hero/hero.svg',
                    'images/places/baghdad.svg',
                    'images/places/babylon.svg',
                    'images/places/al-kifl.svg',
                    'images/places/karbala.svg',
                    'images/places/najaf.svg',
                ],
                'included_en' => "Boutique and heritage hotel accommodations (7 nights)\nPrivate air-conditioned vehicle with dedicated professional driver\nLicensed English-speaking Iraqi cultural historian & guide\nAll entry permits, museum fees and heritage site tickets\nDaily traditional breakfast and three curated authentic dinners\nAirport reception, assistance and roundtrip private transfers\nBottled mineral water, tea stops and regional refreshments throughout",
                'included_ar' => "إقامة في فنادق تراثية وممتازة (7 ليال)\nسيارة حديثة ومكيفة مع سائق خاص طوال الرحلة\nمرشد وباحث سياحي وتراثي عراقي متخصص\nكافة رسوم وتصاريح الدخول للمواقع الأثرية والمتاحف\nإفطار يومي وثلاث وجبات عشاء تراثية خاصة\nالاستقبال والتوديع في المطار بسيارة خاصة\nضيافة المشروبات والشاي العراقي التقليدي أثناء التنقل",
                'excluded_en' => "International roundtrip airfare\nEntry visa fee ($75, easily issued on arrival for eligible passports)\nTravel and health insurance\nPersonal expenses, gifts and additional meals",
                'excluded_ar' => "تذاكر الطيران الدولي\nرسوم تأشيرة الدخول (تُمنح مباشرة في المطار)\nالتأمين الصحي وتأمين السفر\nالمصاريف الشخصية والمقتنيات الخاصة",
                'is_published' => true,
            ]
        );

        $stops1 = [
            [
                'order' => 1,
                'name_en' => 'Baghdad',
                'name_ar' => 'بغداد',
                'label_en' => 'Arrive & Abbasid Heart',
                'label_ar' => 'الوصول وقلب بغداد العباسي',
                'place' => 'baghdad',
                'description_en' => 'Arrival and warm welcome in Baghdad. Evening walk through al-Mutanabbi book street, copper souqs, and tea at historic Shabandar Café overlooking the Tigris.',
                'description_ar' => 'الوصول والاستقبال في بغداد. جولة مسائية في شارع المتنبي وسوق الصفافير واستراحة شاي في مقهى الشابندر العريق المطل على دجلة.',
                'image_path' => 'images/places/baghdad.svg',
            ],
            [
                'order' => 2,
                'name_en' => 'Babylon',
                'name_ar' => 'بابل',
                'label_en' => 'Ancient Empire',
                'label_ar' => 'الإمبراطورية القديمة',
                'place' => 'babylon',
                'description_en' => 'Travel south to Babylon. Stand before the towering Processional Way and the blue-glazed Ishtar Gate. Explore Nebuchadnezzar’s royal palace and the legendary foundations of world architecture.',
                'description_ar' => 'الانطلاق جنوباً إلى بابل. الوقوف أمام شارع الموكب وبوابة عشتار المزججة، واستكشاف القصر الشمالي والجنوبي لنبوخذنصر وبدايات الحضارة الإنسانية.',
                'image_path' => 'images/places/babylon.svg',
            ],
            [
                'order' => 3,
                'name_en' => 'al-Kifl',
                'name_ar' => 'الكفل',
                'label_en' => 'Sacred Shared Memory',
                'label_ar' => 'ذاكرة مقدسة مشتركة',
                'place' => 'al-kifl',
                'description_en' => 'Visit the riverside town of al-Kifl, where the shrine of Prophet Ezekiel (Dhul-Kifl) stands as a centuries-old bridge of shared Islamic, Jewish, and biblical heritage along the Euphrates.',
                'description_ar' => 'زيارة بلدة الكفل على ضفاف الفرات، حيث مرقد النبي حزقيال (ذو الكفل) الذي يمثل جسراً روحياً مشتركاً يربط التراث الإسلامي واليهودي والتوراتي عبر القرون.',
                'image_path' => 'images/places/al-kifl.svg',
            ],
            [
                'order' => 4,
                'name_en' => 'Karbala',
                'name_ar' => 'كربلاء',
                'label_en' => 'Living Devotion & Generosity',
                'label_ar' => 'مدينة العطاء والمحبة',
                'place' => 'karbala',
                'description_en' => 'Experience the profound spirituality and legendary hospitality of Karbala. Walk between the two golden domes and witness how centuries of devotion form a living daily culture.',
                'description_ar' => 'التعرف على الروحانية العميقة وكرم الضيافة الفريد في كربلاء، والتجول في الساحات المحيطة بالمرقدين ومشاهدة ثقافة الكرم العراقية الأصيلة.',
                'image_path' => 'images/places/karbala.svg',
            ],
            [
                'order' => 5,
                'name_en' => 'Najaf',
                'name_ar' => 'النجف',
                'label_en' => 'Shrine & Scholarship',
                'label_ar' => 'مرقد العلم والفكر',
                'place' => 'najaf',
                'description_en' => 'Discover Najaf, home of the thousand-year-old Hawza, great manuscript libraries, and the serene vista of Wadi us-Salam beside the shrine of Imam Ali.',
                'description_ar' => 'اكتشاف النجف الأشرف، مهد الحوزة العلمية العريقة ومكتبات المخطوطات النادرة، والإطلالة على وادي السلام بجوار مرقد الإمام علي عليه السلام.',
                'image_path' => 'images/places/najaf.svg',
            ],
            [
                'order' => 6,
                'name_en' => 'Baghdad',
                'name_ar' => 'بغداد',
                'label_en' => 'National Museum & Departure',
                'label_ar' => 'المتحف الوطني والمغادرة',
                'place' => 'baghdad',
                'description_en' => 'Return to Baghdad for a private tour of the National Museum of Iraq, the Abbasid Palace, and a celebration dinner before departure transfers.',
                'description_ar' => 'العودة إلى بغداد لزيارة المتحف العراقي الوطني والقصر العباسي، تليها مأدبة عشاء ختامية والتوديع في مطار بغداد الدولي.',
                'image_path' => 'images/places/baghdad.svg',
            ],
        ];

        foreach ($stops1 as $stop) {
            JourneyStop::updateOrCreate(
                ['journey_id' => $journey1->id, 'order' => $stop['order']],
                [
                    'name_en' => $stop['name_en'],
                    'name_ar' => $stop['name_ar'],
                    'label_en' => $stop['label_en'],
                    'label_ar' => $stop['label_ar'],
                    'description_en' => $stop['description_en'],
                    'description_ar' => $stop['description_ar'],
                    'image_path' => $stop['image_path'],
                    'place_id' => $places[$stop['place']] ?? null,
                ]
            );
        }

        // Journey 2
        $journey2 = Journey::updateOrCreate(
            ['slug' => 'southern-marshes-and-sumer'],
            [
                'order' => 2,
                'title_en' => 'Southern Marshes & Ancient Sumer',
                'title_ar' => 'أهوار الجنوب وحضارة سومر',
                'subtitle_en' => 'An immersive expedition into the Mesopotamian marshlands and the primeval Sumerian cities of Ur and Uruk.',
                'subtitle_ar' => 'رحلة استكشافية عميقة في قلب أهوار بلاد الرافدين وحواضر سومر العريقة أور والوركاء.',
                'description_en' => 'Journey deep into the legendary lands of southern Iraq. Glide on traditional mashhoof canoes through UNESCO World Heritage Mesopotamian Marshes, sleep in traditional reed mudhifs, stand beneath the Great Ziggurat of Ur where Abraham was born, and discover the origins of cuneiform writing in Uruk.',
                'description_ar' => 'انطلق في رحلة عميقة إلى أراضي جنوب العراق الأسطورية. أبحر بقوارب المشحوف التراثية في أهوار العراق المسجلة على لائحة التراث العالمي، وتعرف على سكان الأهوار وعمارتهم الفريدة بالقصب، ثم قف أسفل زقورة أور العظيمة مسقط رأس النبي إبراهيم الخليل عليه السلام، واكتشف أولى مدن التاريخ والكتابة المسمارية في الوركاء.',
                'price_en' => '$2,100 / person',
                'price_ar' => '2,100$ للشخص',
                'duration_en' => '6 Days / 5 Nights',
                'duration_ar' => '6 أيام / 5 ليال',
                'image_path' => 'images/places/babylon.svg',
                'gallery' => [
                    'images/places/babylon.svg',
                    'images/places/baghdad.svg',
                    'images/hero/hero.svg',
                ],
                'included_en' => "Traditional eco-lodge & local reed mudhif experiences\nPrivate motorized boat excursions deep into the Marshes\nFull board dining featuring authentic southern Iraqi water-buffalo dairy & Masgouf fish\nLocal expert naturalist and Sumerologist guides\nPrivate transportation throughout Nasiriyah, Chibayish, and Basra",
                'included_ar' => "إقامة في نزل بيئية ومضايف قصب تقليدية أصيلة\nجولات بالقوارب التقليدية في أعماق الأهوار الوسطى والجبايش\nوجبات طعام كاملة تشمل السمك المسكوف وقيمر عرب طازج\nمرشد سياحي بيئي وآثاري متخصص في الحضارة السومرية\nتنقلات خاصة في الناصرية، الجبايش، والبصرة",
                'excluded_en' => "International airfare\nVisa upon arrival fees\nGratuities and personal tips",
                'excluded_ar' => "تذاكر الطيران الدولي\nرسوم التأشيرة في المطار\nالإكراميات والمشتريات الشخصية",
                'is_published' => true,
            ]
        );

        $stops2 = [
            [
                'order' => 1,
                'name_en' => 'Ur & Nasiriyah',
                'name_ar' => 'أور والناصرية',
                'label_en' => 'Birthplace of Abraham',
                'label_ar' => 'مسقط رأس النبي إبراهيم',
                'place' => null,
                'description_en' => 'Stand in awe before the majestic 4,000-year-old Ziggurat of Ur and walk through the royal Sumerian tombs where the Standard of Ur was unearthed.',
                'description_ar' => 'الوقوف بإجلال أمام زقورة أور السومرية العظيمة الشامخة منذ أكثر من 4000 عام وزيارة المقابر الملكية ومسقط رأس النبي إبراهيم.',
                'image_path' => 'images/places/babylon.svg',
            ],
            [
                'order' => 2,
                'name_en' => 'Chibayish Marshes',
                'name_ar' => 'أهوار الجبايش',
                'label_en' => 'UNESCO Natural Heritage',
                'label_ar' => 'تراث طبيعي عالمي',
                'place' => null,
                'description_en' => 'Drift across labyrinthine waterways bordered by tall papyrus reeds in traditional mashhoofs, encountering marsh buffalo herds and ancestral water settlements.',
                'description_ar' => 'الإبحار بقوارب المشحوف في متاهات القصب والبردي وسط المياه الصافية، والتعرف على كرم معدان الأهوار وحياتهم التراثية المتوارثة منذ آلاف السنين.',
                'image_path' => 'images/hero/hero.svg',
            ],
            [
                'order' => 3,
                'name_en' => 'Basra & Shatt al-Arab',
                'name_ar' => 'البصرة وشط العرب',
                'label_en' => 'The Venice of the East',
                'label_ar' => 'فينيسيا الشرق وتراث الشناشيل',
                'place' => null,
                'description_en' => 'Conclude your journey at the confluence of the Tigris and Euphrates. Stroll past historic wooden Shanashil balconies and savour Basrawi culinary specialties.',
                'description_ar' => 'اختتام الرحلة عند ملتقى دجلة والفرات في شط العرب، وزيارة بيوت الشناشيل الخشبية العريقة وأسواق التمور والبخور في البصرة القديمة.',
                'image_path' => 'images/places/baghdad.svg',
            ],
        ];

        foreach ($stops2 as $stop) {
            JourneyStop::updateOrCreate(
                ['journey_id' => $journey2->id, 'order' => $stop['order']],
                [
                    'name_en' => $stop['name_en'],
                    'name_ar' => $stop['name_ar'],
                    'label_en' => $stop['label_en'],
                    'label_ar' => $stop['label_ar'],
                    'description_en' => $stop['description_en'],
                    'description_ar' => $stop['description_ar'],
                    'image_path' => $stop['image_path'],
                    'place_id' => $places[$stop['place']] ?? null,
                ]
            );
        }
    }
}