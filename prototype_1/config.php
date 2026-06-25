<?php
// ═══════════════════════════════════════════════════════════════
// config.php — StayGo Shared Configuration (No-DB Version)
// ═══════════════════════════════════════════════════════════════

require_once __DIR__ . '/data.php';

define('SITE_NAME', 'StayGo');
define('SITE_URL',  'http://localhost/staygo');

// ── Session ──────────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) session_start();

// Seed demo data on first run
if (!isset($_SESSION['_seeded'])) {
    global $DEMO_BOOKINGS, $DEMO_FAVOURITES;
    $_SESSION['bookings']   = $DEMO_BOOKINGS;
    $_SESSION['favourites'] = $DEMO_FAVOURITES;
    $_SESSION['_seeded']    = true;
}

function auth(): ?array { return $_SESSION['user'] ?? null; }

function requireAuth(string $r='login.php'): void {
    if (!auth()) { header("Location:$r"); exit; }
}

function requireAdmin(): void {
    $u = auth();
    if (!$u || $u['role'] !== 'admin') { header('Location:home.php'); exit; }
}

// ── Data Access ──────────────────────────────────────────────────
function getProperty(int $id): ?array {
    global $PROPERTIES;
    return $PROPERTIES[$id] ?? null;
}

function getProperties(?string $type=null, bool $featuredOnly=false): array {
    global $PROPERTIES;
    return array_values(array_filter($PROPERTIES, function($p) use($type,$featuredOnly){
        if ($type && $p['type'] !== $type) return false;
        if ($featuredOnly && !$p['featured']) return false;
        return true;
    }));
}



function getPropertieses(?string $type=null, bool $featuredOnly=false): array {
    return getProperties($type, $featuredOnly);
}

function getFlight(int $id): ?array {
    global $FLIGHTS;
    return $FLIGHTS[$id] ?? null;
}

function getFlights(?string $from=null, ?string $to=null): array {
    global $FLIGHTS;
    return array_values(array_filter($FLIGHTS, function($f) use($from,$to){
        if ($from && strtolower($f['from_city']) !== strtolower($from) && strtolower($f['from_code']) !== strtoupper($from)) return false;
        if ($to   && strtolower($f['to_city'])   !== strtolower($to)   && strtolower($f['to_code'])   !== strtoupper($to))   return false;
        return true;
    }));
}

function getPromos(): array {
    global $PROMOS;
    $today = date('Y-m-d');
    return array_values(array_filter($PROMOS, fn($p)=>$p['active'] && $p['valid_until']>=$today && $p['used_count']<$p['max_uses']));
}

function getPromoByCode(string $code): ?array {
    global $PROMOS;
    $code = strtoupper(trim($code));
    $today = date('Y-m-d');
    $p = $PROMOS[$code] ?? null;
    if (!$p || !$p['active'] || $p['valid_until'] < $today || $p['used_count'] >= $p['max_uses']) return null;
    return $p;
}

function getUsers(): array {
    global $USERS;
    return $USERS;
}

function getUserById(int $id): ?array {
    global $USERS;
    return $USERS[$id] ?? null;
}



// ── Saved Guest / Passenger Profiles (session based) ─────────────
function getGuestProfiles(?int $userId=null): array {
    $uid = $userId ?? (auth()['id'] ?? 0);
    if (!$uid) return [];
    $profiles = $_SESSION['guest_profiles'][$uid] ?? [];
    $user = getUserById($uid);
    if ($user) {
        $own = ['name'=>$user['name'],'email'=>$user['email'],'phone'=>$user['phone'] ?? ''];
        array_unshift($profiles, $own);
    }
    $seen=[]; $out=[];
    foreach($profiles as $pr){
        $name=trim((string)($pr['name']??'')); $email=trim((string)($pr['email']??'')); $phone=trim((string)($pr['phone']??''));
        if(!$name && !$email && !$phone) continue;
        $key=strtolower($email).'|'.preg_replace('/\D+/','',$phone).'|'.strtolower($name);
        if(isset($seen[$key])) continue;
        $seen[$key]=1; $out[]=['name'=>$name,'email'=>$email,'phone'=>$phone];
    }
    return $out;
}

