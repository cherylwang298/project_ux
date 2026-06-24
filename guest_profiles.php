<?php
require 'config.php';
requireAuth();

$user = auth();
$uid = (int)$user['id'];

function gp_str($value, string $default = ''): string {
    if (is_array($value)) $value = reset($value);
    $value = trim((string)($value ?? ''));
    return $value !== '' ? $value : $default;
}
function gp_url(string $base, array $params = []): string {
    return $base . '?' . http_build_query($params);
}

if (!isset($_SESSION['guest_profiles'])) $_SESSION['guest_profiles'] = [];
if (!isset($_SESSION['guest_profiles'][$uid]) || empty($_SESSION['guest_profiles'][$uid])) {
    $_SESSION['guest_profiles'][$uid] = [
        ['id'=>'GP-001','label'=>'My Self','name'=>$user['name'] ?? 'Sarah Jenkins','email'=>$user['email'] ?? 'sarah@example.com','phone'=>$user['phone'] ?? '+62-812-1234-5678'],
        ['id'=>'GP-002','label'=>'Mom','name'=>'Jennifer Jenkins','email'=>'jennifer@example.com','phone'=>'+62-811-1111-1111'],
        ['id'=>'GP-003','label'=>'Dad','name'=>'Michael Jenkins','email'=>'michael@example.com','phone'=>'+62-822-2222-2222'],
        ['id'=>'GP-004','label'=>'Friend','name'=>'Kevin Tan','email'=>'kevin@example.com','phone'=>'+62-833-3333-3333'],
        ['id'=>'GP-005','label'=>'Business Trip','name'=>'Andrew Lee','email'=>'andrew@example.com','phone'=>'+62-844-4444-4444'],
    ];
}

$return = gp_str($_GET['return'] ?? $_POST['return'] ?? 'checkout.php', 'checkout.php');
$slot = gp_str($_GET['slot'] ?? $_POST['slot'] ?? 'guest', 'guest');

if (isset($_GET['use'])) {
    $useId = gp_str($_GET['use']);
    foreach ($_SESSION['guest_profiles'][$uid] as $profile) {
        if (gp_str($profile['id'] ?? '') === $useId) {
            if (!isset($_SESSION['selected_guest_profile'])) $_SESSION['selected_guest_profile'] = [];
            if (!isset($_SESSION['selected_guest_profile'][$uid])) $_SESSION['selected_guest_profile'][$uid] = [];
            $_SESSION['selected_guest_profile'][$uid][$slot] = $useId;
            break;
        }
    }
    header('Location: ' . $return);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        $deleteId = gp_str($_POST['delete_id']);
        $_SESSION['guest_profiles'][$uid] = array_values(array_filter(
            $_SESSION['guest_profiles'][$uid],
            fn($p) => gp_str($p['id'] ?? '') !== $deleteId
        ));
        header('Location: ' . gp_url('guest_profiles.php', ['slot'=>$slot,'return'=>$return]));
        exit;
    }

    $id = gp_str($_POST['profile_id'] ?? '');
    if ($id === '') $id = 'GP-' . strtoupper(substr(md5(uniqid('', true)), 0, 8));

    $profile = [
        'id' => $id,
        'label' => gp_str($_POST['label'] ?? '', 'Saved Profile'),
        'name' => gp_str($_POST['name'] ?? ''),
        'email' => gp_str($_POST['email'] ?? ''),
        'phone' => gp_str($_POST['phone'] ?? ''),
    ];

    $found = false;
    foreach ($_SESSION['guest_profiles'][$uid] as &$p) {
        if (gp_str($p['id'] ?? '') === $id) { $p = $profile; $found = true; break; }
    }
    unset($p);
    if (!$found) $_SESSION['guest_profiles'][$uid][] = $profile;

    header('Location: ' . gp_url('guest_profiles.php', ['slot'=>$slot,'return'=>$return]));
    exit;
}

$profiles = $_SESSION['guest_profiles'][$uid];
$selectedId = $_SESSION['selected_guest_profile'][$uid][$slot] ?? '';

