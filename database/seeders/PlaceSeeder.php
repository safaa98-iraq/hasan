<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $places = [
            [
                'slug' => 'baghdad',
                'order' => 1,
                'name_en' => 'Baghdad',
                'name_ar' => 'بغداد',
                'excerpt_en' => "River life, Abbasid layers and the two golden ages that made this city a legend.",
                'excerpt_ar' => 'حياةُ النهر، طبقاتُ العصر العباسي، والعصران الذهبيان اللذان جعلا من هذه المدينة أسطورة.',
                'body_en' => "Baghdad begins with the Tigris. The river threads through the city the way life has always threaded through it — under the Maiden's Bridge, past the date-palm gardens, through centuries of trade and poetry.\n\nBeneath today's streets, the Abbasid capital remembers its two golden ages: the House of Wisdom that translated the world, and the round city that once led the sciences. To walk Iraq's capital is to walk the layers of an idea that changed everything.",
                'body_ar' => "تبدأ بغداد بدجلة. يخترق النهر المدينة تماماً كما اخترقتها الحياة دوماً — تحت جسر الشهداء، ومارّاً ببساتين النخيل، وعبْر قرونٍ من التجارة والشعر.\n\nتحت شوارع اليوم، تتذكّر العاصمة العباسية عصرَيها الذهبيين: بيت الحكمة الذي ترجم العالم، والمدينة المدوّرة التي قادت العلوم يوماً. أن تمشي في عاصمة العراق، هو أن تمشي في طبقات فكرةٍ غيّرت كل شيء.",
                'image_path' => 'images/places/baghdad.svg',
                'is_published' => true,
            ],
            [
                'slug' => 'babylon',
                'order' => 2,
                'name_en' => 'Babylon',
                'name_ar' => 'بابل',
                'excerpt_en' => "The ancient legend — Ishtar Gate, Nebuchadnezzar's city and a name that still rings through history.",
                'excerpt_ar' => 'الأسطورة القديمة — بوابة عشتار، مدينة نبوخذنصر، واسمٌ ما زال يتردد في التاريخ.',
                'body_en' => "Babylon is the great original of cities — the Mesopotamian capital whose name still means splendour. The reconstructed Ishtar Gate glows in blue-glazed brick, a fragment of a city that once ruled the known world.\n\nHere the code of Hammurabi stood, and here the Hanging Gardens — real or imagined — fixed paradise in the world's imagination. A visit to Babylon is a conversation with the very beginnings of the urban idea.",
                'body_ar' => "بابل هي الأصل الأعظم للمدن — العاصمة الرافدينية التي ما زال اسمها يعني روعةً وفخامة. تتوهج بوابة عشتار المعاد بناؤها بآجرّها المزجّج الأزرق، شظيّةً من مدينة حكمت العالم المعروف آنذاك.\n\nهنا وقف قانون حمورابي، وهنا علّقت الجنائن المعلّقة — حقيقيةً أم متخيّلة — الفردوس في مخيال البشرية. زيارة بابل حوارٌ مع بدايات فكرة المدينة نفسها.",
                'image_path' => 'images/places/babylon.svg',
                'is_published' => true,
            ],
            [
                'slug' => 'al-kifl',
                'order' => 3,
                'name_en' => 'al-Kifl',
                'name_ar' => 'الكفل',
                'excerpt_en' => 'The shrine of Dhul-Kifl and a shared Jewish, Islamic and biblical memory on the Euphrates.',
                'excerpt_ar' => 'مرقدُ ذي الكفل وذاكرةٌ يهودية وإسلامية وتوراتية مشتركة على ضفاف الفرات.',
                'body_en' => "On the Euphrates, the town of al-Kifl holds something rare: a shrine where traditions meet. Dhul-Kifl — identified with the prophet Ezekiel — is honoured in the Quran, the Bible and Jewish tradition alike, and this place has welcomed all of them.\n\nThe courtyard and tiled minaret speak of centuries in which communities lived side by side. Al-Kifl is a quiet argument for the possibility of shared memory.",
                'body_ar' => "على ضفاف الفرات، تحتضن بلدة الكفل شيئاً نادراً: مرقداً تلتقي فيه التقاليد. ذو الكفل — المطابق للنبي حزقيال — مكرّمٌ في القرآن والأنجيل والتراث اليهودي على السواء، وهذا المكان رحّب بكل هذه التقاليد.\n\nالصحنُ والمئذنة المزيّنة بالقاشاني يحكيان قروناً عاشت فيها المجتمعات جنباً إلى جنب. الكفل حجّةٌ هادئة على إمكانية الذاكرة المشتركة.",
                'image_path' => 'images/places/al-kifl.svg',
                'is_published' => true,
            ],
            [
                'slug' => 'karbala',
                'order' => 4,
                'name_en' => 'Karbala',
                'name_ar' => 'كربلاء',
                'excerpt_en' => "A city shaped by devotion, where the shrine of Imam Husayn draws millions and hospitality is a reflex.",
                'excerpt_ar' => 'مدينةٌ صاغتها المحبّة، حيث يجذب مرقد الإمام الحسين الملايين، وتُمارَس الضيافة كردّ فعلٍ طبيعي.',
                'body_en' => "Karbala is devotion made visible. Each year millions walk to the shrine of Imam Husayn, and the city has learned to receive them — the guest house is not a courtesy here but a vocation.\n\nBetween the two holy shrines, the city hums with commerce, piety and speed. To visit Karbala is to understand that faith, in Iraq, is not a museum piece: it is the loud, generous present.",
                'body_ar' => "كربلاء هي المحبّة المتجسّدة. كل عام يمشي الملايين إلى مرقد الإمام الحسين، وتعلّمت المدينة أن تستقبلهم — فبيتُ الضيافة هنا ليس مجاملةً بل رسالة.\n\nبين الحرمين الشريفين، تزخر المدينة بالتجارة والتقوى والسرعة. زيارة كربلاء تعني أن تفهم أن الإيمان في العراق ليس قطعةً متحفية: إنه الحاضر الجهوريّ المعطاء.",
                'image_path' => 'images/places/karbala.svg',
                'is_published' => true,
            ],
            [
                'slug' => 'najaf',
                'order' => 5,
                'name_en' => 'Najaf',
                'name_ar' => 'النجف',
                'excerpt_en' => "Scholarship and pilgrimage — the valley of peace and one of the world's great centres of learning.",
                'excerpt_ar' => 'العلمُ والزيارة — وادي السلام، وأحد أعظم مراكز العلم في العالم.',
                'body_en' => "Najaf sits beside Wadi us-Salam, the valley of peace and one of the largest cemeteries on earth, and around the shrine of Imam Ali it has built a city of books. The hawza of Najaf has trained scholars for a thousand years.\n\nThe tension is tender: an afterlife at the city's edge, and a bustling, learned present at its heart. To walk Najaf is to walk from the oldest questions to the liveliest arguments.",
                'body_ar' => "تقع النجف بجانب وادي السلام، أحد أوسع مقابر الأرض، وحول مرقد الإمام علي بنت مدينةً من الكتب. لقد خرّجت حوزة النجف علماءها على مدى ألف عام.\n\nالتوتّرُ هنا رقيقٌ جميل: ما بعد الحياة على أطراف المدينة، وعصرٌ حيّ متعلّم في قلبها. أن تمشي في النجف هو أن تمشي من أقدم الأسئلة إلى أحيّ النقاشات.",
                'image_path' => 'images/places/najaf.svg',
                'is_published' => true,
            ],
        ];

        foreach ($places as $place) {
            Place::updateOrCreate(['slug' => $place['slug']], $place);
        }
    }
}