function saveGuestProfile(array $profile, ?int $userId=null): void {
    $uid = $userId ?? (auth()['id'] ?? 0);
    if (!$uid) return;
    $name=trim((string)($profile['name']??'')); $email=trim((string)($profile['email']??'')); $phone=trim((string)($profile['phone']??''));
    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$phone) return;
    if (!isset($_SESSION['guest_profiles'][$uid])) $_SESSION['guest_profiles'][$uid]=[];
    $new=['name'=>$name,'email'=>$email,'phone'=>$phone];
    $key=strtolower($email).'|'.preg_replace('/\D+/','',$phone);
    $_SESSION['guest_profiles'][$uid]=array_values(array_filter($_SESSION['guest_profiles'][$uid], function($pr) use($key){
        return strtolower($pr['email']??'').'|'.preg_replace('/\D+/','',$pr['phone']??'') !== $key;
    }));
    array_unshift($_SESSION['guest_profiles'][$uid], $new);
    $_SESSION['guest_profiles'][$uid]=array_slice($_SESSION['guest_profiles'][$uid],0,12);
}

function scalarParam(string $name, string $default=''): string {
    $v = $_GET[$name] ?? $default;
    if (is_array($v)) $v = reset($v);
    return trim((string)$v);
}

function getUserByEmail(string $email): ?array {
    global $USERS;
    foreach ($USERS as $u) {
        if (strtolower($u['email']) === strtolower($email)) return $u;
    }
    return null;
}

// ── Session-Based Bookings ───────────────────────────────────────
function getAllBookings(): array {
    return $_SESSION['bookings'] ?? [];
}

function getUserBookings(int $userId): array {
    return array_values(array_filter($_SESSION['bookings'] ?? [], fn($b)=>$b['user_id']==$userId));
}

function getBookingByRef(string $ref): ?array {
    return ($_SESSION['bookings'] ?? [])[$ref] ?? null;
}

function saveBooking(array $booking): void {
    $_SESSION['bookings'][$booking['booking_ref']] = $booking;
}

function updateBookingStatus(string $ref, string $status): bool {
    if (!isset($_SESSION['bookings'][$ref])) return false;
    $_SESSION['bookings'][$ref]['status'] = $status;
    return true;
}

// ── Session-Based Favourites ─────────────────────────────────────
function isFavourited(int $propertyId): bool {
    $user = auth();
    if (!$user) return false;
    return in_array($propertyId, $_SESSION['favourites'][$user['id']] ?? []);
}

function toggleFav(int $propertyId): bool {
    $user = auth();
    if (!$user) return false;
    $uid  = $user['id'];
    $favs = $_SESSION['favourites'][$uid] ?? [];
    $key  = array_search($propertyId, $favs);
    if ($key !== false) {
        unset($favs[$key]);
        $_SESSION['favourites'][$uid] = array_values($favs);
        return false; // now unfavourited
    } else {
        $favs[] = $propertyId;
        $_SESSION['favourites'][$uid] = $favs;
        return true;  // now favourited
    }
}

function getUserFavourites(?int $userId=null): array {
    $uid = $userId ?? (auth()['id'] ?? 0);
    if (!$uid) return [];
    $ids = $_SESSION['favourites'][$uid] ?? [];
    return array_values(array_filter(array_map(fn($id)=>getProperty($id), $ids)));
}

// ── Helpers ──────────────────────────────────────────────────────
function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function formatRupiah(float $n): string { return 'Rp '.number_format($n,0,',','.'); }

function generateRef(string $prefix): string {
    return strtoupper($prefix).'-'.strtoupper(substr(md5(uniqid(rand(),true)),0,6)).'-'.date('Y');
}

function flashSet(string $type, string $msg): void { $_SESSION['flash']=compact('type','msg'); }

