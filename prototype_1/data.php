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
    1 => ['id' => 1, 'name' => 'Admin StayGo', 'email' => 'admin@staygo.com', 'phone' => '+62-811-0000-0001', 'role' => 'admin', 'password' => DEMO_PWD_HASH],
    2 => ['id' => 2, 'name' => 'Sarah Jenkins', 'email' => 'sarah@example.com', 'phone' => '+62-812-1234-5678', 'role' => 'user', 'password' => DEMO_PWD_HASH],
    3 => ['id' => 3, 'name' => 'Budi Santoso', 'email' => 'budi@example.com', 'phone' => '+62-813-9876-5432', 'role' => 'user', 'password' => DEMO_PWD_HASH],
];

// ── PROPERTIES ───────────────────────────────────────────────────
$PROPERTIES = [
    1 => [
        'id' => 1,
        'type' => 'hotel',
        'name' => 'The Azure Grand Hotel',
        'location' => 'Seminyak, Bali',
        'lat' => -8.6897, 'lng' => 115.1647,
        'description' => 'An iconic oceanfront hotel offering unparalleled luxury with panoramic views of the Indian Ocean. Each suite is meticulously designed to blend contemporary elegance with Balinese heritage.',
        'price_per_night' => 2850000,
        'rating' => 4.9,
        'review_count' => 1247,
        'max_guests' => 4,
        'bedrooms' => 1,
        'featured' => 1,
        'image_url' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80',
        'amenities' => ['Free WiFi', 'Infinity Pool', 'Spa', 'Restaurant', 'Bar', 'Parking', 'Room Service', 'Gym'],
        'rooms' => [
            ['name' => 'Deluxe Room', 'slug' => 'deluxe-room', 'price' => 2850000, 'size' => '32 m2', 'bed' => '1 King Bed', 'max_guests' => 2, 'rooms' => '1 room', 'bathroom' => '1 bathroom', 'amenities' => ['Free WiFi', 'Breakfast', 'City View', 'Smart TV', 'Workspace', 'Rain Shower'], 'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1000&q=80', 'desc' => 'A clean, comfortable room for solo travelers or couples.'],
            ['name' => 'Ocean View Suite', 'slug' => 'ocean-view-suite', 'price' => 4133000, 'size' => '48 m2', 'bed' => '1 King Bed + Sofa', 'max_guests' => 3, 'rooms' => '1 suite', 'bathroom' => '1 bathroom', 'amenities' => ['Ocean View', 'Bathtub', 'Lounge Area', 'Mini Bar', 'Premium Toiletries', 'Breakfast'], 'image' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=1000&q=80', 'desc' => 'A larger suite with better view, lounge area, and upgraded amenities.'],
            ['name' => 'Family Connecting Room', 'slug' => 'family-connecting-room', 'price' => 5273000, 'size' => '64 m2', 'bed' => '2 Rooms - 3 Beds', 'max_guests' => 4, 'rooms' => '2 connected rooms', 'bathroom' => '2 bathrooms', 'amenities' => ['Connecting Room', 'Breakfast', 'Extra Space', 'Kids Friendly', 'Two Bathrooms', 'Family Sofa'], 'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=1000&q=80', 'desc' => 'A bigger setup for families or groups.'],
        ],
        'reviews' => [
            ['name' => 'Maria K.', 'rating' => 5, 'text' => 'Absolutely breathtaking views and impeccable service. Will definitely return!', 'date' => '12 Mei 2025'],
            ['name' => 'James T.', 'rating' => 5, 'text' => 'The best hotel experience in Bali. Staff went above and beyond.', 'date' => '3 Apr 2025'],
            ['name' => 'Ayu R.', 'rating' => 4, 'text' => 'Beautiful property, food could be slightly better but overall fantastic.', 'date' => '20 Mar 2025'],
        ],
    ],
    2 => [
        'id' => 2,
        'type' => 'villa',
        'name' => 'Ubud Rainforest Villa',
        'location' => 'Ubud, Bali',
        'lat' => -8.5069, 'lng' => 115.2625,
        'description' => 'Hidden within the emerald rainforest, this private villa retreat offers complete seclusion with a private infinity pool overlooking the sacred Ayung River gorge.',
        'price_per_night' => 4200000,
        'rating' => 4.8,
        'review_count' => 389,
        'max_guests' => 6,
        'bedrooms' => 3,
        'featured' => 1,
        'image_url' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=800&q=80',
        'amenities' => ['Private Pool', 'Free WiFi', 'Kitchen', 'BBQ', 'Air Con', 'Parking', 'Garden', 'Breakfast'],
        'reviews' => [
            ['name' => 'Sophie L.', 'rating' => 5, 'text' => 'Pure paradise. The pool overlooking the rainforest is unreal.', 'date' => '15 Jun 2025'],
            ['name' => 'David M.', 'rating' => 5, 'text' => 'Perfect honeymoon villa. Secluded and stunning.', 'date' => '28 May 2025'],
        ],
    ],
    3 => [
        'id' => 3,
        'type' => 'hotel',
        'name' => 'The Samara Beach Club',
        'location' => 'Canggu, Bali',
        'lat' => -8.6527, 'lng' => 115.1327,
        'description' => 'A chic beachfront retreat steps from Berawa Beach. Enjoy the perfect blend of surf culture and refined luxury with breathtaking ocean sunsets from your balcony.',
        'price_per_night' => 1950000,
        'rating' => 4.7,
        'review_count' => 892,
        'max_guests' => 2,
        'bedrooms' => 1,
        'featured' => 1,
        'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80',
        'amenities' => ['Free WiFi', 'Beach Access', 'Pool', 'Restaurant', 'Surf Lessons', 'Yoga', 'Bar'],
        'rooms' => [
            ['name' => 'Deluxe Room', 'slug' => 'deluxe-room', 'price' => 1950000, 'size' => '32 m2', 'bed' => '1 King Bed', 'max_guests' => 2, 'rooms' => '1 room', 'bathroom' => '1 bathroom', 'amenities' => ['Free WiFi', 'Breakfast', 'Beach View', 'Smart TV', 'Workspace', 'Rain Shower'], 'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1000&q=80', 'desc' => 'A clean, comfortable room with beach access.'],
            ['name' => 'Ocean View Suite', 'slug' => 'ocean-view-suite', 'price' => 2828000, 'size' => '48 m2', 'bed' => '1 King Bed + Sofa', 'max_guests' => 3, 'rooms' => '1 suite', 'bathroom' => '1 bathroom', 'amenities' => ['Ocean View', 'Bathtub', 'Lounge Area', 'Mini Bar', 'Premium Toiletries', 'Breakfast'], 'image' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=1000&q=80', 'desc' => 'Suite with ocean view and upgraded amenities.'],
            ['name' => 'Family Connecting Room', 'slug' => 'family-connecting-room', 'price' => 3608000, 'size' => '64 m2', 'bed' => '2 Rooms - 3 Beds', 'max_guests' => 4, 'rooms' => '2 connected rooms', 'bathroom' => '2 bathrooms', 'amenities' => ['Connecting Room', 'Breakfast', 'Extra Space', 'Kids Friendly', 'Two Bathrooms', 'Family Sofa'], 'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=1000&q=80', 'desc' => 'Family room for groups.'],
        ],
        'reviews' => [
            ['name' => 'Emma B.', 'rating' => 5, 'text' => 'The vibe here is absolutely perfect for a surf trip!', 'date' => '2 Jun 2025'],
            ['name' => 'Tom H.', 'rating' => 4, 'text' => 'Great location, very close to surf breaks. Pool is lovely.', 'date' => '19 May 2025'],
        ],
    ],
    4 => [
        'id' => 4,
        'type' => 'villa',
        'name' => 'Nusa Penida Cliffside Villa',
        'location' => 'Nusa Penida, Bali',
        'lat' => -8.7278, 'lng' => 115.5444,
        'description' => 'Perched dramatically on the cliffs of Nusa Penida with breathtaking panoramic views of Crystal Bay. An once-in-a-lifetime experience for the discerning traveler.',
        'price_per_night' => 5600000,
        'rating' => 4.9,
        'review_count' => 156,
        'max_guests' => 8,
        'bedrooms' => 4,
        'featured' => 1,
        'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80',
        'amenities' => ['Private Pool', 'Free WiFi', 'Kitchen', 'Ocean View', 'Snorkeling', 'Private Chef', 'Sunset Deck'],
        'reviews' => [
            ['name' => 'Rachel P.', 'rating' => 5, 'text' => 'The most incredible view I have ever seen from a villa. Jaw-dropping!', 'date' => '8 Jun 2025'],
        ],
    ],
    5 => [
        'id' => 5,
        'type' => 'hotel',
        'name' => 'Seminyak Boutique Inn',
        'location' => 'Seminyak, Bali',
        'lat' => -8.6923, 'lng' => 115.1601,
        'description' => 'A stylish boutique hotel in the heart of Seminyak, walking distance to world-class restaurants and beach clubs. Perfect for the fashion-forward explorer.',
        'price_per_night' => 1200000,
        'rating' => 4.5,
        'review_count' => 634,
        'max_guests' => 2,
        'bedrooms' => 1,
        'featured' => 0,
        'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
        'amenities' => ['Free WiFi', 'Rooftop Pool', 'Bar', 'Concierge', 'Room Service'],
        'reviews' => [
            ['name' => 'Alice W.', 'rating' => 5, 'text' => 'Great value and excellent location. Would stay again!', 'date' => '1 Jun 2025'],
        ],
    ],
    6 => [
        'id' => 6,
        'type' => 'villa',
        'name' => 'Tegallalang Rice Terrace Villa',
        'location' => 'Tegallalang, Bali',
        'lat' => -8.4312, 'lng' => 115.2786,
        'description' => 'Wake up to the iconic UNESCO-listed Tegallalang rice terraces from your own private pool. An immersive cultural stay surrounded by emerald green paddies.',
        'price_per_night' => 3100000,
        'rating' => 4.8,
        'review_count' => 421,
        'max_guests' => 4,
        'bedrooms' => 2,
        'featured' => 0,
        'image_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80',
        'amenities' => ['Private Pool', 'Free WiFi', 'Kitchen', 'Rice Terrace View', 'Breakfast', 'Bicycle'],
        'reviews' => [
            ['name' => 'Yuki N.', 'rating' => 5, 'text' => 'Waking up to those rice terraces was magical. Highly recommend!', 'date' => '25 May 2025'],
        ],
    ],
];

// ── FLIGHTS ──────────────────────────────────────────────────────
$today = date('Y-m-d');
$FLIGHTS = [
    1 => [
        'id' => 1, 'airline' => 'Garuda Indonesia', 'logo' => 'https://www.garuda-indonesia.com/content/dam/garuda_home_revamp/images/logo/garuda_indonesia_logo.png',
        'from_city' => 'Jakarta', 'from_code' => 'CGK', 'to_city' => 'Bali', 'to_code' => 'DPS',
        'dep_time' => '06:30', 'arr_time' => '09:20', 'duration' => '1h 50m',
        'price_economy' => 1450000, 'price_business' => 3200000
    ],
    2 => [
        'id' => 2, 'airline' => 'Batik Air', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/4b/Batik_Air_Logo.svg',
        'from_city' => 'Jakarta', 'from_code' => 'CGK', 'to_city' => 'Bali', 'to_code' => 'DPS',
        'dep_time' => '08:00', 'arr_time' => '10:55', 'duration' => '1h 55m',
        'price_economy' => 1100000, 'price_business' => 2400000
    ],
    3 => [
        'id' => 3, 'airline' => 'Citilink', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Citilink_logo.svg',
        'from_city' => 'Jakarta', 'from_code' => 'CGK', 'to_city' => 'Bali', 'to_code' => 'DPS',
        'dep_time' => '11:15', 'arr_time' => '14:10', 'duration' => '1h 55m',
        'price_economy' => 890000, 'price_business' => 1800000
    ],
    4 => [
        'id' => 4, 'airline' => 'AirAsia', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/f5/AirAsia_Logo.svg',
        'from_city' => 'Jakarta', 'from_code' => 'CGK', 'to_city' => 'Bali', 'to_code' => 'DPS',
        'dep_time' => '14:45', 'arr_time' => '17:35', 'duration' => '1h 50m',
        'price_economy' => 750000, 'price_business' => 1500000
    ],
    5 => [
        'id' => 5, 'airline' => 'Lion Air', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Lion_Air_logo.svg',
        'from_city' => 'Jakarta', 'from_code' => 'CGK', 'to_city' => 'Bali', 'to_code' => 'DPS',
        'dep_time' => '18:20', 'arr_time' => '21:15', 'duration' => '1h 55m',
        'price_economy' => 790000, 'price_business' => 1600000
    ],
    6 => [
        'id' => 6, 'airline' => 'Garuda Indonesia', 'logo' => 'https://www.garuda-indonesia.com/content/dam/garuda_home_revamp/images/logo/garuda_indonesia_logo.png',
        'from_city' => 'Bali', 'from_code' => 'DPS', 'to_city' => 'Jakarta', 'to_code' => 'CGK',
        'dep_time' => '10:30', 'arr_time' => '11:20', 'duration' => '1h 50m',
        'price_economy' => 1500000, 'price_business' => 3400000
    ],
    7 => [
        'id' => 7, 'airline' => 'Batik Air', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/4b/Batik_Air_Logo.svg',
        'from_city' => 'Bali', 'from_code' => 'DPS', 'to_city' => 'Jakarta', 'to_code' => 'CGK',
        'dep_time' => '13:00', 'arr_time' => '13:55', 'duration' => '1h 55m',
        'price_economy' => 1150000, 'price_business' => 2500000
    ],
    8 => [
        'id' => 8, 'airline' => 'Citilink', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Citilink_logo.svg',
        'from_city' => 'Bali', 'from_code' => 'DPS', 'to_city' => 'Jakarta', 'to_code' => 'CGK',
        'dep_time' => '16:00', 'arr_time' => '16:55', 'duration' => '1h 55m',
        'price_economy' => 920000, 'price_business' => 1900000
    ],
    9 => [
        'id' => 9, 'airline' => 'AirAsia', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/f5/AirAsia_Logo.svg',
        'from_city' => 'Bali', 'from_code' => 'DPS', 'to_city' => 'Jakarta', 'to_code' => 'CGK',
        'dep_time' => '19:15', 'arr_time' => '20:05', 'duration' => '1h 50m',
        'price_economy' => 780000, 'price_business' => 1550000
    ],
    10 => [
        'id' => 10, 'airline' => 'Garuda Indonesia', 'logo' => 'https://www.garuda-indonesia.com/content/dam/garuda_home_revamp/images/logo/garuda_indonesia_logo.png',
        'from_city' => 'Surabaya', 'from_code' => 'SUB', 'to_city' => 'Jakarta', 'to_code' => 'CGK',
        'dep_time' => '06:00', 'arr_time' => '07:30', 'duration' => '1h 30m',
        'price_economy' => 1200000, 'price_business' => 2800000
    ],
    11 => [
        'id' => 11, 'airline' => 'Citilink', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Citilink_logo.svg',
        'from_city' => 'Surabaya', 'from_code' => 'SUB', 'to_city' => 'Jakarta', 'to_code' => 'CGK',
        'dep_time' => '09:30', 'arr_time' => '11:00', 'duration' => '1h 30m',
        'price_economy' => 750000, 'price_business' => 1600000
    ],
    12 => [
        'id' => 12, 'airline' => 'Lion Air', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Lion_Air_logo.svg',
        'from_city' => 'Surabaya', 'from_code' => 'SUB', 'to_city' => 'Jakarta', 'to_code' => 'CGK',
        'dep_time' => '13:15', 'arr_time' => '14:45', 'duration' => '1h 30m',
        'price_economy' => 680000, 'price_business' => 1400000
    ],
    13 => [
        'id' => 13, 'airline' => 'Garuda Indonesia', 'logo' => 'https://www.garuda-indonesia.com/content/dam/garuda_home_revamp/images/logo/garuda_indonesia_logo.png',
        'from_city' => 'Jakarta', 'from_code' => 'CGK', 'to_city' => 'Surabaya', 'to_code' => 'SUB',
        'dep_time' => '08:30', 'arr_time' => '10:00', 'duration' => '1h 30m',
        'price_economy' => 1250000, 'price_business' => 2950000
    ],
    14 => [
        'id' => 14, 'airline' => 'Citilink', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Citilink_logo.svg',
        'from_city' => 'Jakarta', 'from_code' => 'CGK', 'to_city' => 'Surabaya', 'to_code' => 'SUB',
        'dep_time' => '12:00', 'arr_time' => '13:30', 'duration' => '1h 30m',
        'price_economy' => 770000, 'price_business' => 1650000
    ]
];

// ── PROMOS ───────────────────────────────────────────────────────
$PROMOS = [
    'STAYGO25' => [
        'id' => 1,
        'code' => 'STAYGO25',
        'title' => 'Weekend Getaway Special',
        'category' => 'hotel',
        'color'=>'#0D6EFD',
        'description' => 'Dapatkan 25% off untuk semua booking hotel di akhir pekan.',
        'discount_type' => 'percent',
        'discount_value' => 25,
        'min_spend' => 1000000,
        'max_uses' => 100,
        'used_count' => 34,
        'valid_from' => date('Y-m-d'),
        'valid_until' => date('Y-m-d', strtotime('+30 days')),
        'active' => 1,
        'image_url' => '...'
    ],
    'VILLA50' => [
        'id' => 2,
        'code' => 'VILLA50',
        'title' => 'Villa Luxury Flash Sale',
        'category' => 'villa',
        'color'=>'#A855F7',
        'description' => 'Diskon Rp500.000 untuk booking villa.',
        'discount_type' => 'fixed',
        'discount_value' => 500000,
        'min_spend' => 2000000,
        'max_uses' => 50,
        'used_count' => 28,
        'valid_from' => date('Y-m-d'),
        'valid_until' => date('Y-m-d', strtotime('+14 days')),
        'active' => 1,
        'image_url' => '...'
    ],
    'FLY20' => [
        'id' => 3,
        'code' => 'FLY20',
        'title' => 'Flight Discount Express',
        'category' => 'flight',
        'color'=>'#00B894', 
        'description' => 'Hemat 20% untuk semua booking penerbangan.',
        'discount_type' => 'percent',
        'discount_value' => 20,
        'min_spend' => 500000,
        'max_uses' => 200,
        'used_count' => 87,
        'valid_from' => date('Y-m-d'),
        'valid_until' => date('Y-m-d', strtotime('+21 days')),
        'active' => 1,
        'image_url' => '...'
    ],
    'NEWUSER' => [
        'id' => 4,
        'code' => 'NEWUSER',
        'title' => 'First Trip Bonus',
        'category' => 'all',
        'description' => 'Users baru dapat Rp200.000 off.',
        'discount_type' => 'fixed',
        'discount_value' => 200000,
        'min_spend' => 500000,
        'max_uses' => 999,
        'used_count' => 142,
        'valid_from' => date('Y-m-d'),
        'valid_until' => date('Y-m-d', strtotime('+60 days')),
        'active' => 1,
        'image_url' => '...'
    ]
];

// ── DEMO BOOKINGS (pre-seeded for Sarah's account) ───────────────
$DEMO_BOOKINGS = [
    'SGH-001-2025' => [
        'id' => 1,
        'user_id' => 2,
        'booking_type' => 'hotel',
        'property_id' => 1,
        'flight_id' => null,
        'booking_ref' => 'SGH-001-2025',
        'guest_name' => 'Sarah Jenkins',
        'guest_email' => 'sarah@example.com',
        'guest_phone' => '+62-812-1234-5678',
        'check_in' => date('Y-m-d', strtotime('+10 days')),
        'check_out' => date('Y-m-d', strtotime('+13 days')),
        'flight_date' => null,
        'seat_class' => null,
        'guests' => 2,
        'total_amount' => 9472500,
        'payment_method' => 'bank_transfer',
        'status' => 'confirmed',
        'special_requests' => '',
        'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
    ],
    'SGV-002-2025' => [
        'id' => 2,
        'user_id' => 2,
        'booking_type' => 'villa',
        'property_id' => 2,
        'flight_id' => null,
        'booking_ref' => 'SGV-002-2025',
        'guest_name' => 'Sarah Jenkins',
        'guest_email' => 'sarah@example.com',
        'guest_phone' => '+62-812-1234-5678',
        'check_in' => date('Y-m-d', strtotime('-30 days')),
        'check_out' => date('Y-m-d', strtotime('-27 days')),
        'flight_date' => null,
        'seat_class' => null,
        'guests' => 4,
        'total_amount' => 13986600,
        'payment_method' => 'gopay',
        'status' => 'completed',
        'special_requests' => 'Late check-in please',
        'created_at' => date('Y-m-d H:i:s', strtotime('-32 days')),
    ],
    'SGF-003-2025' => [
        'id' => 3,
        'user_id' => 2,
        'booking_type' => 'flight',
        'property_id' => null,
        'flight_id' => 1,
        'booking_ref' => 'SGF-003-2025',
        'guest_name' => 'Sarah Jenkins',
        'guest_email' => 'sarah@example.com',
        'guest_phone' => '+62-812-1234-5678',
        'check_in' => null,
        'check_out' => null,
        'flight_date' => date('Y-m-d', strtotime('+10 days')),
        'seat_class' => 'economy',
        'guests' => 1,
        'total_amount' => 988900,
        'payment_method' => 'credit_card',
        'status' => 'confirmed',
        'special_requests' => '',
        'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
    ],
];

// ── DEMO FAVOURITES ──────────────────────────────────────────────
$DEMO_FAVOURITES = [
    2 => [1, 4],  // Sarah likes property 1 and 4
];

$BOOKINGS = [];