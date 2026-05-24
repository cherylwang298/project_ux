<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// ─── Brand Colors ────────────────────────────────────────
// Sriwijaya Air: Navy #003082 | Red-Orange #E8151B | White
define('BRAND_PRIMARY', '#003082');
define('BRAND_ACCENT',  '#E8151B');

// ─── 20+ Indonesian Cities with IATA ─────────────────────
$cities = [
    'Jakarta'          => 'CGK',
    'Surabaya'         => 'SUB',
    'Bandung'          => 'BDO',
    'Denpasar (Bali)'  => 'DPS',
    'Makassar'         => 'UPG',
    'Medan'            => 'KNO',
    'Palembang'        => 'PLM',
    'Semarang'         => 'SRG',
    'Yogyakarta'       => 'JOG',
    'Pekanbaru'        => 'PKU',
    'Balikpapan'       => 'BPN',
    'Manado'           => 'MDC',
    'Ambon'            => 'AMQ',
    'Jayapura'         => 'DJJ',
    'Lombok'           => 'LOP',
    'Kupang'           => 'KOE',
    'Tarakan'          => 'TRK',
    'Pontianak'        => 'PNK',
    'Batam'            => 'BTH',
    'Solo'             => 'SOC',
];

// ─── Popular Routes ───────────────────────────────────────
$popular_routes = [
    ['from' => 'Jakarta',         'to' => 'Denpasar (Bali)',  'price' => 89],
    ['from' => 'Jakarta',         'to' => 'Surabaya',         'price' => 55],
    ['from' => 'Surabaya',        'to' => 'Denpasar (Bali)',  'price' => 62],
    ['from' => 'Jakarta',         'to' => 'Yogyakarta',       'price' => 49],
    ['from' => 'Medan',           'to' => 'Jakarta',          'price' => 75],
    ['from' => 'Makassar',        'to' => 'Jakarta',          'price' => 95],
];