function flashGet(): ?array {
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function daysLeft(string $date): int {
    return max(0, (int)ceil((strtotime($date) - time()) / 86400));
}

// ── Admin Stats (computed) ───────────────────────────────────────
function getStats(): array {
    global $USERS, $PROPERTIES, $FLIGHTS;
    $bookings = getAllBookings();
    $revenue  = array_sum(array_column(array_filter($bookings, fn($b)=>$b['status']!=='cancelled'),'total_amount'));
    $active   = count(array_filter($bookings, fn($b)=>$b['status']==='confirmed'));
    return [
        'total_users'      => count($USERS),
        'total_bookings'   => count($bookings),
        'active_bookings'  => $active,
        'total_revenue'    => $revenue,
        'total_properties' => count($PROPERTIES),
        'total_flights'    => count($FLIGHTS),
    ];
}

// ── Shared Tailwind Config ───────────────────────────────────────
function twConfig(): string { return <<<JS
tailwind.config={darkMode:"class",theme:{extend:{colors:{"on-tertiary-fixed":"#141d21","surface-container":"#e7eeff","on-surface":"#111c2d","primary-fixed":"#dce1ff","surface-dim":"#cfdaf2","on-primary":"#ffffff","error-container":"#ffdad6","outline-variant":"#c3c5d8","on-secondary":"#ffffff","on-primary-container":"#fffbff","on-error":"#ffffff","primary-fixed-dim":"#b6c4ff","inverse-primary":"#b6c4ff","on-primary-fixed-variant":"#003ab2","surface-container-high":"#dee8ff","on-primary-fixed":"#001550","primary-container":"#3267ff","on-secondary-fixed-variant":"#004e60","on-error-container":"#93000a","outline":"#737687","on-tertiary-container":"#fbfdff","surface-tint":"#004ee8","surface-container-lowest":"#ffffff","on-secondary-container":"#00566a","on-surface-variant":"#434655","inverse-on-surface":"#ecf1ff","secondary-fixed-dim":"#47d6ff","tertiary-container":"#6d767b","error":"#ba1a1a","surface":"#f9f9ff","secondary-fixed":"#b6ebff","on-secondary-fixed":"#001f28","surface-bright":"#f9f9ff","tertiary-fixed":"#dbe4ea","secondary":"#00677f","on-tertiary":"#ffffff","surface-container-low":"#f0f3ff","background":"#f9f9ff","tertiary":"#545d62","surface-variant":"#d8e3fb","secondary-container":"#00d2ff","primary":"#004ce2","on-background":"#111c2d","surface-container-highest":"#d8e3fb","inverse-surface":"#263143"},"borderRadius":{"DEFAULT":"1rem","lg":"2rem","xl":"3rem","full":"9999px"},"spacing":{"gutter":"24px","margin-mobile":"20px","container-max":"1280px","base":"8px","margin-desktop":"64px"},"fontFamily":{"headline-md":["Plus Jakarta Sans"],"body-md":["Plus Jakarta Sans"],"body-lg":["Plus Jakarta Sans"],"label-sm":["Plus Jakarta Sans"],"display":["Plus Jakarta Sans"],"headline-lg":["Plus Jakarta Sans"],"headline-lg-mobile":["Plus Jakarta Sans"],"label-md":["Plus Jakarta Sans"]},"fontSize":{"headline-md":["24px",{"lineHeight":"1.3","fontWeight":"600"}],"body-md":["16px",{"lineHeight":"1.5","fontWeight":"400"}],"body-lg":["18px",{"lineHeight":"1.6","fontWeight":"400"}],"label-sm":["12px",{"lineHeight":"1.2","fontWeight":"700"}],"display":["56px",{"lineHeight":"1.1","letterSpacing":"-0.02em","fontWeight":"800"}],"headline-lg":["40px",{"lineHeight":"1.2","letterSpacing":"-0.01em","fontWeight":"700"}],"headline-lg-mobile":["32px",{"lineHeight":"1.2","fontWeight":"700"}],"label-md":["14px",{"lineHeight":"1.2","letterSpacing":"0.02em","fontWeight":"600"}]}}}}
JS; }

$GLOBALS['TW_INLINE'] = twConfig();

// ── Shared HTML Head ─────────────────────────────────────────────
function htmlHead(string $title, string $css=''): string {
    $tw = $GLOBALS['TW_INLINE'];
    return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{$title} — StayGo</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>{$tw}</script>
<style>
*{box-sizing:border-box}
body{font-family:'Plus Jakarta Sans',sans-serif;-webkit-font-smoothing:antialiased}
.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;line-height:1}
.icon-fill{font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24}
.glass{background:rgba(255,255,255,.68);backdrop-filter:blur(26px);-webkit-backdrop-filter:blur(26px);border:1px solid rgba(255,255,255,.55);box-shadow:0 20px 44px -16px rgba(17,28,45,.22)}
.prop-card,.flight-card,.glass-card,.bk-card,.promo-card,.admin-card,.ticket{background:linear-gradient(145deg,rgba(255,255,255,.72),rgba(255,255,255,.46))!important;backdrop-filter:blur(28px)!important;-webkit-backdrop-filter:blur(28px)!important;border:1px solid rgba(255,255,255,.62)!important;box-shadow:0 18px 45px -22px rgba(17,28,45,.35),inset 0 1px 0 rgba(255,255,255,.65)!important}
.prop-card:hover,.flight-card:hover,.glass-card:hover,.bk-card:hover,.promo-card:hover{transform:translateY(-4px);box-shadow:0 24px 60px -24px rgba(0,76,226,.34),inset 0 1px 0 rgba(255,255,255,.75)!important;border-color:rgba(255,255,255,.8)!important}
.glass-dark{background:rgba(17,28,45,.72);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.08)}
.hide-scroll::-webkit-scrollbar{display:none}.hide-scroll{-ms-overflow-style:none;scrollbar-width:none}
@keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes scaleIn{from{opacity:0;transform:scale(.95)}to{opacity:1;transform:scale(1)}}
@keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
@keyframes bgDrift{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(15px,-15px) scale(1.04)}}
.anim-fade-up{animation:fadeUp .5s cubic-bezier(.22,1,.36,1) both}
.anim-fade-in{animation:fadeIn .4s ease both}
.anim-scale{animation:scaleIn .4s cubic-bezier(.22,1,.36,1) both}
.anim-float{animation:float 3s ease-in-out infinite}
.bg-drift{animation:bgDrift 12s ease-in-out infinite}
.delay-100{animation-delay:.1s}.delay-200{animation-delay:.2s}.delay-300{animation-delay:.3s}.delay-400{animation-delay:.4s}.delay-500{animation-delay:.5s}
.skeleton{background:linear-gradient(90deg,#e7eeff 25%,#f0f3ff 50%,#e7eeff 75%);background-size:200% 100%;animation:shimmer 1.4s infinite}
::-webkit-scrollbar{width:6px;height:6px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:#c3c5d8;border-radius:999px}

.price-row{display:flex;align-items:baseline;gap:5px;white-space:nowrap}.price-row .price{font-size:22px;font-weight:800;line-height:1}.price-row .unit{font-size:13px;color:#737687;font-weight:700}.card-hotel .price,.hotel-accent{color:#004ce2!important}.card-villa .price,.villa-accent{color:#00b8d9!important}.card-hotel .view-btn{background:linear-gradient(135deg,#004ce2,#3267ff)!important;color:#fff!important}.card-villa .view-btn{background:linear-gradient(135deg,#00a8d8,#00d2ff)!important;color:#fff!important}.view-btn{box-shadow:0 10px 24px rgba(0,76,226,.18);transition:all .22s ease}.view-btn:hover{opacity:.94;transform:translateY(-1px)}
{$css}
</style>
HTML;
}

// ── Shared Navbar ─────────────────────────────────────────────────
function navbar(string $active=''): string {
    $user  = auth();
    $uName = $user ? h($user['name']) : '';
    $links = '';
    
    // Menu utama di tengah
    foreach ([
        ['home.php','Home','home'],
        ['detail_hotel.php','Accommodations','hotel'],
        ['flight.php','Flights','flight'],
        ['promo.php','Deals','local_offer'],
        ['riwayat.php','My Bookings','book_online'],
    ] as [$href,$label,$icon]) {
        if ($active===$href) {
            $cls = "text-primary font-bold px-3 py-1.5 rounded-full text-sm transition-all";
            $style = "style=\"background:rgba(0,76,226,.08);border:1.5px solid rgba(0,76,226,.15);\"";
        } else {
            $cls = "text-on-surface-variant hover:text-primary text-sm px-3 py-1.5 rounded-full transition-all hover:bg-white/50";
            $style = "style=\"\"";
        }
        $links .= "<a href='{$href}' {$style} class='flex items-center gap-1.5 {$cls}'>{$label}</a>";
    }

    // Kondisional style untuk tombol Favourites di sebelah kanan
    if ($active === 'favourites.php') {
        $favClass = "text-primary font-bold bg-[rgba(0,76,226,.08)] border border-[rgba(0,76,226,.15)]";
    } else {
        $favClass = "text-on-surface-variant hover:text-primary hover:bg-white/50";
    }

    $mobileAuthHtml = $user
        ? "<a href='logout.php' class='flex items-center gap-2 text-sm text-error py-2'>Sign Out</a>"
        : "<a href='login.php' class='flex items-center gap-2 text-sm text-primary py-2 font-bold'>Sign In</a>";

    $authHtml = $user
        ? "<div class='flex items-center gap-3 pl-4 border-l border-outline-variant/30'>
            <div class='hidden sm:block text-right'>
                <p class='text-sm font-bold text-on-surface leading-tight'>{$uName}</p>
                <p class='text-xs text-outline'>".ucfirst($user['role'])."</p>
            </div>
            <div class='relative group'>
                <button class='w-10 h-10 rounded-full bg-primary-fixed border-2 border-primary/20 hover:border-primary flex items-center justify-center text-primary font-bold text-sm transition-all'>".strtoupper(substr($user['name'],0,1))."</button>
                <div class='absolute right-0 top-12 w-48 glass rounded-xl shadow-xl z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200'>
                    <div class='p-2'>
                        ".($user['role']==='admin'?"<a href='admin.php' class='flex items-center gap-2 px-3 py-2.5 text-sm text-on-surface hover:bg-surface-container rounded-lg transition-colors'><span class='material-symbols-outlined text-[18px]'>admin_panel_settings</span>Admin Panel</a>":'')."
                        <a href='riwayat.php' class='flex items-center gap-2 px-3 py-2.5 text-sm text-on-surface hover:bg-surface-container rounded-lg transition-colors'><span class='material-symbols-outlined text-[18px]'>history</span>My Bookings</a>
                        <a href='favourites.php' class='flex items-center gap-2 px-3 py-2.5 text-sm text-on-surface hover:bg-surface-container rounded-lg transition-colors'><span class='material-symbols-outlined text-[18px]'>favorite</span>Favourites</a>
                        <hr class='my-1 border-outline-variant/30'>
                        <a href='logout.php' class='flex items-center gap-2 px-3 py-2.5 text-sm text-error hover:bg-error-container/30 rounded-lg transition-colors'><span class='material-symbols-outlined text-[18px]'>logout</span>Sign Out</a>
                    </div>
                </div>
            </div>
           </div>"
        : "<div class='flex items-center gap-3'>
               <a href='login.php' class='text-sm font-bold text-primary hover:opacity-80 transition-opacity'>Sign In</a>
               <a href='daftar_akun.php' class='px-4 py-2 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary/90 transition-colors'>Sign Up</a>
           </div>";

    return <<<HTML
<nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300" style="background:rgba(249,249,255,.85);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(195,197,216,.3)">
  <div class="max-w-[1280px] mx-auto px-5 md:px-16 flex justify-between items-center h-20">
    <a href="home.php" class="flex items-center gap-2 group">
      <span class="material-symbols-outlined text-primary text-3xl icon-fill" style="font-variation-settings:'FILL' 1,'wght' 700">flight_takeoff</span>
      <span class="text-2xl font-extrabold tracking-tight text-on-surface group-hover:text-primary transition-colors">Stay<span class="text-primary">Go</span></span>
    </a>
    <div class="hidden md:flex items-center gap-6">{$links}</div>
    <div class="flex items-center gap-2">
      <a href="favourites.php" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition-all text-sm font-semibold {$favClass}">
        <span class="material-symbols-outlined" style="font-size:18px;line-height:1;position:relative;top:1px">favorite</span>
        <span class="hidden md:inline" style="position:relative;top:0px">Favourites</span>
      </a>
      {$authHtml}
      <button id="mobileBtn" class="md:hidden w-10 h-10 flex items-center justify-center text-on-surface-variant rounded-full">
        <span class="material-symbols-outlined">menu</span>
      </button>
    </div>
  </div>
  <div id="mobileMenu" class="md:hidden hidden glass border-t border-white/30">
    <div class="px-5 py-4 space-y-1">{$links}
      <hr class="border-outline-variant/30 my-2">
      {$mobileAuthHtml}
    </div>
  </div>
</nav>
<script>
document.getElementById('mobileBtn').onclick=()=>document.getElementById('mobileMenu').classList.toggle('hidden');
window.addEventListener('scroll',()=>{const n=document.getElementById('navbar');n.style.boxShadow=window.scrollY>20?'0 4px 24px rgba(0,76,226,.08)':'none';});
</script>
HTML;
}

// ── Flash Messages ────────────────────────────────────────────────
function renderFlash(): string {
    $f = flashGet();
    if (!$f) return '';
    $map=['success'=>['bg-green-50 border-green-400 text-green-800','check_circle'],'error'=>['bg-error-container border-error text-on-error-container','error'],'info'=>['bg-primary-fixed border-primary text-primary','info']];
    [$cls,$icon]=$map[$f['type']]??$map['info'];
    return "<div class='fixed top-24 right-5 z-[999] max-w-sm glass border {$cls} px-5 py-4 rounded-xl flex items-center gap-3 anim-fade-up shadow-lg' id='flash'>
        <span class='material-symbols-outlined icon-fill text-[22px]'>{$icon}</span>
        <p class='text-sm font-semibold flex-1'>".h($f['msg'])."</p>
        <button onclick=\"document.getElementById('flash').remove()\" class='opacity-60 hover:opacity-100'><span class='material-symbols-outlined text-[18px]'>close</span></button>
    </div><script>setTimeout(()=>{const e=document.getElementById('flash');if(e)e.remove()},4000)<\/script>";
}



function backButton(string $fallback = 'home.php'): string {
    $fallback = h($fallback);
    return '
    <div class="fixed top-24 left-5 md:left-10 z-40 no-print">
      <button type="button" onclick="if(history.length>1){history.back()}else{window.location.href=\''.$fallback.'\'}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/82 backdrop-blur-xl border border-white/70 shadow-lg text-primary font-bold text-sm hover:bg-primary hover:text-white transition-all">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>Back
      </button>
    </div>';
}

// ── Footer ─────────────────────────────────────────────────────────
function footer(): string {
    return <<<HTML
<footer class="bg-inverse-surface text-inverse-on-surface mt-24">
  <div class="max-w-[1280px] mx-auto px-5 md:px-16 py-16 grid grid-cols-1 md:grid-cols-4 gap-10">
    <div class="md:col-span-2">
      <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-primary-fixed text-3xl" style="font-variation-settings:'FILL' 1,'wght' 700">flight_takeoff</span>
        <span class="text-2xl font-extrabold tracking-tight">Stay<span class="text-primary-fixed">Go</span></span>
      </div>
      <p class="text-sm text-outline leading-relaxed max-w-xs">Your atmospheric travel companion. Discover curated hotels, private villas, and seamless flights across Indonesia and beyond.</p>
    </div>
    <div>
      <h4 class="text-sm font-bold mb-4">Explore</h4>
      <ul class="space-y-2 text-sm text-outline">
        <li><a href="detail_hotel.php" class="hover:text-primary-fixed transition-colors">Hotels</a></li>
        <li><a href="detail_villa.php" class="hover:text-primary-fixed transition-colors">Villas</a></li>
        <li><a href="flight.php" class="hover:text-primary-fixed transition-colors">Flights</a></li>
        <li><a href="promo.php" class="hover:text-primary-fixed transition-colors">Deals & Promos</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-sm font-bold mb-4">Account</h4>
      <ul class="space-y-2 text-sm text-outline">
        <li><a href="login.php" class="hover:text-primary-fixed transition-colors">Sign In</a></li>
        <li><a href="daftar_akun.php" class="hover:text-primary-fixed transition-colors">Create Account</a></li>
        <li><a href="riwayat.php" class="hover:text-primary-fixed transition-colors">My Bookings</a></li>
        <li><a href="favourites.php" class="hover:text-primary-fixed transition-colors">Favourites</a></li>
      </ul>
    </div>
  </div>
  <div class="border-t border-white/10 px-5 md:px-16 py-5 flex flex-col md:flex-row justify-between items-center gap-3">
    <p class="text-xs text-outline">© 2025 StayGo. All rights reserved.</p>
    <p class="text-xs text-outline">No-DB Edition — Data in PHP arrays</p>
  </div>
</footer>
HTML;
}