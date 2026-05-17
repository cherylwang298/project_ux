<?php
$font = '<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">';
$css  = '<link rel="stylesheet" href="assets/style.css">';
function nav($active=''){
  $pages=['index'=>['Beranda','<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>','index.php'],
          'search'=>['Cari','<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>','results.php'],
          'orders'=>['Pesanan','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>','orders.php'],
          'profile'=>['Profil','<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>','profile.php']];
  $html='<nav class="bottom-nav">';
  foreach($pages as $k=>$v){
    $cls='nav-item'.($k===$active?' active':'');
    $html.='<a href="'.$v[2].'" class="'.$cls.'"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">'.$v[1].'</svg>'.$v[0].'</a>';
  }
  $html.='</nav>';
  return $html;
}
function header_bar($title='',$back=''){
  $back_btn = $back ? '<a href="'.$back.'" class="back-btn" style="position:static;width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.8);backdrop-filter:blur(12px);color:var(--c-text);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;box-shadow:var(--sh-sm);flex-shrink:0;">←</a>' : '<div style="width:36px"></div>';
  $logo = !$back ? '<div class="logo"><div class="logo-mark">S</div><span class="logo-text">StayEase</span></div>' : '<span style="font-size:15px;font-weight:700;letter-spacing:-0.3px;">'.htmlspecialchars($title).'</span>';
  return '<header class="app-header"><div class="header-inner">'.$back_btn.$logo.'<div style="width:36px"></div></div></header>';
}