// ─── Hotels (with Unsplash photos) ───────────────────────
$hotels = [
    ['id'=>1,  'name'=>'The Gaia Hotel Bandung',   'city'=>'Bandung',         'stars'=>5, 'price'=>120, 'rating'=>9.2, 'reviews'=>5945, 'address'=>'Jl. Dr. Setiabudi No.430, Lembang', 'img'=>'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80', 'amenities'=>['Pool','Spa','WiFi','Breakfast','Parking']],
    ['id'=>2,  'name'=>'SanGria Resort & Spa',      'city'=>'Bandung',         'stars'=>4, 'price'=>80,  'rating'=>8.5, 'reviews'=>3210, 'address'=>'Jl. Maribaya No.6, Lembang',        'img'=>'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=600&q=80', 'amenities'=>['Pool','WiFi','Spa']],
    ['id'=>3,  'name'=>'Mulia Hotel Jakarta',       'city'=>'Jakarta',         'stars'=>5, 'price'=>180, 'rating'=>9.5, 'reviews'=>8801, 'address'=>'Jl. Asia Afrika, Senayan, Jakarta',  'img'=>'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=600&q=80', 'amenities'=>['Pool','Spa','WiFi','Breakfast','Gym']],
    ['id'=>4,  'name'=>'Grand Inna Yogyakarta',     'city'=>'Yogyakarta',      'stars'=>4, 'price'=>65,  'rating'=>8.2, 'reviews'=>2140, 'address'=>'Jl. Malioboro No.60, Yogyakarta',   'img'=>'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600&q=80', 'amenities'=>['WiFi','Breakfast','Parking']],
    ['id'=>5,  'name'=>'Ayana Resort Bali',         'city'=>'Denpasar (Bali)', 'stars'=>5, 'price'=>250, 'rating'=>9.8, 'reviews'=>12500,'address'=>'Jl. Karang Mas Sejahtera, Jimbaran','img'=>'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80', 'amenities'=>['Pool','Spa','WiFi','Breakfast','Beach']],
    ['id'=>6,  'name'=>'Hotel Majapahit Surabaya',  'city'=>'Surabaya',        'stars'=>4, 'price'=>90,  'rating'=>8.7, 'reviews'=>4300, 'address'=>'Jl. Tunjungan No.65, Surabaya',     'img'=>'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=600&q=80', 'amenities'=>['Pool','WiFi','Breakfast']],
    ['id'=>7,  'name'=>'Claro Hotel Makassar',      'city'=>'Makassar',        'stars'=>4, 'price'=>70,  'rating'=>8.0, 'reviews'=>1870, 'address'=>'Jl. A. Pettarani, Makassar',        'img'=>'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=600&q=80', 'amenities'=>['Pool','WiFi','Gym']],
    ['id'=>8,  'name'=>'Grand Mercure Medan',       'city'=>'Medan',           'stars'=>5, 'price'=>110, 'rating'=>8.9, 'reviews'=>3650, 'address'=>'Jl. Balai Kota No.1, Medan',        'img'=>'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=600&q=80', 'amenities'=>['Pool','Spa','WiFi','Breakfast']],
    ['id'=>9,  'name'=>'Innit Lombok Resort',       'city'=>'Lombok',          'stars'=>4, 'price'=>95,  'rating'=>8.6, 'reviews'=>2200, 'address'=>'Pantai Senggigi, Lombok',           'img'=>'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=600&q=80', 'amenities'=>['Pool','Beach','WiFi']],
    ['id'=>10, 'name'=>'Novotel Balikpapan',        'city'=>'Balikpapan',      'stars'=>4, 'price'=>85,  'rating'=>8.3, 'reviews'=>1450, 'address'=>'Jl. Brigjen Ery Suparjan, Balikpapan','img'=>'https://images.unsplash.com/photo-1455587734955-081b22074882?w=600&q=80','amenities'=>['Pool','WiFi','Gym']],
    ['id'=>11, 'name'=>'Aston Manado City Hotel',   'city'=>'Manado',          'stars'=>4, 'price'=>75,  'rating'=>8.1, 'reviews'=>990,  'address'=>'Jl. Pierre Tendean, Manado',        'img'=>'https://images.unsplash.com/photo-1518733057094-95b53143d2a7?w=600&q=80', 'amenities'=>['Pool','WiFi','Breakfast']],
    ['id'=>12, 'name'=>'Padma Hotel Bandung',       'city'=>'Bandung',         'stars'=>5, 'price'=>140, 'rating'=>9.0, 'reviews'=>6700, 'address'=>'Jl. Ranca Bentang No.56, Ciumbuleuit','img'=>'https://images.unsplash.com/photo-1604014238170-4def1e4e6fcf?w=600&q=80','amenities'=>['Pool','Spa','WiFi','Breakfast','Gym']],
];

