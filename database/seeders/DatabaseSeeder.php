<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\GalleryImage;
use App\Models\Pet;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Vaccination;
use App\Models\Vet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUsers();
        $this->seedServices();
        $this->seedVets();
        $this->seedDemoPetsAndRecords();
        $this->seedPosts();
        $this->seedGallery();
        $this->seedTestimonials();
    }

    private function seedUsers(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@paticare.com'],
            [
                'name' => 'PatiCare Yönetici',
                'phone' => '0850 000 00 00',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'demo@paticare.com'],
            [
                'name' => 'Elif Yılmaz',
                'phone' => '0532 111 22 33',
                'role' => 'owner',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }

    private function seedServices(): void
    {
        $services = [
            [
                'name' => 'Genel Muayene',
                'icon' => 'stethoscope', 'color' => 'paw',
                'excerpt' => 'Baştan ayağa kapsamlı sağlık kontrolü.',
                'description' => 'Deneyimli hekimlerimiz dostunuzu baştan ayağa muayene eder; kalp, solunum, deri, göz ve genel sağlık durumunu değerlendirir. Erken teşhis için düzenli kontrolleri öneririz.',
                'price_from' => '450₺', 'duration_minutes' => 30, 'is_emergency' => false,
            ],
            [
                'name' => 'Aşı & Koruyucu Hekimlik',
                'icon' => 'syringe', 'color' => 'peach',
                'excerpt' => 'Karma, kuduz ve iç/dış parazit korumaları.',
                'description' => 'Kişiye özel aşı takvimi oluşturur, aşı kartı ile takip ederiz. Aşı zamanı geldiğinde hatırlatma alırsınız. Yavru ve yetişkin programları mevcuttur.',
                'price_from' => '350₺', 'duration_minutes' => 20, 'is_emergency' => false,
            ],
            [
                'name' => 'Cerrahi Operasyonlar',
                'icon' => 'scalpel', 'color' => 'paw',
                'excerpt' => 'Kısırlaştırmadan ileri cerrahiye güvenli ortam.',
                'description' => 'Modern ameliyathanemizde kısırlaştırma, yumuşak doku ve ortopedik cerrahiler güvenle yapılır. Anestezi öncesi tam kan tahlili ile risk en aza indirilir.',
                'price_from' => '1.500₺', 'duration_minutes' => 90, 'is_emergency' => false,
            ],
            [
                'name' => 'Diş Sağlığı',
                'icon' => 'tooth', 'color' => 'peach',
                'excerpt' => 'Diş taşı temizliği ve ağız bakımı.',
                'description' => 'Ultrasonik diş taşı temizliği, diş çekimi ve ağız içi muayene. Düzenli diş bakımı dostunuzun genel sağlığını korur.',
                'price_from' => '700₺', 'duration_minutes' => 45, 'is_emergency' => false,
            ],
            [
                'name' => '7/24 Acil Servis',
                'icon' => 'ambulance', 'color' => 'peach',
                'excerpt' => 'Gece gündüz, her an yanınızdayız.',
                'description' => 'Trafik kazası, zehirlenme, ani rahatsızlıklar… Acil durumlarda 7 gün 24 saat ekibimiz hazır. Lütfen gelmeden önce acil hattımızı arayın.',
                'price_from' => 'Durum bazlı', 'duration_minutes' => 30, 'is_emergency' => true,
            ],
            [
                'name' => 'Pet Kuaför',
                'icon' => 'scissors', 'color' => 'paw',
                'excerpt' => 'Tıraş, banyo ve tırnak bakımı.',
                'description' => 'Irka uygun tıraş, hipoalerjenik şampuanla banyo, tüy açma, tırnak ve kulak bakımı. Dostunuz mis gibi ve mutlu ayrılır.',
                'price_from' => '500₺', 'duration_minutes' => 60, 'is_emergency' => false,
            ],
            [
                'name' => 'Petshop',
                'icon' => 'bag', 'color' => 'peach',
                'excerpt' => 'Hekim onaylı mama ve ürünler.',
                'description' => 'Veteriner onaylı mamalar, vitaminler, oyuncaklar ve bakım ürünleri. Dostunuza en uygun ürünü birlikte seçelim.',
                'price_from' => 'Değişken', 'duration_minutes' => 15, 'is_emergency' => false, 'is_featured' => false,
            ],
        ];

        foreach ($services as $i => $s) {
            Service::updateOrCreate(
                ['slug' => Str::slug($s['name'])],
                array_merge($s, [
                    'slug' => Str::slug($s['name']),
                    'is_active' => true,
                    'is_featured' => $s['is_featured'] ?? true,
                    'sort_order' => $i,
                ])
            );
        }
    }

    private function seedVets(): void
    {
        $vets = [
            [
                'name' => 'Dr. Ayşe Demir', 'title' => 'Veteriner Hekim',
                'specialty' => 'İç Hastalıkları & Genel Muayene',
                'experience_years' => 12,
                'photo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=70',
                'focus_areas' => ['Kedi & Köpek İç Hastalıkları', 'Koruyucu Hekimlik', 'Geriatrik Bakım'],
                'bio' => 'Kliniğimizin kurucu hekimi. Dostlarımızı sabırla dinlemeyi ve sahiplerini bilgilendirmeyi en önemli görevi sayar.',
            ],
            [
                'name' => 'Op. Dr. Mehmet Kaya', 'title' => 'Veteriner Cerrah',
                'specialty' => 'Cerrahi & Ortopedi',
                'experience_years' => 15,
                'photo' => 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=600&q=70',
                'focus_areas' => ['Yumuşak Doku Cerrahisi', 'Ortopedi', 'Kısırlaştırma'],
                'bio' => 'İleri cerrahi operasyonlarda 15 yıllık deneyim. Minimal invaziv tekniklerle hızlı iyileşmeyi hedefler.',
            ],
            [
                'name' => 'Dr. Zeynep Şahin', 'title' => 'Veteriner Hekim',
                'specialty' => 'Diş Sağlığı & Dermatoloji',
                'experience_years' => 8,
                'photo' => 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=600&q=70',
                'focus_areas' => ['Diş & Ağız Sağlığı', 'Deri Hastalıkları', 'Alerji'],
                'bio' => 'Diş ve deri sağlığında uzman. Dostlarımızın konforunu önceleyen nazik bir yaklaşım benimser.',
            ],
            [
                'name' => 'Dr. Can Aydın', 'title' => 'Veteriner Hekim',
                'specialty' => 'Acil & Yoğun Bakım',
                'experience_years' => 10,
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=70',
                'focus_areas' => ['Acil Müdahale', 'Yoğun Bakım', 'Toksikoloji'],
                'bio' => '7/24 acil ekibimizin başında. Kritik anlarda soğukkanlı ve hızlı müdahaleleriyle güven verir.',
            ],
        ];

        foreach ($vets as $i => $v) {
            Vet::updateOrCreate(
                ['slug' => Str::slug($v['name'])],
                array_merge($v, [
                    'slug' => Str::slug($v['name']),
                    'is_active' => true,
                    'sort_order' => $i,
                ])
            );
        }
    }

    private function seedDemoPetsAndRecords(): void
    {
        $owner = User::where('email', 'demo@paticare.com')->first();
        $vets = Vet::all();
        $services = Service::all();

        $pamuk = Pet::updateOrCreate(
            ['user_id' => $owner->id, 'name' => 'Pamuk'],
            [
                'species' => 'kedi', 'breed' => 'British Shorthair', 'gender' => 'disi',
                'birth_date' => Carbon::create(2022, 4, 12), 'weight_kg' => 4.20,
                'color' => 'Gri', 'is_neutered' => true,
                'photo' => 'https://images.unsplash.com/photo-1574158622682-e40e69881006?auto=format&fit=crop&w=600&q=70',
                'notes' => 'Sakin huylu, mama seçici. Yıllık kontrolleri aksatılmamalı.',
            ]
        );

        $boncuk = Pet::updateOrCreate(
            ['user_id' => $owner->id, 'name' => 'Boncuk'],
            [
                'species' => 'kopek', 'breed' => 'Golden Retriever', 'gender' => 'erkek',
                'birth_date' => Carbon::create(2021, 9, 3), 'weight_kg' => 28.50,
                'color' => 'Sarı', 'is_neutered' => false,
                'photo' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=600&q=70',
                'notes' => 'Enerjik ve oyuncu. Kalça kontrolü öneriliyor.',
            ]
        );

        // Vaccinations — mix of overdue / due-soon / ok to demo reminders
        $vacc = [
            [$pamuk, 'Karma Aşı (Tricat)', now()->subMonths(11), now()->subDays(8)],   // overdue
            [$pamuk, 'Kuduz Aşısı', now()->subMonths(5), now()->addDays(18)],            // due soon
            [$boncuk, 'Karma Aşı (DHPPi+L)', now()->subMonths(4), now()->addDays(12)],   // due soon
            [$boncuk, 'Kuduz Aşısı', now()->subMonths(2), now()->addMonths(10)],         // ok
            [$boncuk, 'İç/Dış Parazit', now()->subWeeks(3), now()->addDays(5)],          // due soon
        ];

        foreach ($vacc as [$pet, $name, $given, $due]) {
            Vaccination::updateOrCreate(
                ['pet_id' => $pet->id, 'name' => $name],
                [
                    'vet_id' => $vets->random()->id,
                    'administered_at' => $given,
                    'next_due_at' => $due,
                    'batch_no' => 'LOT-' . random_int(10000, 99999),
                    'notes' => null,
                ]
            );
        }

        // Appointments for the demo owner
        Appointment::updateOrCreate(
            ['user_id' => $owner->id, 'pet_id' => $boncuk->id, 'date' => now()->addDays(3)->toDateString(), 'time_slot' => '14:30'],
            [
                'service_id' => $services->firstWhere('slug', 'genel-muayene')?->id,
                'vet_id' => $vets->first()->id, 'status' => 'confirmed',
                'owner_name' => $owner->name, 'owner_phone' => $owner->phone, 'owner_email' => $owner->email,
                'pet_name' => $boncuk->name, 'pet_species' => $boncuk->species,
                'notes' => 'Yıllık genel kontrol.',
            ]
        );

        Appointment::updateOrCreate(
            ['user_id' => $owner->id, 'pet_id' => $pamuk->id, 'date' => now()->subDays(20)->toDateString(), 'time_slot' => '11:00'],
            [
                'service_id' => $services->firstWhere('slug', 'asi-koruyucu-hekimlik')?->id,
                'vet_id' => $vets->first()->id, 'status' => 'completed',
                'owner_name' => $owner->name, 'owner_phone' => $owner->phone, 'owner_email' => $owner->email,
                'pet_name' => $pamuk->name, 'pet_species' => $pamuk->species,
                'notes' => 'Kuduz aşısı yapıldı.',
            ]
        );

        // A couple of guest appointments for the admin inbox
        Appointment::updateOrCreate(
            ['owner_phone' => '0533 444 55 66', 'date' => now()->addDays(1)->toDateString(), 'time_slot' => '10:00'],
            [
                'service_id' => $services->firstWhere('slug', 'pet-kuafor')?->id,
                'vet_id' => $vets->get(2)->id, 'status' => 'pending',
                'owner_name' => 'Murat Öztürk', 'owner_email' => 'murat@example.com',
                'pet_name' => 'Lokum', 'pet_species' => 'kedi',
                'notes' => 'Tıraş ve banyo istiyoruz.',
            ]
        );
    }

    private function seedPosts(): void
    {
        $posts = [
            [
                'title' => 'Yavru Kedi Beslenmesi: İlk 6 Ayda Nelere Dikkat Etmeli?',
                'category' => 'Beslenme',
                'cover' => 'https://images.unsplash.com/photo-1513360371669-4adf3dd7dff8?auto=format&fit=crop&w=1200&q=70',
                'excerpt' => 'Yeni bir yavru kediyle tanıştınız mı? İlk aylarda doğru beslenme, sağlıklı bir yaşamın temelini atar.',
                'read_minutes' => 5,
            ],
            [
                'title' => 'Köpeklerde Aşı Takvimi: Hangi Aşı Ne Zaman?',
                'category' => 'Sağlık',
                'cover' => 'https://images.unsplash.com/photo-1576201836106-db1758fd1c97?auto=format&fit=crop&w=1200&q=70',
                'excerpt' => 'Karma, kuduz ve diğer aşılar için ideal zamanlama. Yavruluktan yetişkinliğe koruyucu hekimlik rehberi.',
                'read_minutes' => 6,
            ],
            [
                'title' => 'Kedinizin Diş Sağlığını Evde Nasıl Korursunuz?',
                'category' => 'Bakım Rehberi',
                'cover' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?auto=format&fit=crop&w=1200&q=70',
                'excerpt' => 'Diş taşı ve ağız kokusu sandığınızdan ciddi olabilir. Basit alışkanlıklarla dostunuzun dişlerini koruyun.',
                'read_minutes' => 4,
            ],
            [
                'title' => 'Sıcak Havalarda Köpeğinizi Serin Tutmanın 7 Yolu',
                'category' => 'Bakım Rehberi',
                'cover' => 'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?auto=format&fit=crop&w=1200&q=70',
                'excerpt' => 'Yaz aylarında sıcak çarpması ciddi bir risk. Dostunuzu serin ve mutlu tutmak için pratik öneriler.',
                'read_minutes' => 4,
            ],
            [
                'title' => 'Kısırlaştırma Hakkında Merak Edilen Her Şey',
                'category' => 'Sağlık',
                'cover' => 'https://images.unsplash.com/photo-1535930891776-0c2dfb7fda1a?auto=format&fit=crop&w=1200&q=70',
                'excerpt' => 'Kısırlaştırma ne zaman yapılmalı, hangi sağlık yararları var? Hekimlerimizin yanıtlarıyla detaylı bir rehber.',
                'read_minutes' => 7,
            ],
            [
                'title' => 'Yeni Evcil Dostunuzu Eve Alıştırmanın İncelikleri',
                'category' => 'Davranış',
                'cover' => 'https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=1200&q=70',
                'excerpt' => 'İlk günler hem sizin hem dostunuz için heyecanlı. Stresi azaltıp güvenli bir başlangıç yapmanın yolları.',
                'read_minutes' => 5,
            ],
        ];

        $body = <<<'HTML'
<p>Evcil dostlarımızın sağlığı, doğru bilgi ve düzenli bakımla başlar. Bu rehberde, uzman hekimlerimizin sahada en sık karşılaştığı soruları ve pratik önerilerini bir araya getirdik.</p>
<h2>Neden Önemli?</h2>
<p>Küçük alışkanlıklar, dostlarımızın yaşam kalitesinde büyük fark yaratır. Erken fark edilen belirtiler, ciddi sorunların önüne geçer ve tedaviyi kolaylaştırır.</p>
<ul>
<li>Düzenli kontrolleri aksatmayın.</li>
<li>Beslenmeyi yaşa ve ırka göre planlayın.</li>
<li>Davranış değişikliklerini not edin.</li>
</ul>
<h2>Ne Zaman Veterinere Başvurmalı?</h2>
<p>İştahsızlık, halsizlik, kusma veya alışılmadık davranışlar gözlemlerseniz vakit kaybetmeden bir hekime danışın. Şüphede kaldığınızda bizi aramaktan çekinmeyin — dostlarınız için her zaman buradayız. 🐾</p>
HTML;

        foreach ($posts as $i => $p) {
            Post::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                array_merge($p, [
                    'slug' => Str::slug($p['title']),
                    'body' => $body,
                    'author' => ['Dr. Ayşe Demir', 'Dr. Zeynep Şahin', 'Op. Dr. Mehmet Kaya'][$i % 3],
                    'is_published' => true,
                    'published_at' => now()->subDays(($i + 1) * 6),
                ])
            );
        }
    }

    private function seedGallery(): void
    {
        $images = [
            ['Mutlu bir hasta', 'mutlu-dostlar', 'https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=800&q=70'],
            ['Muayene anı', 'klinik', 'https://images.unsplash.com/photo-1628009368231-7bb7cfcb0def?auto=format&fit=crop&w=800&q=70'],
            ['Ekibimizden sevgi', 'ekip', 'https://images.unsplash.com/photo-1597626133663-53df9633b799?auto=format&fit=crop&w=800&q=70'],
            ['Kontrol sonrası', 'mutlu-dostlar', 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=800&q=70'],
            ['Pati dostu ortam', 'klinik', 'https://images.unsplash.com/photo-1606425271394-c3ca9ad2b69a?auto=format&fit=crop&w=800&q=70'],
            ['Kuaför sonrası ışıltı', 'mutlu-dostlar', 'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=800&q=70'],
            ['Minik bir misafir', 'mutlu-dostlar', 'https://images.unsplash.com/photo-1425082661705-1834bfd09dca?auto=format&fit=crop&w=800&q=70'],
            ['Şefkatli eller', 'ekip', 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=800&q=70'],
        ];

        foreach ($images as $i => [$title, $cat, $url]) {
            GalleryImage::updateOrCreate(
                ['image' => $url],
                ['title' => $title, 'category' => $cat, 'sort_order' => $i, 'is_active' => true]
            );
        }
    }

    private function seedTestimonials(): void
    {
        $items = [
            ['Selin A.', 'Mırnav', 'kedi', 5, 'Pamuk’umuz için gittiğimiz ilk yerdi ve son yerimiz oldu. İlgi ve şefkatleri için minnettarız. Hekimler her soruyu sabırla yanıtladı.'],
            ['Burak T.', 'Karabaş', 'kopek', 5, 'Acil bir durumda gece yarısı aradık, kapıları sonuna kadar açıktı. Karabaş’ı kurtardılar. Gönül rahatlığıyla herkese tavsiye ederim.'],
            ['Deniz K.', 'Fındık', 'kemirgen', 5, 'Küçük dostumuz Fındık için bile bu kadar özenli olmaları beni çok mutlu etti. Temiz, güler yüzlü ve gerçekten hayvansever bir ekip.'],
            ['Merve Y.', 'Şila', 'kopek', 5, 'Kısırlaştırma operasyonu öncesi tüm sürecimizi adım adım anlattılar. Şila bir günde toparlandı. Teşekkürler PatiCare!'],
            ['Onur D.', 'Boncuk', 'kedi', 4, 'Randevu sistemi çok pratik. Aşı hatırlatması gelince çok işime yaradı, unutmuş olabilirdim. Profesyonel ve sıcak bir yer.'],
        ];

        foreach ($items as $i => [$author, $pet, $species, $rating, $body]) {
            Testimonial::updateOrCreate(
                ['author' => $author, 'body' => $body],
                [
                    'pet_name' => $pet, 'pet_species' => $species,
                    'rating' => $rating, 'is_active' => true, 'sort_order' => $i,
                ]
            );
        }
    }
}
