<?php
require 'config.php';
requireAdmin();

// Handle status update
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (isset($_POST['update_status'])) {
        updateBookingStatus($_POST['ref'], $_POST['status']);
        flashSet('success','Status booking diperbarui.');
    }
    if (isset($_POST['delete_booking'])) {
        if (isset($_SESSION['bookings'][$_POST['ref']])) {
            unset($_SESSION['bookings'][$_POST['ref']]);
            flashSet('success','Booking dihapus.');
        }
    }
    header('Location: admin.php?tab='.($_GET['tab']??'overview')); exit;
}

$tab      = $_GET['tab'] ?? 'overview';
$stats    = getStats();
$bookings = getAllBookings();
$users    = getUsers();
$props    = getProperties();

// Monthly revenue (last 6 months, simulated from booking dates)
$months=[];
for($i=5;$i>=0;$i--){
    $m=date('M Y',strtotime("-{$i} months"));
    $months[$m]=0;
}
foreach($bookings as $b){
    if($b['status']==='cancelled') continue;
    $m=date('M Y',strtotime($b['created_at']));
    if(isset($months[$m])) $months[$m]+=$b['total_amount'];
}
$maxRev = max(1,max($months));

// By type
$byType=['hotel'=>0,'villa'=>0,'flight'=>0];
foreach($bookings as $b){if(isset($byType[$b['booking_type']]))$byType[$b['booking_type']]++;}

$statusColors=['confirmed'=>'text-green-700 bg-green-100','pending'=>'text-amber-700 bg-amber-100','completed'=>'text-blue-700 bg-blue-100','cancelled'=>'text-red-700 bg-red-100'];
$typeIcon=['hotel'=>'hotel','villa'=>'villa','flight'=>'flight'];
$payL=['bank_transfer'=>'Bank Transfer','gopay'=>'GoPay','ovo'=>'OVO','qris'=>'QRIS','credit_card'=>'Credit Card'];