// ─── Tourism Spots ────────────────────────────────────────
$tourism = [
    ['id'=>1, 'name'=>'Borobudur Temple',     'city'=>'Yogyakarta',      'price'=>25, 'rating'=>4.9, 'category'=>'Culture',    'img'=>'https://images.unsplash.com/photo-1584810359583-96fc3448beaa?w=600&q=80', 'desc'=>'World heritage Buddhist monument, largest in Southeast Asia.'],
    ['id'=>2, 'name'=>'Tanah Lot Temple',     'city'=>'Denpasar (Bali)', 'price'=>15, 'rating'=>4.8, 'category'=>'Culture',    'img'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80', 'desc'=>'Iconic sea temple perched on a rocky outcrop.'],
    ['id'=>3, 'name'=>'Mount Bromo',          'city'=>'Surabaya',        'price'=>30, 'rating'=>4.9, 'category'=>'Nature',     'img'=>'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=600&q=80', 'desc'=>'Active volcano with a stunning sunrise panorama.'],
    ['id'=>4, 'name'=>'Raja Ampat Islands',   'city'=>'Jayapura',        'price'=>50, 'rating'=>5.0, 'category'=>'Diving',     'img'=>'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600&q=80', 'desc'=>'World-class diving paradise with extraordinary marine life.'],
    ['id'=>5, 'name'=>'Trans Studio Bandung', 'city'=>'Bandung',         'price'=>40, 'rating'=>4.5, 'category'=>'Theme Park', 'img'=>'https://images.unsplash.com/photo-1562077772-3bd90403f7f0?w=600&q=80', 'desc'=>'One of the largest indoor theme parks in Indonesia.'],
    ['id'=>6, 'name'=>'Prambanan Temple',     'city'=>'Yogyakarta',      'price'=>20, 'rating'=>4.7, 'category'=>'Culture',    'img'=>'https://images.unsplash.com/photo-1604928141064-207cea6f571f?w=600&q=80', 'desc'=>'9th-century Hindu compound, a UNESCO World Heritage Site.'],
    ['id'=>7, 'name'=>'Lake Toba',            'city'=>'Medan',           'price'=>10, 'rating'=>4.6, 'category'=>'Nature',     'img'=>'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=600&q=80', 'desc'=>'Largest volcanic lake in the world with Samosir Island.'],
    ['id'=>8, 'name'=>'Komodo Island',        'city'=>'Lombok',          'price'=>45, 'rating'=>4.9, 'category'=>'Wildlife',   'img'=>'https://images.unsplash.com/photo-1518173946687-a4c8892bbd9f?w=600&q=80', 'desc'=>'Home to the Komodo dragon and pristine pink-sand beaches.'],
];

// ─── Promo Codes ──────────────────────────────────────────
$promoCodes = [
    'VOYAGE10'  => 10,
    'HEMAT20'   => 20,
    'INDONESIA' => 15,
];

// ─── Add-on Packages ─────────────────────────────────────
$addons = [
    'baggage'       => ['label' => 'Bagasi Tambahan 20kg',   'price' => 10, 'icon' => '🧳'],
    'meal'          => ['label' => 'Paket Makanan Premium',  'price' => 8,  'icon' => '🍱'],
    'insurance'     => ['label' => 'Asuransi Perjalanan',    'price' => 7,  'icon' => '🛡️'],
    'lounge'        => ['label' => 'Akses Airport Lounge',   'price' => 15, 'icon' => '🛋️'],
    'priority_seat' => ['label' => 'Pilih Kursi Prioritas',  'price' => 5,  'icon' => '💺'],
    'fast_track'    => ['label' => 'Fast Track Security',    'price' => 12, 'icon' => '⚡'],
];

// ─── Payment Methods ──────────────────────────────────────
$paymentMethods = [
    'bank_bca'      => ['label'=>'Transfer Bank – BCA',        'icon'=>'🏦'],
    'bank_mandiri'  => ['label'=>'Transfer Bank – Mandiri',    'icon'=>'🏦'],
    'bank_bni'      => ['label'=>'Transfer Bank – BNI',        'icon'=>'🏦'],
    'bank_bri'      => ['label'=>'Transfer Bank – BRI',        'icon'=>'🏦'],
    'gopay'         => ['label'=>'GoPay',                      'icon'=>'💚'],
    'ovo'           => ['label'=>'OVO',                        'icon'=>'💜'],
    'dana'          => ['label'=>'DANA',                       'icon'=>'💙'],
    'bri_va'        => ['label'=>'BRI Virtual Account',        'icon'=>'🏧'],
    'cc_visa'       => ['label'=>'Kartu Kredit Visa',          'icon'=>'💳'],
    'cc_mc'         => ['label'=>'Kartu Kredit Mastercard',    'icon'=>'💳'],
    'alfamart'      => ['label'=>'Alfamart',                   'icon'=>'🏪'],
    'indomaret'     => ['label'=>'Indomaret',                  'icon'=>'🏪'],
    'paylater'      => ['label'=>'PayLater',                   'icon'=>'🔜'],
];

// ─── Dummy flight generator ───────────────────────────────
function getFlights($origin, $destination, $date, $class = 'Economy', $passengers = 1) {
    if ($origin === $destination) return [];
    srand(crc32($origin.$destination.$date)); // deterministic for same route/date
    $airlines = [
        ['name'=>'Sriwijaya Air', 'code'=>'SJ', 'logo'=>'🔵'],
        ['name'=>'Garuda Indonesia','code'=>'GA','logo'=>'🦅'],
        ['name'=>'Lion Air',      'code'=>'JT', 'logo'=>'🦁'],
        ['name'=>'Citilink',      'code'=>'QG', 'logo'=>'🟢'],
        ['name'=>'Batik Air',     'code'=>'ID', 'logo'=>'🎨'],
    ];
    $num = rand(3, 5);
    $flights = [];
    $usedTimes = [];
    for ($i = 0; $i < $num; $i++) {
        $air   = $airlines[$i % count($airlines)];
        $depH  = rand(5, 22);
        $depM  = [0,15,30,45][rand(0,3)];
        $dur   = rand(60, 240); // minutes
        $arrH  = floor(($depH * 60 + $depM + $dur) / 60) % 24;
        $arrM  = ($depH * 60 + $depM + $dur) % 60;
        $baseP = rand(45, 220);
        $price = ($class === 'Business') ? round($baseP * 2.8) : $baseP;
        $seats = rand(3, 30);
        $flights[] = [
            'id'          => uniqid('FL'),
            'airline'     => $air['name'],
            'airline_code'=> $air['code'],
            'logo'        => $air['logo'],
            'flight_num'  => $air['code'] . rand(100, 999),
            'departure'   => sprintf('%02d:%02d', $depH, $depM),
            'arrival'     => sprintf('%02d:%02d', $arrH, $arrM),
            'duration'    => sprintf('%dj %02dm', intdiv($dur,60), $dur%60),
            'price'       => $price,
            'seats_left'  => $seats,
            'origin'      => $origin,
            'destination' => $destination,
            'date'        => $date,
            'class'       => $class,
        ];
    }
    usort($flights, fn($a,$b) => $a['departure'] <=> $b['departure']);
    return $flights;
}

// ─── Helpers ─────────────────────────────────────────────
function checkLogin() {
    if (empty($_SESSION['logged_in'])) {
        header('Location: index.php'); exit;
    }
}

function stars($n) {
    return str_repeat('<span style="color:#F59E0B">★</span>', $n)
         . str_repeat('<span style="color:#D1D5DB">★</span>', 5-$n);
}

function formatRupiah($usd) {
    return 'Rp ' . number_format($usd * 16000, 0, ',', '.');
}

// ─── Init session defaults ────────────────────────────────
if (!isset($_SESSION['wishlist']))  $_SESSION['wishlist']  = [];
if (!isset($_SESSION['tickets']))   $_SESSION['tickets']   = [];
if (!isset($_SESSION['username']))  $_SESSION['username']  = 'Traveller';
if (!isset($_SESSION['email']))     $_SESSION['email']     = 'traveller@voyage.id';
if (!isset($_SESSION['phone']))     $_SESSION['phone']     = '+62 812 3456 7890';
if (!isset($_SESSION['avatar']))    $_SESSION['avatar']    = 'https://ui-avatars.com/api/?name=Traveller&background=003082&color=fff&size=128';

// ─── Common HTML snippets ─────────────────────────────────
function renderNav($active = 'home') {
    $items = [
        'home'    => ['href'=>'home.php',    'icon'=>'🏠', 'label'=>'Home'],
        'wishlist'=> ['href'=>'wishlist.php','icon'=>'❤️', 'label'=>'Wishlist'],
        'tickets' => ['href'=>'tickets.php', 'icon'=>'🎫', 'label'=>'Tiket'],
        'profile' => ['href'=>'profile.php', 'icon'=>'👤', 'label'=>'Profil'],
    ];
    echo '<nav class="bottom-nav">';
    foreach ($items as $key => $item) {
        $cls = ($key === $active) ? ' active' : '';
        echo "<a href='{$item['href']}' class='nav-item{$cls}'><span class='nav-icon'>{$item['icon']}</span><span>{$item['label']}</span></a>";
    }
    echo '</nav>';
}

function headHtml($title, $extra = '') {
    echo <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>{$title} – Sriwijaya Voyage</title>
<style>
:root{--primary:#003082;--accent:#E8151B;--bg:#F5F7FA;--white:#fff;--gray:#6B7280;--border:#E5E7EB;--shadow:0 2px 12px rgba(0,0,0,.07);}
*{margin:0;padding:0;box-sizing:border-box;-webkit-tap-highlight-color:transparent;}
body{background:var(--bg);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;padding-bottom:80px;color:#111827;}
a{text-decoration:none;color:inherit;}
img{display:block;width:100%;object-fit:cover;}
.container{max-width:500px;margin:0 auto;padding:0 16px;}
/* Buttons */
.btn{display:block;width:100%;padding:14px;border:none;border-radius:40px;font-size:15px;font-weight:600;cursor:pointer;text-align:center;transition:.15s;}
.btn-primary{background:var(--primary);color:#fff;}
.btn-primary:hover{background:#002060;}
.btn-accent{background:var(--accent);color:#fff;}
.btn-accent:hover{background:#c0121a;}
.btn-outline{background:#fff;color:var(--primary);border:2px solid var(--primary);}
.btn-sm{padding:8px 18px;font-size:13px;border-radius:40px;border:none;cursor:pointer;font-weight:600;}
/* Cards */
.card{background:#fff;border-radius:20px;padding:18px;margin-bottom:14px;border:1px solid var(--border);box-shadow:var(--shadow);}
/* Bottom Nav */
.bottom-nav{position:fixed;bottom:0;left:0;right:0;background:#fff;display:flex;justify-content:space-around;padding:10px 0 16px;border-top:1px solid var(--border);z-index:100;max-width:500px;margin:0 auto;}
.nav-item{display:flex;flex-direction:column;align-items:center;color:var(--gray);font-size:11px;gap:2px;}
.nav-item.active{color:var(--primary);}
.nav-icon{font-size:22px;}
/* Page header */
.page-header{background:#fff;padding:16px 16px 12px;display:flex;align-items:center;gap:12px;border-bottom:1px solid var(--border);margin-bottom:16px;position:sticky;top:0;z-index:50;}
.page-header h2{font-size:18px;font-weight:700;}
.back-btn{font-size:20px;cursor:pointer;color:var(--primary);}
/* Stars */
.stars span{font-size:13px;}
/* Badge */
.badge{display:inline-block;padding:3px 10px;border-radius:40px;font-size:11px;font-weight:600;}
.badge-primary{background:#EEF2FF;color:var(--primary);}
.badge-accent{background:#FEE2E2;color:var(--accent);}
/* Input */
.input-wrap{position:relative;margin-bottom:12px;}
.input-wrap input,.input-wrap select{width:100%;padding:13px 16px;border:1.5px solid var(--border);border-radius:14px;font-size:15px;outline:none;background:#fff;appearance:none;}
.input-wrap input:focus,.input-wrap select:focus{border-color:var(--primary);}
.input-wrap label{display:block;font-size:12px;font-weight:600;color:var(--gray);margin-bottom:4px;text-transform:uppercase;letter-spacing:.04em;}
/* Section titles */
.section-title{display:flex;justify-content:space-between;align-items:center;margin:20px 0 12px;}
.section-title h3{font-size:17px;font-weight:700;}
.section-title a{font-size:13px;color:var(--primary);font-weight:600;}
/* Toast */
#toast{position:fixed;bottom:90px;left:50%;transform:translateX(-50%);background:#1f2937;color:#fff;padding:10px 22px;border-radius:40px;font-size:13px;z-index:999;opacity:0;transition:.3s;white-space:nowrap;}
/* Modal */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:200;justify-content:center;align-items:flex-end;}
.modal-overlay.open{display:flex;}
.modal-box{background:#fff;border-radius:28px 28px 0 0;padding:28px 20px 36px;width:100%;max-width:500px;}
{$extra}
</style>
HTML;
}
?>