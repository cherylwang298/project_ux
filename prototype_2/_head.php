<?php
/* ============================================
   AGODA CLONE — _head.php
   Shared head, nav, header helpers
   ============================================ */

$font = '<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Nunito+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">';
$css  = '<link rel="stylesheet" href="assets/style.css">';
$js   = '<script src="assets/app.js" defer></script>';

function nav($active=''){
  $pages=[
    'index'  =>['Home', '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>', 'index.php'],
    'orders' =>['My Orders', '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>', 'orders.php'],
    'profile'=>['Profile',  '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>','profile.php'],
  ];
  $html='<nav class="bottom-nav">';
  foreach($pages as $k=>$v){
    $cls='nav-item'.($k===$active?' active':'');
    $html.='<a href="'.$v[2].'" class="'.$cls.'">';
    $html.='<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">'.$v[1].'</svg>';
    $html.='<span>'.$v[0].'</span></a>';
  }
  $html.='</nav>';
  return $html;
}

function header_bar($title='',$back=''){
  $back_btn = $back
    ? '<a href="'.$back.'" class="hb-back">←</a>'
    : '<div style="width:38px"></div>';
  $center = $title
    ? '<span class="hb-title">'.htmlspecialchars($title).'</span>'
    : '<div class="logo"><div class="logo-mark">a</div><span class="logo-text">agoda</span></div>';
  return '<header class="app-header"><div class="header-inner">'.$back_btn.$center.'<div style="width:38px"></div></div></header>';
}

// Date validation helper
function min_date() {
  return date('Y-m-d');
}

function min_checkout($checkin) {
  return date('Y-m-d', strtotime($checkin . ' +1 day'));
}
?>