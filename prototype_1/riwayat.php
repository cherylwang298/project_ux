<?php
require 'config.php';
requireAuth();
$user     = auth();
$bookings = getUserBookings($user['id']);
$filter   = $_GET['filter'] ?? 'all';

// Handle cancel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_ref'])) {
  $ref = $_POST['cancel_ref'];
  $bk  = getBookingByRef($ref);
  if ($bk && $bk['user_id'] == $user['id'] && $bk['status'] === 'confirmed') {
    updateBookingStatus($ref, 'cancelled');
    flashSet('success', 'Booking ' . $ref . ' has been cancelled.');
  }
  session_write_close();
  header('Location: riwayat.php?updated=' . time(), true, 303);
  exit;
}

// Filter
$shown = match ($filter) {
  'accommodation' => array_filter($bookings, fn($b) => in_array($b['booking_type'] ?? '', ['hotel', 'villa'], true)),
  'flight'        => array_filter($bookings, fn($b) => ($b['booking_type'] ?? '') === 'flight'),
  'active'        => array_filter($bookings, fn($b) => ($b['status'] ?? '') === 'confirmed'),
  'completed'     => array_filter($bookings, fn($b) => ($b['status'] ?? '') === 'completed'),
  'cancelled'     => array_filter($bookings, fn($b) => ($b['status'] ?? '') === 'cancelled'),
  default         => $bookings,
};
$shown = array_reverse(array_values($shown));

// Stats
$totalSpend  = array_sum(array_column(array_filter($bookings, fn($b) => $b['status'] !== 'cancelled'), 'total_amount'));
$confirmed   = count(array_filter($bookings, fn($b) => $b['status'] === 'confirmed'));
$completed   = count(array_filter($bookings, fn($b) => $b['status'] === 'completed'));
$totalN      = count($bookings);

$scColor = ['confirmed' => ['text-green-700', 'bg-green-100', 'border-green-300'], 'pending' => ['text-amber-700', 'bg-amber-100', 'border-amber-300'], 'completed' => ['text-blue-700', 'bg-blue-100', 'border-blue-300'], 'cancelled' => ['text-red-700', 'bg-red-100', 'border-red-300']];
$typeIcon = ['hotel' => 'hotel', 'villa' => 'villa', 'flight' => 'flight'];
$payL = ['bank_transfer' => 'Bank Transfer', 'gopay' => 'GoPay', 'ovo' => 'OVO', 'qris' => 'QRIS', 'credit_card' => 'Credit Card'];

echo htmlHead(
  "My Bookings",
  <<<CSS
.bk-card{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);border:1.5px solid rgba(195,197,216,.5);box-shadow:0 4px 20px rgba(0,76,226,.05);transition:all .3s ease}
.bk-card:hover{border-color:rgba(0,76,226,.2);box-shadow:0 12px 40px rgba(0,76,226,.09);transform:translateY(-2px)}
.tab-b.active{background:#004ce2;color:white;box-shadow:0 4px 10px rgba(0,76,226,.25)}
CSS
);
?>

