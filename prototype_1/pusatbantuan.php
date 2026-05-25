<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #b8cfe8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px 16px;
            font-family: 'DM Sans', sans-serif;
        }
        .phone-frame {
            width: 375px;
            height: 812px;
            border-radius: 44px;
            border: 9px solid #18181b;
            position: relative;
            background: linear-gradient(165deg, #1e57b8 0%, #2563eb 18%, #4a90d9 36%, #82b8f0 54%, #c5deff 72%, #ebf4ff 88%, #f5f9ff 100%);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
        }
        .phone-notch {
            position: absolute;
            top: 8px; left: 50%;
            transform: translateX(-50%);
            width: 100px; height: 26px;
            background: #18181b;
            border-radius: 14px;
            z-index: 500;
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .blob-top {
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(255,255,255,.22) 0%, transparent 70%);
            top: -80px; right: -80px;
            opacity: .7;
        }
        .content-area {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: none;
            padding-bottom: 40px;
            position: relative;
            z-index: 10;
        }
        .content-area::-webkit-scrollbar { display: none; }

        /* HEADER */
        .header-card {
            margin: 28px 20px 16px;
            padding: 22px 20px;
            background: rgba(255,255,255,.42);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 32px;
            border: 1px solid rgba(255,255,255,.75);
            box-shadow: 0 14px 30px rgba(0,0,0,.12);
        }
        .header-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }
        .back-btn {
            width: 36px; height: 36px;
            border-radius: 12px;
            background: rgba(255,255,255,.8);
            border: 1px solid rgba(37,99,235,.18);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            text-decoration: none;
            flex-shrink: 0;
        }
        .back-btn svg { width: 18px; height: 18px; }
        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: #1D4ED8;
            font-family: 'Playfair Display', serif;
        }

        /* SEARCH */
        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,.85);
            border-radius: 16px;
            padding: 0 14px;
            height: 44px;
            border: 1px solid rgba(255,255,255,.9);
            box-shadow: 0 4px 14px rgba(37,99,235,.08);
        }
        .search-box svg { width: 16px; height: 16px; flex-shrink: 0; }
        .search-box input {
            flex: 1;
            border: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            color: #1e3a5f;
            outline: none;
        }
        .search-box input::placeholder { color: rgba(30,58,95,.4); }

        /* QUICK CONTACT */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #0c2461;
            padding: 16px 20px 10px;
        }
        .contact-row {
            display: flex;
            gap: 10px;
            padding: 0 20px;
        }
        .contact-card {
            flex: 1;
            background: rgba(255,255,255,.72);
            backdrop-filter: blur(18px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,.9);
            box-shadow: 0 8px 20px rgba(0,0,0,.07);
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            text-decoration: none;
        }
        .contact-card:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,.12); }
        .contact-icon {
            width: 44px; height: 44px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
        }
        .contact-icon svg { width: 22px; height: 22px; }
        .contact-icon.chat { background: rgba(37,99,235,.12); }
        .contact-icon.phone { background: rgba(16,185,129,.12); }
        .contact-icon.email { background: rgba(245,158,11,.12); }
        .contact-label {
            font-size: 11px;
            font-weight: 700;
            color: #0c2461;
            text-align: center;
        }
        .contact-sub {
            font-size: 9px;
            color: rgba(12,36,97,.55);
            text-align: center;
        }

        /* FAQ SECTION */
        .faq-card {
            margin: 0 20px 14px;
            background: rgba(255,255,255,.72);
            backdrop-filter: blur(18px);
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,.9);
            box-shadow: 0 8px 20px rgba(0,0,0,.07);
            overflow: hidden;
        }
        .faq-item {
            border-bottom: 1px solid rgba(255,255,255,.65);
        }
        .faq-item:last-child { border-bottom: none; }
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 18px;
            cursor: pointer;
            transition: background .2s;
            gap: 12px;
        }
        .faq-question:hover { background: rgba(255,255,255,.6); }
        .faq-q-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .faq-icon {
            width: 36px; height: 36px;
            border-radius: 12px;
            background: rgba(37,99,235,.1);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .faq-icon svg { width: 18px; height: 18px; }
        .faq-q-text {
            font-size: 13px;
            font-weight: 600;
            color: #0c2461;
            line-height: 1.4;
        }
        .faq-chevron {
            flex-shrink: 0;
            transition: transform .25s;
        }
        .faq-chevron svg { width: 16px; height: 16px; }
        .faq-item.open .faq-chevron { transform: rotate(180deg); }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height .3s ease, padding .3s ease;
            padding: 0 18px;
        }
        .faq-item.open .faq-answer {
            max-height: 300px;
            padding: 0 18px 16px;
        }
        .faq-answer p {
            font-size: 12px;
            color: rgba(12,36,97,.72);
            line-height: 1.7;
        }
        .faq-answer ul {
            margin-top: 8px;
            padding-left: 16px;
        }
        .faq-answer ul li {
            font-size: 12px;
            color: rgba(12,36,97,.72);
            line-height: 1.8;
        }

        /* TOPIC CHIPS */
        .topic-row {
            display: flex;
            gap: 8px;
            padding: 0 20px;
            overflow-x: auto;
            scrollbar-width: none;
            margin-bottom: 4px;
        }
        .topic-row::-webkit-scrollbar { display: none; }
        .topic-chip {
            white-space: nowrap;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            flex-shrink: 0;
            transition: all .2s;
            background: rgba(255,255,255,.65);
            border: 1px solid rgba(255,255,255,.85);
            color: #1e3a5f;
        }
        .topic-chip.active {
            background: #1D4ED8;
            color: white;
            box-shadow: 0 4px 14px rgba(29,78,216,.35);
            border-color: transparent;
        }

        /* DARK MODE */
        html.dark-mode body { background: #020617; }
        html.dark-mode .phone-frame {
            border-color: #0f172a !important;
            background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%) !important;
        }
        html.dark-mode .header-card,
        html.dark-mode .faq-card,
        html.dark-mode .contact-card {
            background: rgba(15,23,42,.92) !important;
            border-color: rgba(148,163,184,.2) !important;
        }
        html.dark-mode .page-title,
        html.dark-mode .section-title,
        html.dark-mode .faq-q-text,
        html.dark-mode .contact-label { color: #e2e8f0 !important; }
        html.dark-mode .faq-answer p,
        html.dark-mode .faq-answer ul li,
        html.dark-mode .contact-sub { color: #94a3b8 !important; }
        html.dark-mode .search-box { background: rgba(15,23,42,.9) !important; border-color: rgba(148,163,184,.2) !important; }
        html.dark-mode .search-box input { color: #e2e8f0 !important; }
        html.dark-mode .topic-chip { background: rgba(15,23,42,.8) !important; color: #94a3b8 !important; border-color: rgba(148,163,184,.2) !important; }
        html.dark-mode .topic-chip.active { background: #2563eb !important; color: white !important; }
        html.dark-mode .faq-item { border-color: rgba(148,163,184,.12) !important; }
        html.dark-mode .back-btn { background: rgba(15,23,42,.9) !important; border-color: rgba(148,163,184,.2) !important; }
    </style>
</head>
<body>
    <div class="phone-frame">
        <div class="phone-notch"></div>
        <div class="blob blob-top"></div>

        <div class="content-area">

            <!-- HEADER -->
            <div class="header-card">
                <div class="header-top">
                    <a href="profile.php" class="back-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#1D4ED8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"/>
                        </svg>
                    </a>
                    <div class="page-title">Pusat Bantuan</div>
                </div>
                <div class="search-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2" stroke-linecap="round">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" placeholder="Cari pertanyaan atau topik...">
                </div>
            </div>

            <!-- QUICK CONTACT -->
            <div class="section-title">Hubungi Kami</div>
            <div class="contact-row">
                <a href="#" class="contact-card">
                    <div class="contact-icon chat">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div class="contact-label">Live Chat</div>
                    <div class="contact-sub">Respon cepat</div>
                </a>
                <a href="#" class="contact-card">
                    <div class="contact-icon phone">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <div class="contact-label">Telepon</div>
                    <div class="contact-sub">24/7 tersedia</div>
                </a>
                <a href="#" class="contact-card">
                    <div class="contact-icon email">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <div class="contact-label">Email</div>
                    <div class="contact-sub">Balas 1x24 jam</div>
                </a>
            </div>

            <!-- TOPIC FILTER -->
            <div class="section-title">Topik Bantuan</div>
            <div class="topic-row">
                <div class="topic-chip active" data-topic="semua">Semua</div>
                <div class="topic-chip" data-topic="pemesanan">Pemesanan</div>
                <div class="topic-chip" data-topic="pembayaran">Pembayaran</div>
                <div class="topic-chip" data-topic="pembatalan">Pembatalan</div>
                <div class="topic-chip" data-topic="akun">Akun</div>
            </div>

            <!-- FAQ -->
            <div class="section-title">Pertanyaan Umum</div>
            <div class="faq-card">

                <div class="faq-item" data-topic="pemesanan">
                    <div class="faq-question">
                        <div class="faq-q-left">
                            <div class="faq-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                            </div>
                            <div class="faq-q-text">Bagaimana cara memesan hotel?</div>
                        </div>
                        <div class="faq-chevron">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Ikuti langkah berikut untuk memesan hotel:</p>
                        <ul>
                            <li>Pilih destinasi dan tanggal check-in/out</li>
                            <li>Pilih hotel yang sesuai dari hasil pencarian</li>
                            <li>Pilih tipe kamar dan klik "Pesan Sekarang"</li>
                            <li>Isi data tamu dan lanjutkan ke pembayaran</li>
                            <li>Konfirmasi pesanan akan dikirim via email</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item" data-topic="pemesanan">
                    <div class="faq-question">
                        <div class="faq-q-left">
                            <div class="faq-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            </div>
                            <div class="faq-q-text">Bagaimana cara melihat status pesanan saya?</div>
                        </div>
                        <div class="faq-chevron">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Kamu bisa melihat status pesanan melalui menu <strong>Pesanan</strong> di navbar bawah. Semua riwayat dan status pesanan aktif akan tampil di sana. Kamu juga akan menerima notifikasi email untuk setiap perubahan status.</p>
                    </div>
                </div>

                <div class="faq-item" data-topic="pembayaran">
                    <div class="faq-question">
                        <div class="faq-q-left">
                            <div class="faq-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            </div>
                            <div class="faq-q-text">Metode pembayaran apa saja yang tersedia?</div>
                        </div>
                        <div class="faq-chevron">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Kami menerima berbagai metode pembayaran:</p>
                        <ul>
                            <li>Kartu kredit/debit (Visa, Mastercard)</li>
                            <li>Transfer bank (BCA, Mandiri, BNI, BRI)</li>
                            <li>Dompet digital (GoPay, OVO, Dana, ShopeePay)</li>
                            <li>Virtual Account</li>
                            <li>AgodaCash (poin reward)</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item" data-topic="pembayaran">
                    <div class="faq-question">
                        <div class="faq-q-left">
                            <div class="faq-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                            </div>
                            <div class="faq-q-text">Kapan refund akan masuk ke rekening saya?</div>
                        </div>
                        <div class="faq-chevron">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Proses refund tergantung metode pembayaran yang digunakan:</p>
                        <ul>
                            <li>Kartu kredit: 7–14 hari kerja</li>
                            <li>Transfer bank: 3–5 hari kerja</li>
                            <li>Dompet digital: 1–3 hari kerja</li>
                            <li>AgodaCash: langsung masuk ke akun</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item" data-topic="pembatalan">
                    <div class="faq-question">
                        <div class="faq-q-left">
                            <div class="faq-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            </div>
                            <div class="faq-q-text">Bagaimana cara membatalkan pesanan?</div>
                        </div>
                        <div class="faq-chevron">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Untuk membatalkan pesanan, buka menu <strong>Pesanan</strong>, pilih pesanan yang ingin dibatalkan, lalu klik tombol "Batalkan Pesanan". Pastikan kamu membaca kebijakan pembatalan hotel sebelum melanjutkan, karena beberapa hotel mengenakan biaya pembatalan.</p>
                    </div>
                </div>

                <div class="faq-item" data-topic="pembatalan">
                    <div class="faq-question">
                        <div class="faq-q-left">
                            <div class="faq-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <div class="faq-q-text">Apakah saya bisa mengubah tanggal menginap?</div>
                        </div>
                        <div class="faq-chevron">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Perubahan tanggal tergantung pada kebijakan hotel. Beberapa hotel mengizinkan perubahan tanggal tanpa biaya, sementara yang lain mungkin mengenakan biaya tambahan. Hubungi tim kami melalui Live Chat untuk bantuan lebih lanjut.</p>
                    </div>
                </div>

                <div class="faq-item" data-topic="akun">
                    <div class="faq-question">
                        <div class="faq-q-left">
                            <div class="faq-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                            </div>
                            <div class="faq-q-text">Bagaimana cara reset password?</div>
                        </div>
                        <div class="faq-chevron">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Di halaman login, klik <strong>"Lupa Password?"</strong>. Masukkan email yang terdaftar, lalu cek inbox email kamu untuk link reset password. Link berlaku selama 30 menit. Jika tidak menerima email, cek folder spam atau hubungi kami.</p>
                    </div>
                </div>

                <div class="faq-item" data-topic="akun">
                    <div class="faq-question">
                        <div class="faq-q-left">
                            <div class="faq-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div class="faq-q-text">Bagaimana cara mengubah data profil?</div>
                        </div>
                        <div class="faq-chevron">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Buka menu <strong>Profil → Informasi Pribadi</strong> untuk mengubah nama, nomor telepon, dan data lainnya. Perubahan email memerlukan verifikasi ulang melalui email lama kamu.</p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        // FAQ accordion
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', () => {
                const item = q.closest('.faq-item');
                const isOpen = item.classList.contains('open');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
                if (!isOpen) item.classList.add('open');
            });
        });

        // Topic filter
        document.querySelectorAll('.topic-chip').forEach(chip => {
            chip.addEventListener('click', () => {
                document.querySelectorAll('.topic-chip').forEach(c => c.classList.remove('active'));
                chip.classList.add('active');
                const topic = chip.dataset.topic;
                document.querySelectorAll('.faq-item').forEach(item => {
                    if (topic === 'semua' || item.dataset.topic === topic) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script src="theme.js"></script>
</body>
</html>