echo htmlHead('Choose Saved Data', <<<CSS
.profile-card{background:rgba(255,255,255,.86);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(195,197,216,.45);box-shadow:0 18px 52px rgba(0,76,226,.08);transition:all .25s ease}.profile-card:hover{transform:translateY(-3px);border-color:rgba(0,76,226,.25);box-shadow:0 24px 64px rgba(0,76,226,.12)}.profile-card.selected{border-color:#004ce2!important;box-shadow:0 24px 64px rgba(0,76,226,.18)!important}.input-field{width:100%;height:48px;border-radius:14px;background:rgba(246,248,255,.85);border:1.5px solid rgba(195,197,216,.8);padding:0 14px;outline:none}.input-field:focus{border-color:#004ce2;box-shadow:0 0 0 3px rgba(0,76,226,.1)}.modal-backdrop{background:rgba(17,28,45,.48);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px)}.modal-box{background:rgba(255,255,255,.96);border:1px solid rgba(255,255,255,.7);box-shadow:0 30px 90px rgba(17,28,45,.28)}.profile-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:18px}
CSS);
?>
<body class="bg-background text-on-background min-h-screen">
<?= navbar('checkout.php') ?>
<?= backButton($return) ?>
<main class="pt-28 pb-20 px-5 md:px-16 max-w-[1180px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
        <div><h1 class="text-4xl font-extrabold text-on-surface mb-2">Choose Saved Data</h1><p class="text-on-surface-variant">Pick one saved profile for this booking, or add/edit data first.</p></div>
        <button type="button" onclick="openModal()" class="px-6 py-3 rounded-full bg-primary text-white font-bold shadow-lg">+ Add New Data</button>
    </div>

    <section class="profile-grid">
        <?php foreach ($profiles as $profile): ?>
            <?php
            $profileId = gp_str($profile['id'] ?? '');
            $label = gp_str($profile['label'] ?? 'Saved Profile', 'Saved Profile');
            $name = gp_str($profile['name'] ?? '-');
            $email = gp_str($profile['email'] ?? '-');
            $phone = gp_str($profile['phone'] ?? '-');
            $useUrl = gp_url('guest_profiles.php', ['slot'=>$slot,'use'=>$profileId,'return'=>$return]);
            $profileJson = htmlspecialchars(json_encode(['id'=>$profileId,'label'=>$label,'name'=>$name,'email'=>$email,'phone'=>$phone], JSON_HEX_APOS|JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
            ?>
            <div class="profile-card <?= $selectedId === $profileId ? 'selected' : '' ?> rounded-3xl p-5">
                <div class="flex items-start gap-4 mb-5">
                    <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-primary">person</span></div>
                    <div class="min-w-0"><p class="font-extrabold text-on-surface"><?= h($label) ?></p><p class="text-lg font-bold text-on-surface-variant"><?= h($name) ?></p><p class="text-sm text-outline truncate"><?= h($email) ?></p><p class="text-sm text-outline truncate"><?= h($phone) ?></p></div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="<?= h($useUrl) ?>" class="px-5 py-2.5 rounded-full bg-primary text-white text-sm font-bold"><?= $selectedId === $profileId ? 'Selected' : 'Use This Data' ?></a>
                    <button type="button" onclick='editProfile(<?= $profileJson ?>)' class="px-5 py-2.5 rounded-full bg-primary-fixed text-primary text-sm font-bold">Edit</button>
                    <form method="POST" onsubmit="return confirm('Delete this saved data?')" class="inline"><input type="hidden" name="slot" value="<?= h($slot) ?>"><input type="hidden" name="return" value="<?= h($return) ?>"><input type="hidden" name="delete_id" value="<?= h($profileId) ?>"><button type="submit" class="px-5 py-2.5 rounded-full bg-red-100 text-red-700 text-sm font-bold">Delete</button></form>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<div id="profileModal" class="fixed inset-0 z-50 hidden modal-backdrop items-center justify-center px-5">
    <div class="modal-box rounded-[32px] p-6 md:p-8 w-full max-w-2xl">
        <div class="flex items-start justify-between gap-4 mb-6"><div><h2 id="modalTitle" class="text-2xl font-extrabold text-on-surface">Add New Data</h2><p class="text-sm text-on-surface-variant mt-1">Save guest/passenger data so you do not need to type it again.</p></div><button type="button" onclick="closeModal()" class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center font-bold">✕</button></div>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="slot" value="<?= h($slot) ?>"><input type="hidden" name="return" value="<?= h($return) ?>"><input type="hidden" name="profile_id" id="modal_profile_id">
            <div class="md:col-span-2"><label class="text-xs font-extrabold text-outline uppercase">Label</label><input class="input-field mt-1" name="label" id="modal_label" placeholder="Example: Mom / Friend / Main Guest"></div>
            <div class="md:col-span-2"><label class="text-xs font-extrabold text-outline uppercase">Full Name</label><input class="input-field mt-1" name="name" id="modal_name" placeholder="Full name" required></div>
            <div><label class="text-xs font-extrabold text-outline uppercase">Email</label><input class="input-field mt-1" name="email" id="modal_email" placeholder="email@example.com"></div>
            <div><label class="text-xs font-extrabold text-outline uppercase">Phone</label><input class="input-field mt-1" name="phone" id="modal_phone" placeholder="+62..."></div>
            <div class="md:col-span-2 flex flex-col sm:flex-row gap-3 mt-4"><button type="submit" class="px-7 py-3 rounded-full bg-primary text-white font-bold">Save Data</button><button type="button" onclick="closeModal()" class="px-7 py-3 rounded-full bg-primary-fixed text-primary font-bold">Cancel</button></div>
        </form>
    </div>
</div>
<script>
function openModal(){const m=document.getElementById('profileModal');document.getElementById('modalTitle').textContent='Add New Data';['profile_id','label','name','email','phone'].forEach(id=>document.getElementById('modal_'+id).value='');m.classList.remove('hidden');m.classList.add('flex')}
function closeModal(){const m=document.getElementById('profileModal');m.classList.add('hidden');m.classList.remove('flex')}
function editProfile(p){openModal();document.getElementById('modalTitle').textContent='Edit Data';document.getElementById('modal_profile_id').value=p.id||'';document.getElementById('modal_label').value=p.label||'';document.getElementById('modal_name').value=p.name||'';document.getElementById('modal_email').value=p.email||'';document.getElementById('modal_phone').value=p.phone||''}
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeModal()});document.getElementById('profileModal').addEventListener('click',function(e){if(e.target===this)closeModal()});
</script>
</body></html>