echo htmlHead("Admin Dashboard", <<<CSS
.sidebar-link{transition:all .2s ease;border-radius:12px;padding:10px 14px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:600;color:rgba(17,28,45,.6)}
.sidebar-link.active,.sidebar-link:hover{background:rgba(0,76,226,.08);color:#004ce2}
.admin-card{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.45);box-shadow:0 4px 20px rgba(0,76,226,.06)}
.bar-col{border-radius:6px 6px 0 0;transition:height .8s cubic-bezier(.22,1,.36,1);background:linear-gradient(to top,#004ce2,#00d2ff)}
CSS
);
?>
<body class="bg-surface-container-low text-on-background min-h-screen">
<?= navbar('admin.php') ?><?= renderFlash() ?>

<div class="pt-20 max-w-[1440px] mx-auto px-5 md:px-8 py-6">
  <div class="flex gap-6 items-start">

    <!-- Sidebar -->
    <aside class="hidden md:block w-56 shrink-0 sticky top-24">
      <div class="admin-card rounded-2xl p-4">
        <div class="flex items-center gap-2 mb-5 px-2">
          <span class="material-symbols-outlined text-primary text-2xl icon-fill" style="font-variation-settings:'FILL' 1,'wght' 700">admin_panel_settings</span>
          <span class="font-extrabold text-on-surface text-sm">Admin Panel</span>
        </div>
        <?php foreach([
          ['overview','Dashboard','space_dashboard'],
          ['bookings','Bookings','book_online'],
          ['users','Users','group'],
          ['properties','Propertieses','home'],
        ] as [$t,$l,$icon]): ?>
        <a href="?tab=<?= $t ?>" class="sidebar-link mb-1 <?= $tab===$t?'active':'' ?>">
          <span class="material-symbols-outlined text-[18px]"><?= $icon ?></span><?= $l ?>
        </a>
        <?php endforeach; ?>
        <hr class="my-3 border-outline-variant/30">
        <a href="home.php" class="sidebar-link text-outline">
          <span class="material-symbols-outlined text-[18px]">open_in_new</span>View Site
        </a>
        <a href="logout.php" class="sidebar-link text-error hover:bg-error-container/30 hover:!text-error">
          <span class="material-symbols-outlined text-[18px]">logout</span>Sign Out
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 min-w-0 mt-6">
      <!-- Mobile Tab Bar -->
      <div class="flex md:hidden gap-1 mb-5 admin-card rounded-2xl p-2">
        <?php foreach([['overview','Dashboard','space_dashboard'],['bookings','Bookings','book_online'],['users','Users','group'],['properties','Propertieses','home']] as [$t,$l,$icon]): ?>
        <a href="?tab=<?= $t ?>" class="flex-1 flex flex-col items-center gap-0.5 py-2 rounded-xl text-[10px] font-bold transition-all <?= $tab===$t?'bg-primary text-white':'text-outline' ?>">
          <span class="material-symbols-outlined text-[18px]"><?= $icon ?></span><?= $l ?>
        </a>
        <?php endforeach; ?>
      </div>

      <?php if ($tab==='overview'): ?>
      <!-- ── OVERVIEW ───────────────────────────────────────────── -->
      <div class="space-y-6">
        <!-- Stats grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 anim-fade-up">
          <?php foreach([
            ['Total Revenue',formatRupiah($stats['total_revenue']),'payments','primary'],
            ['Total Bookings',$stats['total_bookings'],'book_online','primary'],
            ['Active Bookings',$stats['active_bookings'],'check_circle','green-600'],
            ['Total Users',$stats['total_users'],'group','secondary'],
          ] as [$l,$v,$icon,$c]): ?>
          <div class="admin-card rounded-2xl p-5">
            <span class="material-symbols-outlined text-<?= $c ?> text-2xl mb-2 block icon-fill"><?= $icon ?></span>
            <p class="text-xl font-extrabold text-on-surface"><?= $v ?></p>
            <p class="text-xs text-outline mt-0.5"><?= $l ?></p>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Bar chart: Monthly revenue -->
          <div class="admin-card rounded-2xl p-5 md:col-span-2 anim-fade-up delay-100">
            <h3 class="font-bold text-on-surface mb-4">Revenue 6 Bulan Terakhir</h3>
            <div class="flex items-end gap-2 h-36">
              <?php foreach($months as $m=>$rev): ?>
              <div class="flex-1 flex flex-col items-center gap-1">
                <div class="w-full bar-col" style="height:0" data-h="<?= $maxRev>0?round($rev/$maxRev*100):0 ?>%"></div>
                <p class="text-[9px] text-outline font-semibold"><?= substr($m,0,3) ?></p>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <!-- Booking by type -->
          <div class="admin-card rounded-2xl p-5 anim-fade-up delay-200">
            <h3 class="font-bold text-on-surface mb-4">Distribusi Tipe</h3>
            <div class="space-y-3">
              <?php $total=max(1,array_sum($byType));foreach($byType as $t=>$n): ?>
              <div>
                <div class="flex justify-between text-xs mb-1 font-semibold text-on-surface-variant">
                  <span class="capitalize flex items-center gap-1"><span class="material-symbols-outlined text-[13px] text-primary"><?= $typeIcon[$t] ?></span><?= $t ?></span>
                  <span><?= $n ?> (<?= round($n/$total*100) ?>%)</span>
                </div>
                <div class="h-2 bg-surface-container-high rounded-full overflow-hidden">
                  <div class="h-full bg-primary rounded-full" style="width:<?= round($n/$total*100) ?>%"></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Recent bookings -->
        <div class="admin-card rounded-2xl overflow-hidden anim-fade-up delay-300">
          <div class="p-5 border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="font-bold text-on-surface">Booking Terbaru</h3>
            <a href="?tab=bookings" class="text-xs text-primary font-bold hover:opacity-75">Lihat All →</a>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead><tr class="bg-surface-container-low/60">
                <th class="text-left p-4 text-xs font-bold text-outline uppercase">Ref</th>
                <th class="text-left p-4 text-xs font-bold text-outline uppercase">Guests</th>
                <th class="text-left p-4 text-xs font-bold text-outline uppercase">Tipe</th>
                <th class="text-left p-4 text-xs font-bold text-outline uppercase">Total</th>
                <th class="text-left p-4 text-xs font-bold text-outline uppercase">Status</th>
              </tr></thead>
              <tbody>
                <?php foreach(array_slice(array_reverse(array_values($bookings)),0,5) as $b): $sc=$statusColors[$b['status']]??'text-outline bg-surface-container'; ?>
                <tr class="border-t border-outline-variant/20 hover:bg-surface-container/40 transition-colors">
                  <td class="p-4 font-mono text-xs font-bold text-primary"><?= h($b['booking_ref']) ?></td>
                  <td class="p-4 text-on-surface"><?= h($b['guest_name']) ?></td>
                  <td class="p-4"><span class="flex items-center gap-1 text-on-surface-variant"><span class="material-symbols-outlined text-[14px]"><?= $typeIcon[$b['booking_type']]??'book_online' ?></span><?= ucfirst($b['booking_type']) ?></span></td>
                  <td class="p-4 font-bold text-primary"><?= formatRupiah($b['total_amount']) ?></td>
                  <td class="p-4"><span class="px-2.5 py-1 rounded-full text-xs font-bold <?= $sc ?>"><?= ucfirst($b['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <?php elseif($tab==='bookings'): ?>
      <!-- ── BOOKINGS ───────────────────────────────────────────── -->
      <div class="admin-card rounded-2xl overflow-hidden anim-fade-up">
        <div class="p-5 border-b border-outline-variant/30">
          <h3 class="font-bold text-on-surface">All Booking (<?= count($bookings) ?>)</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead><tr class="bg-surface-container-low/60">
              <th class="text-left p-4 text-xs font-bold text-outline uppercase">Ref</th>
              <th class="text-left p-4 text-xs font-bold text-outline uppercase">Guests</th>
              <th class="text-left p-4 text-xs font-bold text-outline uppercase">Tipe</th>
              <th class="text-left p-4 text-xs font-bold text-outline uppercase">Total</th>
              <th class="text-left p-4 text-xs font-bold text-outline uppercase">Pembayaran</th>
              <th class="text-left p-4 text-xs font-bold text-outline uppercase">Status</th>
              <th class="p-4"></th>
            </tr></thead>
            <tbody>
              <?php foreach(array_reverse(array_values($bookings)) as $b): $sc=$statusColors[$b['status']]??'text-outline bg-surface-container'; ?>
              <tr class="border-t border-outline-variant/20 hover:bg-surface-container/40 transition-colors">
                <td class="p-4"><span class="font-mono text-xs font-bold text-primary block"><?= h($b['booking_ref']) ?></span><span class="text-[10px] text-outline"><?= date('d M Y',strtotime($b['created_at'])) ?></span></td>
                <td class="p-4"><span class="font-semibold text-on-surface"><?= h($b['guest_name']) ?></span><br><span class="text-xs text-outline"><?= h($b['guest_email']) ?></span></td>
                <td class="p-4"><span class="flex items-center gap-1 text-on-surface-variant capitalize"><span class="material-symbols-outlined text-[14px]"><?= $typeIcon[$b['booking_type']]??'book_online' ?></span><?= $b['booking_type'] ?></span></td>
                <td class="p-4 font-bold text-primary whitespace-nowrap"><?= formatRupiah($b['total_amount']) ?></td>
                <td class="p-4 text-on-surface-variant"><?= h($payL[$b['payment_method']]??$b['payment_method']) ?></td>
                <td class="p-4">
                  <form method="POST" class="inline">
                    <input type="hidden" name="update_status" value="1">
                    <input type="hidden" name="ref" value="<?= h($b['booking_ref']) ?>">
                    <select name="status" onchange="this.form.submit()"
                      class="text-xs font-bold px-2.5 py-1.5 rounded-full border outline-none cursor-pointer <?= $sc ?> border-current">
                      <?php foreach(['confirmed','pending','completed','cancelled'] as $st): ?>
                      <option value="<?= $st ?>" <?= $b['status']===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </form>
                </td>
                <td class="p-4">
                  <div class="flex gap-1">
                    <a href="<?= $b['booking_type']==='flight'?'resi_penerbangan':'resi_villa' ?>.php?ref=<?= urlencode($b['booking_ref']) ?>"
                      class="p-2 rounded-lg bg-primary-fixed text-primary hover:bg-primary hover:text-white transition-all" title="Lihat tiket">
                      <span class="material-symbols-outlined text-[15px]">receipt</span>
                    </a>
                    <form method="POST" onsubmit="return confirm('Hapus booking ini?')">
                      <input type="hidden" name="delete_booking" value="1">
                      <input type="hidden" name="ref" value="<?= h($b['booking_ref']) ?>">
                      <button type="submit" class="p-2 rounded-lg bg-error-container text-error hover:bg-error hover:text-white transition-all" title="Hapus">
                        <span class="material-symbols-outlined text-[15px]">delete</span>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <?php elseif($tab==='users'): ?>
      <!-- ── USERS ──────────────────────────────────────────────── -->
      <div class="admin-card rounded-2xl overflow-hidden anim-fade-up">
        <div class="p-5 border-b border-outline-variant/30">
          <h3 class="font-bold text-on-surface">Users (<?= count($users) ?>)</h3>
          <p class="text-xs text-outline mt-1">Data dari data.php — hardcoded. Perubahan role tidak persisten antar sesi.</p>
        </div>
        <div class="divide-y divide-outline-variant/20">
          <?php foreach($users as $u):
            $userBookings=array_filter($bookings,fn($b)=>$b['user_id']==$u['id']);
            $uSpend=array_sum(array_column(array_filter($userBookings,fn($b)=>$b['status']!=='cancelled'),'total_amount'));
          ?>
          <div class="p-5 flex items-center justify-between gap-4 flex-wrap hover:bg-surface-container/30 transition-colors">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-secondary-container flex items-center justify-center text-white font-bold text-lg shrink-0">
                <?= strtoupper(substr($u['name'],0,1)) ?>
              </div>
              <div>
                <p class="font-bold text-on-surface"><?= h($u['name']) ?></p>
                <p class="text-sm text-outline"><?= h($u['email']) ?></p>
                <p class="text-xs text-outline"><?= h($u['phone']) ?></p>
              </div>
            </div>
            <div class="flex items-center gap-4 flex-wrap">
              <div class="text-right">
                <p class="text-xs text-outline">Bookings</p>
                <p class="font-bold text-on-surface"><?= count($userBookings) ?></p>
              </div>
              <div class="text-right">
                <p class="text-xs text-outline">Total Spend</p>
                <p class="font-bold text-primary"><?= formatRupiah($uSpend) ?></p>
              </div>
              <span class="px-3 py-1.5 rounded-full text-xs font-bold <?= $u['role']==='admin'?'bg-primary-fixed text-primary':'bg-surface-container text-outline' ?>">
                <?= ucfirst($u['role']) ?>
              </span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <?php elseif($tab==='properties'): ?>
      <!-- ── PROPERTIES ─────────────────────────────────────────── -->
      <div class="admin-card rounded-2xl overflow-hidden anim-fade-up">
        <div class="p-5 border-b border-outline-variant/30">
          <h3 class="font-bold text-on-surface">Propertieses (<?= count($props) ?>)</h3>
          <p class="text-xs text-outline mt-1">Data dari data.php — untuk edit, ubah langsung array $PROPERTIES.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x divide-outline-variant/20">
          <?php foreach($props as $p):
            $pBookings=array_filter($bookings,fn($b)=>$b['property_id']==$p['id']);
            $pRev=array_sum(array_column(array_filter($pBookings,fn($b)=>$b['status']!=='cancelled'),'total_amount'));
          ?>
          <div class="p-5 flex gap-4 hover:bg-surface-container/30 transition-colors">
            <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0">
              <img src="<?= h($p['image_url']) ?>" alt="<?= h($p['name']) ?>" class="w-full h-full object-cover">
            </div>
            <div class="min-w-0 flex-1">
              <div class="flex items-start justify-between gap-2">
                <div>
                  <p class="font-bold text-on-surface text-sm leading-tight"><?= h($p['name']) ?></p>
                  <p class="text-xs text-outline flex items-center gap-0.5 mt-0.5"><span class="material-symbols-outlined text-[11px]">location_on</span><?= h($p['location']) ?></p>
                </div>
                <span class="px-2 py-1 rounded-full text-[10px] font-bold <?= $p['type']==='villa'?'bg-secondary/10 text-secondary':'bg-primary-fixed text-primary' ?> shrink-0">
                  <?= ucfirst($p['type']) ?>
                </span>
              </div>
              <div class="flex gap-3 mt-2 text-xs text-outline">
                <span class="flex items-center gap-0.5"><span class="material-symbols-outlined icon-fill text-amber-400 text-[11px]">star</span><?= $p['rating'] ?></span>
                <span><?= count($pBookings) ?> booking</span>
                <span class="text-primary font-semibold"><?= formatRupiah($p['price_per_night']) ?>/mlm</span>
              </div>
              <p class="text-xs text-primary font-semibold mt-1">Rev: <?= formatRupiah($pRev) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </main>
  </div>
</div>

<script>
// Animate bar chart
window.addEventListener('load',()=>{
  document.querySelectorAll('.bar-col').forEach((el,i)=>{
    setTimeout(()=>{el.style.height=el.dataset.h;},i*80);
  });
});
</script>
</body></html>