<body class="bg-background text-on-background min-h-screen">
  <script>
    if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
    window.scrollTo(0, 0);
  </script>
  <?= navbar('riwayat.php') ?><?= renderFlash() ?>

  <div class="bg-gradient-to-br from-[#111c2d] to-[#004ce2] pt-28 pb-12 px-5 md:px-16">
    <div class="max-w-[1280px] mx-auto">
      <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">My Bookings</h1>
      <p class="text-white/75">Manage all your bookings in one place.</p>
    </div>
  </div>

  <main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">
    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-2 mb-8 anim-fade-up">
      <?php foreach (
        [
          'all' => 'All',
          'accommodation' => 'Accommodations',
          'flight' => 'Flights',
          'active' => 'Active',
          'completed' => 'Completed',
          'cancelled' => 'Cancelled',
        ] as $val => $lbl
      ): ?>
        <a href="?filter=<?= $val ?>"
          class="tab-b px-4 py-2 rounded-full text-xs font-bold border border-outline-variant/40 transition-all <?= $filter === $val ? 'active' : 'text-on-surface-variant' ?>">
          <?= $lbl ?>
        </a>
      <?php endforeach; ?>
    </div>

    <?php if (empty($shown)): ?>
      <div class="text-center py-24 anim-fade-up">
        <div class="w-20 h-20 rounded-3xl bg-surface-container flex items-center justify-center mx-auto mb-5">
          <span class="material-symbols-outlined text-outline text-4xl">book_online</span>
        </div>
        <h2 class="text-xl font-bold text-on-surface mb-2">No Bookings Yet<?= $filter !== 'all' ? ' (' . $filter . ')' : '' ?></h2>
        <p class="text-on-surface-variant mb-6">Start your first journey now.</p>
        <div class="flex justify-center gap-3">
          <a href="detail_hotel.php" class="px-6 py-3 bg-primary text-white rounded-full font-bold text-sm hover:opacity-90 shadow-md">Book Accommodation</a>
          <a href="flight.php" class="px-6 py-3 border border-primary text-primary rounded-full font-bold text-sm hover:bg-primary hover:text-white transition-all">Book Flight</a>
        </div>
      </div>
    <?php else: ?>
      <div class="space-y-5">
        <?php foreach ($shown as $i => $b):
          $bt   = $b['booking_type'];
          $sc   = $scColor[$b['status']] ?? $scColor['confirmed'];
          [$stxt, $sbg, $sborder] = $sc;
          $icon = $typeIcon[$bt] ?? 'book_online';
          $resiLink = ($bt === 'flight') ? 'resi_penerbangan.php' : 'resi_villa.php';

          // Get item name and image
          $iName = '-';
          $iImage = '';
          if ($bt === 'flight') {
            $fi = $b['_item'] ?? getFlight($b['flight_id']);
            $iName = $fi ? $fi['airline'] . ' (' . $fi['from_code'] . '→' . $fi['to_code'] . ')' : 'Flight';
            $iImage = 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=400&q=80'; // Gambar default pesawat
          } else {
            $pi = $b['_item'] ?? getProperty($b['property_id']);
            $iName = $pi ? $pi['name'] : ucfirst($bt);
            $iImage = $pi ? $pi['image_url'] : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&q=80'; // Fallback hotel/villa
          }
        ?>
          <div class="bk-card rounded-2xl p-5 md:p-6 anim-fade-up delay-<?= min(400, $i * 60) ?>">
            <div class="flex flex-col md:flex-row gap-5 md:items-center">

              <!-- Thumbnail Image (Rounded diperbaiki ke 16px) -->
              <div class="w-full md:w-40 h-32 md:h-28 rounded-[16px] shrink-0 overflow-hidden relative shadow-sm">
                <img src="<?= h($iImage) ?>" class="w-full h-full object-cover" alt="<?= h($iName) ?>">
                <!-- Label Overlay -->
                <div class="absolute top-2 left-2 px-2 py-0.5 bg-black/60 backdrop-blur-sm text-white rounded text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                  <span class="material-symbols-outlined text-[13px]"><?= $icon ?></span>
                  <?= $bt ?>
                </div>
              </div>

              <!-- Info Details -->
              <div class="flex-1 min-w-0">
                <div class="flex flex-col mb-2">
                  <div class="flex items-center gap-3 flex-wrap">
                    <p class="font-extrabold text-on-surface text-lg leading-tight"><?= h($iName) ?></p>
                    <!-- Badge Status ditaruh di sebelah Judul -->
                    <span class="px-2.5 py-1 rounded-full border text-[11px] font-bold <?= $stxt . ' ' . $sbg . ' ' . $sborder ?> flex items-center gap-1 w-max">
                      <span class="material-symbols-outlined text-[13px] icon-fill"><?= $b['status'] === 'confirmed' ? 'check_circle' : ($b['status'] === 'cancelled' ? 'cancel' : 'task_alt') ?></span>
                      <?= ucfirst($b['status']) ?>
                    </span>
                  </div>
                  <p class="text-xs text-outline font-mono mt-1.5 font-semibold">Ref: <?= h($b['booking_ref']) ?></p>
                </div>

                <div class="flex flex-wrap gap-x-5 gap-y-2 mt-4 text-sm">
                  <?php if ($bt === 'flight'): ?>
                    <span class="flex items-center gap-1.5 text-on-surface-variant font-medium"><span class="material-symbols-outlined text-[16px] text-primary">calendar_month</span><?= $b['flight_date'] ? date('d M Y', strtotime($b['flight_date'])) : '-' ?></span>
                    <span class="flex items-center gap-1.5 text-on-surface-variant font-medium"><span class="material-symbols-outlined text-[16px] text-primary">airline_seat_recline_normal</span><?= ucfirst($b['seat_class'] ?? 'economy') ?></span>
                    <span class="flex items-center gap-1.5 text-on-surface-variant font-medium"><span class="material-symbols-outlined text-[16px] text-primary">group</span><?= $b['guests'] ?> pax</span>
                  <?php else: ?>
                    <span class="flex items-center gap-1.5 text-on-surface-variant font-medium"><span class="material-symbols-outlined text-[16px] text-primary">login</span><?= $b['check_in'] ? date('d M Y', strtotime($b['check_in'])) : '-' ?></span>
                    <span class="flex items-center gap-1.5 text-on-surface-variant font-medium"><span class="material-symbols-outlined text-[16px] text-primary">logout</span><?= $b['check_out'] ? date('d M Y', strtotime($b['check_out'])) : '-' ?></span>
                    <span class="flex items-center gap-1.5 text-on-surface-variant font-medium"><span class="material-symbols-outlined text-[16px] text-primary">group</span><?= $b['guests'] ?> guests</span>
                  <?php endif; ?>
                  <span class="flex items-center gap-1.5 text-on-surface-variant font-medium"><span class="material-symbols-outlined text-[16px] text-primary">payments</span><?= h($payL[$b['payment_method']] ?? $b['payment_method']) ?></span>
                </div>
              </div>

              <!-- Amount + Actions -->
              <div class="flex flex-col md:items-end justify-between gap-3 shrink-0 pt-4 md:pt-0 border-t md:border-t-0 border-outline-variant/30 md:pl-5 md:border-l">
                <div class="text-left md:text-right">
                  <p class="text-xs text-outline font-semibold">Total Payment</p>
                  <p class="text-xl font-extrabold text-primary"><?= formatRupiah($b['total_amount']) ?></p>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                  <a href="<?= $resiLink ?>?ref=<?= urlencode($b['booking_ref']) ?>"
                    class="flex-1 md:flex-none px-4 py-2 bg-primary-fixed text-primary rounded-full text-xs font-bold hover:bg-primary hover:text-white transition-all flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">receipt</span>E-Ticket
                  </a>
                  <?php if ($b['status'] === 'confirmed'): ?>
                    <button onclick="showCancel('<?= h($b['booking_ref']) ?>')"
                      class="flex-1 md:flex-none px-4 py-2 bg-error-container text-error rounded-full text-xs font-bold hover:bg-error hover:text-white transition-all flex items-center justify-center gap-1">
                      <span class="material-symbols-outlined text-[15px]">cancel</span>Cancel
                    </button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

  <!-- Cancel Modal -->
  <div id="cancelModal" class="fixed inset-0 z-[998] hidden" style="background:rgba(0,0,0,.5)">
    <div class="flex items-center justify-center min-h-screen p-5">
      <div class="glass rounded-3xl p-8 max-w-sm w-full anim-scale">
        <div class="text-center">
          <div class="w-16 h-16 rounded-full bg-error-container flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-error text-3xl icon-fill">cancel</span>
          </div>
          <h3 class="text-xl font-bold text-on-surface mb-2">Cancel Booking?</h3>
          <p class="text-on-surface-variant text-sm mb-1">Ref: <span id="cancelRefTxt" class="font-mono font-bold text-primary"></span></p>
          <p class="text-on-surface-variant text-xs mb-6">Cancellation cannot be undone. Refund process takes 3-5 business days.</p>
          <form method="POST" id="cancelForm">
            <input type="hidden" name="cancel_ref" id="cancelRefIn">
            <div class="flex gap-3">
              <button type="button" onclick="closeCancel()" class="flex-1 h-12 border border-outline-variant rounded-full font-bold text-sm text-on-surface-variant hover:bg-surface-container transition-all">Back</button>
              <button type="submit" class="flex-1 h-12 bg-error text-white rounded-full font-bold text-sm hover:opacity-90 transition-all">Yes, Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?= footer() ?>
  <script>
    function showCancel(ref) {
      document.getElementById('cancelRefTxt').textContent = ref;
      document.getElementById('cancelRefIn').value = ref;
      document.getElementById('cancelModal').classList.remove('hidden');
    }

    function closeCancel() {
      document.getElementById('cancelModal').classList.add('hidden');
    }
    document.getElementById('cancelModal').addEventListener('click', e => {
      if (e.target === e.currentTarget) closeCancel();
    });
  </script>
</body>

</html>