<?php
// ═══════════════════════════════════════════════════════════════
// data.php — StayGo Hardcoded Data Store
// No database required. All data lives here.
// ═══════════════════════════════════════════════════════════════

// ── USERS ────────────────────────────────────────────────────────
// Password for all accounts: "password"
// Hash: password_hash('password', PASSWORD_BCRYPT, ['cost'=>10])
define('DEMO_PWD_HASH', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

$USERS = [
    1 => ['id'=>1,'name'=>'Admin StayGo','email'=>'admin@staygo.com','phone'=>'+62-811-0000-0001','role'=>'admin','password'=>DEMO_PWD_HASH],
    2 => ['id'=>2,'name'=>'Sarah Jenkins','email'=>'sarah@example.com','phone'=>'+62-812-1234-5678','role'=>'user','password'=>DEMO_PWD_HASH],
    3 => ['id'=>3,'name'=>'Budi Santoso','email'=>'budi@example.com','phone'=>'+62-813-9876-5432','role'=>'user','password'=>DEMO_PWD_HASH],
];

// ── PROPERTIES ───────────────────────────────────────────────────
$PROPERTIES = [
    1 => [
        'id'=>1,'type'=>'hotel','name'=>'The Azure Grand Hotel',
        'location'=>'Seminyak, Bali',
        'description'=>'An iconic oceanfront hotel offering unparalleled luxury with panoramic views of the Indian Ocean. Each suite is meticulously designed to blend contemporary elegance with Balinese heritage.',
        'price_per_night'=>2850000,'rating'=>4.9,'review_count'=>1247,
        'max_guests'=>4,'bedrooms'=>1,'featured'=>1,
        'image_url'=>'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80',
        'amenities'=>['Free WiFi','Infinity Pool','Spa','Restaurant','Bar','Parking','Room Service','Gym'],
        'reviews'=>[
            ['name'=>'Maria K.','rating'=>5,'text'=>'Absolutely breathtaking views and impeccable service. Will definitely return!','date'=>'12 Mei 2025'],
            ['name'=>'James T.','rating'=>5,'text'=>'The best hotel experience in Bali. Staff went above and beyond.','date'=>'3 Apr 2025'],
            ['name'=>'Ayu R.','rating'=>4,'text'=>'Beautiful property, food could be slightly better but overall fantastic.','date'=>'20 Mar 2025'],
        ],
    ],
    2 => [
        'id'=>2,'type'=>'villa','name'=>'Ubud Rainforest Villa',
        'location'=>'Ubud, Bali',
        'description'=>'Hidden within the emerald rainforest, this private villa retreat offers complete seclusion with a private infinity pool overlooking the sacred Ayung River gorge.',
        'price_per_night'=>4200000,'rating'=>4.8,'review_count'=>389,
        'max_guests'=>6,'bedrooms'=>3,'featured'=>1,
        'image_url'=>'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=800&q=80',
        'amenities'=>['Private Pool','Free WiFi','Kitchen','BBQ','Air Con','Parking','Garden','Breakfast'],
        'reviews'=>[
            ['name'=>'Sophie L.','rating'=>5,'text'=>'Pure paradise. The pool overlooking the rainforest is unreal.','date'=>'15 Jun 2025'],
            ['name'=>'David M.','rating'=>5,'text'=>'Perfect honeymoon villa. Secluded and stunning.','date'=>'28 May 2025'],
        ],
    ],
    3 => [
        'id'=>3,'type'=>'hotel','name'=>'The Samara Beach Club',
        'location'=>'Canggu, Bali',
        'description'=>'A chic beachfront retreat steps from Berawa Beach. Enjoy the perfect blend of surf culture and refined luxury with breathtaking ocean sunsets from your balcony.',
        'price_per_night'=>1950000,'rating'=>4.7,'review_count'=>892,
        'max_guests'=>2,'bedrooms'=>1,'featured'=>1,
        'image_url'=>'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80',
        'amenities'=>['Free WiFi','Beach Access','Pool','Restaurant','Surf Lessons','Yoga','Bar'],
        'reviews'=>[
            ['name'=>'Emma B.','rating'=>5,'text'=>'The vibe here is absolutely perfect for a surf trip!','date'=>'2 Jun 2025'],
            ['name'=>'Tom H.','rating'=>4,'text'=>'Great location, very close to surf breaks. Pool is lovely.','date'=>'19 May 2025'],
        ],
    ],
    4 => [
        'id'=>4,'type'=>'villa','name'=>'Nusa Penida Cliffside Villa',
        'location'=>'Nusa Penida, Bali',
        'description'=>'Perched dramatically on the cliffs of Nusa Penida with breathtaking panoramic views of Crystal Bay. An once-in-a-lifetime experience for the discerning traveler.',
        'price_per_night'=>5600000,'rating'=>4.9,'review_count'=>156,
        'max_guests'=>8,'bedrooms'=>4,'featured'=>1,
        'image_url'=>'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80',
        'amenities'=>['Private Pool','Free WiFi','Kitchen','Ocean View','Snorkeling','Private Chef','Sunset Deck'],
        'reviews'=>[
            ['name'=>'Rachel P.','rating'=>5,'text'=>'The most incredible view I have ever seen from a villa. Jaw-dropping!','date'=>'8 Jun 2025'],
        ],
    ],
    5 => [
        'id'=>5,'type'=>'hotel','name'=>'Seminyak Boutique Inn',
        'location'=>'Seminyak, Bali',
        'description'=>'A stylish boutique hotel in the heart of Seminyak, walking distance to world-class restaurants and beach clubs. Perfect for the fashion-forward explorer.',
        'price_per_night'=>1200000,'rating'=>4.5,'review_count'=>634,
        'max_guests'=>2,'bedrooms'=>1,'featured'=>0,
        'image_url'=>'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
        'amenities'=>['Free WiFi','Rooftop Pool','Bar','Concierge','Room Service'],
        'reviews'=>[
            ['name'=>'Alice W.','rating'=>5,'text'=>'Great value and excellent location. Would stay again!','date'=>'1 Jun 2025'],
        ],
    ],
    6 => [
        'id'=>6,'type'=>'villa','name'=>'Tegallalang Rice Terrace Villa',
        'location'=>'Tegallalang, Bali',
        'description'=>'Wake up to the iconic UNESCO-listed Tegallalang rice terraces from your own private pool. An immersive cultural stay surrounded by emerald green paddies.',
        'price_per_night'=>3100000,'rating'=>4.8,'review_count'=>421,
        'max_guests'=>4,'bedrooms'=>2,'featured'=>0,
        'image_url'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80',
        'amenities'=>['Private Pool','Free WiFi','Kitchen','Rice Terrace View','Breakfast','Bicycle'],
        'reviews'=>[
            ['name'=>'Yuki N.','rating'=>5,'text'=>'Waking up to those rice terraces was magical. Highly recommend!','date'=>'25 May 2025'],
        ],
    ],
];

// ── FLIGHTS ──────────────────────────────────────────────────────
$today = date('Y-m-d');
$FLIGHTS = [
    1  => ['id'=>1,'airline'=>'Garuda Indonesia','airline_code'=>'GA','from_city'=>'Jakarta','from_code'=>'CGK','to_city'=>'Bali','to_code'=>'DPS','departure_time'=>'06:00','arrival_time'=>'08:05','duration'=>'2j 05m','price_economy'=>890000,'price_business'=>2800000,'seats_available'=>45,'flight_date'=>date('Y-m-d',strtotime('+3 days'))],
    2  => ['id'=>2,'airline'=>'Lion Air','airline_code'=>'JT','from_city'=>'Jakarta','from_code'=>'CGK','to_city'=>'Bali','to_code'=>'DPS','departure_time'=>'07:30','arrival_time'=>'09:35','duration'=>'2j 05m','price_economy'=>520000,'price_business'=>1500000,'seats_available'=>32,'flight_date'=>date('Y-m-d',strtotime('+3 days'))],
    3  => ['id'=>3,'airline'=>'Citilink','airline_code'=>'QG','from_city'=>'Jakarta','from_code'=>'CGK','to_city'=>'Bali','to_code'=>'DPS','departure_time'=>'09:00','arrival_time'=>'11:05','duration'=>'2j 05m','price_economy'=>480000,'price_business'=>1200000,'seats_available'=>28,'flight_date'=>date('Y-m-d',strtotime('+3 days'))],
    4  => ['id'=>4,'airline'=>'Batik Air','airline_code'=>'ID','from_city'=>'Jakarta','from_code'=>'CGK','to_city'=>'Bali','to_code'=>'DPS','departure_time'=>'11:15','arrival_time'=>'13:20','duration'=>'2j 05m','price_economy'=>650000,'price_business'=>1800000,'seats_available'=>55,'flight_date'=>date('Y-m-d',strtotime('+3 days'))],
    5  => ['id'=>5,'airline'=>'AirAsia','airline_code'=>'QZ','from_city'=>'Jakarta','from_code'=>'CGK','to_city'=>'Bali','to_code'=>'DPS','departure_time'=>'14:00','arrival_time'=>'16:05','duration'=>'2j 05m','price_economy'=>420000,'price_business'=>1100000,'seats_available'=>18,'flight_date'=>date('Y-m-d',strtotime('+3 days'))],
    6  => ['id'=>6,'airline'=>'Garuda Indonesia','airline_code'=>'GA','from_city'=>'Surabaya','from_code'=>'SUB','to_city'=>'Bali','to_code'=>'DPS','departure_time'=>'07:00','arrival_time'=>'07:55','duration'=>'0j 55m','price_economy'=>650000,'price_business'=>2100000,'seats_available'=>40,'flight_date'=>date('Y-m-d',strtotime('+3 days'))],
    7  => ['id'=>7,'airline'=>'Lion Air','airline_code'=>'JT','from_city'=>'Surabaya','from_code'=>'SUB','to_city'=>'Bali','to_code'=>'DPS','departure_time'=>'09:30','arrival_time'=>'10:25','duration'=>'0j 55m','price_economy'=>380000,'price_business'=>1100000,'seats_available'=>22,'flight_date'=>date('Y-m-d',strtotime('+3 days'))],
    8  => ['id'=>8,'airline'=>'Garuda Indonesia','airline_code'=>'GA','from_city'=>'Jakarta','from_code'=>'CGK','to_city'=>'Lombok','to_code'=>'LOP','departure_time'=>'08:00','arrival_time'=>'10:20','duration'=>'2j 20m','price_economy'=>780000,'price_business'=>2400000,'seats_available'=>35,'flight_date'=>date('Y-m-d',strtotime('+5 days'))],
    9  => ['id'=>9,'airline'=>'Garuda Indonesia','airline_code'=>'GA','from_city'=>'Bali','from_code'=>'DPS','to_city'=>'Jakarta','to_code'=>'CGK','departure_time'=>'16:00','arrival_time'=>'18:05','duration'=>'2j 05m','price_economy'=>890000,'price_business'=>2800000,'seats_available'=>30,'flight_date'=>date('Y-m-d',strtotime('+7 days'))],
    10 => ['id'=>10,'airline'=>'Lion Air','airline_code'=>'JT','from_city'=>'Bali','from_code'=>'DPS','to_city'=>'Jakarta','to_code'=>'CGK','departure_time'=>'18:30','arrival_time'=>'20:35','duration'=>'2j 05m','price_economy'=>520000,'price_business'=>1500000,'seats_available'=>42,'flight_date'=>date('Y-m-d',strtotime('+7 days'))],
];

// ── PROMOS ───────────────────────────────────────────────────────
$PROMOS = [
    'STAYGO25' => ['id'=>1,'code'=>'STAYGO25','title'=>'Weekend Getaway Special','description'=>'Dapatkan 25% off untuk semua booking hotel di akhir pekan. Cocok untuk liburan spontan!','discount_type'=>'percent','discount_value'=>25,'min_spend'=>1000000,'max_uses'=>100,'used_count'=>34,'valid_from'=>date('Y-m-d'),'valid_until'=>date('Y-m-d',strtotime('+30 days')),'active'=>1,'image_url'=>'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=400&q=70'],
    'VILLA50'  => ['id'=>2,'code'=>'VILLA50','title'=>'Villa Luxury Flash Sale','description'=>'Diskon Rp500.000 untuk semua booking villa. Penawaran terbatas, segera pesan!','discount_type'=>'fixed','discount_value'=>500000,'min_spend'=>2000000,'max_uses'=>50,'used_count'=>28,'valid_from'=>date('Y-m-d'),'valid_until'=>date('Y-m-d',strtotime('+14 days')),'active'=>1,'image_url'=>'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=400&q=70'],
    'FLY20'    => ['id'=>3,'code'=>'FLY20','title'=>'Flight Discount Express','description'=>'Hemat 20% untuk semua booking penerbangan. Jelajahi destinasi baru dengan harga lebih murah!','discount_type'=>'percent','discount_value'=>20,'min_spend'=>500000,'max_uses'=>200,'used_count'=>87,'valid_from'=>date('Y-m-d'),'valid_until'=>date('Y-m-d',strtotime('+21 days')),'active'=>1,'image_url'=>'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=400&q=70'],
    'NEWUSER'  => ['id'=>4,'code'=>'NEWUSER','title'=>'First Trip Bonus','description'=>'Users baru dapat Rp200.000 off untuk booking pertama. Selamat bergabung di StayGo!','discount_type'=>'fixed','discount_value'=>200000,'min_spend'=>500000,'max_uses'=>999,'used_count'=>142,'valid_from'=>date('Y-m-d'),'valid_until'=>date('Y-m-d',strtotime('+60 days')),'active'=>1,'image_url'=>'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&q=70'],
];

// ── DEMO BOOKINGS (pre-seeded for Sarah's account) ───────────────
$DEMO_BOOKINGS = [
    'SGH-001-2025' => [
        'id'=>1,'user_id'=>2,'booking_type'=>'hotel','property_id'=>1,'flight_id'=>null,
        'booking_ref'=>'SGH-001-2025','guest_name'=>'Sarah Jenkins','guest_email'=>'sarah@example.com','guest_phone'=>'+62-812-1234-5678',
        'check_in'=>date('Y-m-d',strtotime('+10 days')),'check_out'=>date('Y-m-d',strtotime('+13 days')),
        'flight_date'=>null,'seat_class'=>null,'guests'=>2,'total_amount'=>9472500,
        'payment_method'=>'bank_transfer','status'=>'confirmed','special_requests'=>'','created_at'=>date('Y-m-d H:i:s',strtotime('-2 days')),
    ],
    'SGV-002-2025' => [
        'id'=>2,'user_id'=>2,'booking_type'=>'villa','property_id'=>2,'flight_id'=>null,
        'booking_ref'=>'SGV-002-2025','guest_name'=>'Sarah Jenkins','guest_email'=>'sarah@example.com','guest_phone'=>'+62-812-1234-5678',
        'check_in'=>date('Y-m-d',strtotime('-30 days')),'check_out'=>date('Y-m-d',strtotime('-27 days')),
        'flight_date'=>null,'seat_class'=>null,'guests'=>4,'total_amount'=>13986600,
        'payment_method'=>'gopay','status'=>'completed','special_requests'=>'Late check-in please','created_at'=>date('Y-m-d H:i:s',strtotime('-32 days')),
    ],
    'SGF-003-2025' => [
        'id'=>3,'user_id'=>2,'booking_type'=>'flight','property_id'=>null,'flight_id'=>1,
        'booking_ref'=>'SGF-003-2025','guest_name'=>'Sarah Jenkins','guest_email'=>'sarah@example.com','guest_phone'=>'+62-812-1234-5678',
        'check_in'=>null,'check_out'=>null,
        'flight_date'=>date('Y-m-d',strtotime('+10 days')),'seat_class'=>'economy','guests'=>1,'total_amount'=>988900,
        'payment_method'=>'credit_card','status'=>'confirmed','special_requests'=>'','created_at'=>date('Y-m-d H:i:s',strtotime('-1 day')),
    ],
];

// ── DEMO FAVOURITES ──────────────────────────────────────────────
$DEMO_FAVOURITES = [
    2 => [1, 4],  // Sarah likes property 1 and 4
];
