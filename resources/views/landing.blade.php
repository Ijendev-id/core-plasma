<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core Plasma - Kuasai Materi</title>

    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <header class="header-wrapper">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">Core Plasma</a>

            <ul class="nav-links">
                <li><a href="#hero" class="active">Beranda</a></li>
                <li><a href="#artikel">Artikel</a></li>
                <li><a href="#paket">Paket Belajar</a></li>
                <li><a href="#keunggulan">Keunggulan</a></li>
                <li><a href="#testimoni">Testimoni</a></li>
                <li><a href="#promo">Promo</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>

            <div class="nav-buttons">
                @auth('member')
                    <a href="{{ route('dashboard') }}" class="btn-masuk">Dashboard</a>
                    <form action="{{ route('member.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-daftar" style="border: none; cursor: pointer;">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('member.login') }}" class="btn-masuk">Masuk</a>
                    <a href="{{ route('member.register') }}" class="btn-daftar">Daftar</a>
                @endauth
            </div>
        </nav>
    </header>

    <section class="hero" id="hero">
        <div class="hero-content">
            <div class="badge">#PLATFORM TRYOUT TERPERCAYA</div>

            <h1>
                Kuasai <br>
                Materi, <br>
                <span class="text-red">Raih</span>
                <span class="text-red">Impianmu.</span>
            </h1>

            <p>Metode belajar revolusioner yang dirancang untuk mempercepat pemahaman materi sulit menjadi konsep yang menyenangkan.</p>

            <a href="#paket" class="btn-primary">Lihat Paket Belajar</a>

            <div class="social-proof">
                <div class="avatars">
                    <img src="https://i.pravatar.cc/100?img=1" alt="Siswa 1">
                    <img src="https://i.pravatar.cc/100?img=2" alt="Siswa 2">
                    <img src="https://i.pravatar.cc/100?img=3" alt="Siswa 3">
                </div>
                <div class="proof-text">
                    <strong>500+</strong> Siswa Core plasma lolos PTN, Kedinasan, CPNS dan BUMN
                </div>
            </div>
        </div>

        <div class="hero-image-wrapper">
            <img src="{{ asset('image/siswacoreplasma.png') }}" alt="Siswa Core Plasma">
        </div>
    </section>
    <section class="section-padding bg-light-alt" id="artikel">
        <div class="container">
            <div class="section-header flex-header">
                <div>
                    <p class="subtitle">WAWASAN TERBARU</p>
                    <h2>Artikel <span class="text-red">Terupdate</span></h2>
                </div>
                <a href="{{ route('artikel') }}" class="view-all">Lihat Semua Blog &rarr;</a>
            </div>

            <div class="article-grid">
                <div class="article-card">
                    <div class="card-img-wrap">
                        <span class="badge-tag">TIPS & TRIK</span>
                        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Artikel 1">
                    </div>
                    <div class="card-content">
                        <span class="date">24 Mei 2024</span>
                        <h3>Strategi Menjawab Soal Literasi Bahasa Inggris di UTBK 2024</h3>
                        <p>Kuasai teknik scanning dan skimming untuk menghemat waktu pengerjaan soal bacaan...</p>
                        <a href="{{ route('artikel.show', 'strategi-menjawab-soal-literasi-bahasa-inggris-utbk-2024') }}" class="read-more">Baca Selengkapnya &rsaquo;</a>
                    </div>
                </div>

                <div class="article-card">
                    <div class="card-img-wrap">
                        <span class="badge-tag tag-yellow">INFO KAMPUS</span>
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Artikel 2">
                    </div>
                    <div class="card-content">
                        <span class="date">20 Mei 2024</span>
                        <h3>Daftar Jurusan Paling Ketat di Universitas Indonesia (UI) Tahun Ini</h3>
                        <p>Simak data keketatan prodi SAINTEK dan SOSHUM sebagai referensi pemilihan jurusan di jalur SNBT...</p>
                        <a href="{{ route('artikel.show', 'daftar-jurusan-paling-ketat-ui-2024') }}" class="read-more">Baca Selengkapnya &rsaquo;</a>
                    </div>
                </div>

                <div class="article-card">
                    <div class="card-img-wrap">
                        <span class="badge-tag">MOTIVASI</span>
                        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Artikel 3">
                    </div>
                    <div class="card-content">
                        <span class="date">18 Mei 2024</span>
                        <h3>Pentingnya Mental Health Selama Menghadapi Persiapan Ujian Nasional</h3>
                        <p>Jangan sampai burnout! Inilah tips menjaga keseimbangan mental agar tetap fokus saat belajar...</p>
                        <a href="{{ route('artikel.show', 'pentingnya-mental-health-persiapan-ujian') }}" class="read-more">Baca Selengkapnya &rsaquo;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-light" id="paket">
        <div class="container text-center">
            <div class="section-header align-center">
                <p class="subtitle">INVESTASI MASA DEPAN</p>
                <h2>Pilih Paket <span class="text-red">Juaramu</span></h2>
                <p class="desc">Pilih paket yang paling sesuai dengan kebutuhan belajarmu.</p>
            </div>

            <div class="pricing-grid">
                <div class="pricing-card">
                    <h4>Starter</h4>
                    <div class="price">
                        <h2>Rp 149k</h2><span>/bulan</span>
                    </div>
                    <p class="pricing-desc">Cocok untuk kamu yang ingin mencoba metode belajar Alfaiz.</p>
                    <ul class="features">
                        <li><span class="icon-check">&#10003;</span> Akses 50 Video Materi</li>
                        <li><span class="icon-check">&#10003;</span> Bank Soal Harian</li>
                        <li class="disabled"><span class="icon-x">&#10005;</span> Try Out Nasional</li>
                    </ul>
                    <a href="#" class="btn-pricing btn-outline">Pilih Paket</a>
                </div>

                <div class="pricing-card featured">
                    <div class="ribbon">TERPOPULER</div>
                    <h4 class="text-red">Pro</h4>
                    <div class="price">
                        <h2>Rp 299k</h2><span>/bulan</span>
                    </div>
                    <p class="pricing-desc">Pilihan terbaik untuk persiapan UTBK yang komprehensif.</p>
                    <ul class="features">
                        <li><span class="icon-check-red">&#10003;</span> Akses Seluruh Video</li>
                        <li><span class="icon-check-red">&#10003;</span> 10x Try Out Nasional</li>
                        <li><span class="icon-check-red">&#10003;</span> Konsultasi Lewat WA</li>
                        <li><span class="icon-check-red">&#10003;</span> Modul Fisik Dikirim</li>
                    </ul>
                    <a href="#" class="btn-pricing btn-primary-block">Daftar Sekarang</a>
                </div>

                <div class="pricing-card">
                    <h4>Ultimate</h4>
                    <div class="price">
                        <h2>Rp 599k</h2><span>/bulan</span>
                    </div>
                    <p class="pricing-desc">Privat eksklusif dengan pendampingan personal setiap hari.</p>
                    <ul class="features">
                        <li><span class="icon-check-red">&#10003;</span> Semua Fitur Paket Pro</li>
                        <li><span class="icon-check-red">&#10003;</span> Live Session Private</li>
                        <li><span class="icon-check-red">&#10003;</span> Jaminan Lolos PTN*</li>
                    </ul>
                    <a href="#" class="btn-pricing btn-outline">Pilih Paket</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding" style="background-color: #FFFFFF;" id="keunggulan">
        <div class="container about-wrapper">

            <div class="about-gallery">
                <div class="gallery-col col-push-down">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Belajar Bersama" class="img-radius mb-20">
                    <div class="stat-card bg-yellow">
                        <div class="stat-icon">&#8599;</div> <div class="stat-text">
                            <small>SUCCESS RATE</small>
                            <strong>Naik 45% Per Tahun</strong>
                        </div>
                    </div>
                </div>
                <div class="gallery-col">
                    <div class="stat-card bg-red mb-20">
                        <div class="stat-icon">&#9733;</div> <div class="stat-text text-white">
                            <strong class="large-num">98%</strong>
                            <small>Tingkat Kepuasan Siswa</small>
                        </div>
                    </div>
                    <img src="https://images.unsplash.com/photo-1456406644174-8ddd4cd52a06?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Menulis Notes" class="img-radius">
                </div>
            </div>

            <div class="about-content">
                <p class="subtitle">TENTANG KAMI</p>
                <h2>Membangun Masa Depan Melalui <br> <span class="text-red">Edukasi Berdaya</span></h2>

                <div class="vision-mission-list">
                    <div class="vm-item">
                        <div class="vm-icon box-light-red">
                            <span class="text-red">&#128161;</span> </div>
                        <div class="vm-text">
                            <h4>Visi Kami</h4>
                            <p>Menjadi katalisator utama dalam dunia pendidikan digital Indonesia, membantu setiap siswa meraih potensi maksimal mereka tanpa hambatan biaya dan jarak.</p>
                        </div>
                    </div>

                    <div class="vm-item">
                        <div class="vm-icon box-yellow">
                            <span style="color: #000;">&#128640;</span> </div>
                        <div class="vm-text">
                            <h4>Misi Kami</h4>
                            <p>Menyediakan platform belajar yang adaptif, kurikulum yang selalu relevan, serta bimbingan dari para ahli untuk mencetak generasi juara yang siap bersaing secara global.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="section-padding bg-light" id="testimoni">
        <div class="container">

            <div class="testi-header-wrapper">
                <div class="testi-title">
                    <h2>Kisah Mereka yang <span class="text-red">Berhasil</span></h2>
                    <p class="desc mb-0">Dari ragu-ragu menjadi yakin, inilah testimoni nyata dari siswa Core Plasma.</p>
                </div>
                <div class="testi-nav">
                    <button class="btn-nav" id="prevTesti">&larr;</button>
                    <button class="btn-nav" id="nextTesti">&rarr;</button>
                </div>
            </div>

            <div class="testi-container">
                <div class="testi-grid" id="testiGrid">

                <div class="testi-card">
                    <div class="stars">
                        &#9733; &#9733; &#9733; &#9733; &#9733;
                    </div>
                    <p class="review-text">"Metode penghitungan cepat di Core Plasma bener-bener ngebantu aku pas UTBK kemarin. Waktu pengerjaan soal MTK jadi lebih efisien banget!"</p>
                    <div class="user-info">
                        <img src="https://i.pravatar.cc/150?img=5" alt="Anisa" class="avatar">
                        <div>
                            <h5>Anisa Rahma</h5>
                            <span class="achievement text-red">LOLOS KEDOKTERAN UI</span>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="stars">
                        &#9733; &#9733; &#9733; &#9733; &#9733;
                    </div>
                    <p class="review-text">"Dulu aku paling anti sama Fisika, tapi setelah ikut kelas di sini, konsepnya jadi gampang dipahami. Terima kasih banget!"</p>
                    <div class="user-info">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Budi" class="avatar">
                        <div>
                            <h5>Budi Santoso</h5>
                            <span class="achievement text-red">LOLOS TEKNIK ITB</span>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="stars">
                        &#9733; &#9733; &#9733; &#9733; &#9733;
                    </div>
                    <p class="review-text">"Try Out Nasionalnya dapet banget feel ujian aslinya. Analisis skornya akurat dan membantu aku buat fokus di materi yang kurang."</p>
                    <div class="user-info">
                        <img src="https://i.pravatar.cc/150?img=9" alt="Citra" class="avatar">
                        <div>
                            <h5>Citra Lestari</h5>
                            <span class="achievement text-red">LOLOS MANAJEMEN UGM</span>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="stars">
                        &#9733; &#9733; &#9733; &#9733; &#9733;
                    </div>
                    <p class="review-text">"Penjelasan kak Faiz di video materi bener-bener daging semua. Gampang dimengerti bahkan buat aku yang dasarnya lemah di matematika."</p>
                    <div class="user-info">
                        <img src="https://i.pravatar.cc/150?img=12" alt="Dika" class="avatar">
                        <div>
                            <h5>Dika Pratama</h5>
                            <span class="achievement text-red">LOLOS AKPOL</span>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="stars">
                        &#9733; &#9733; &#9733; &#9733; &#9733;
                    </div>
                    <p class="review-text">"Gak nyesel langganan Paket Pro. Modul fisiknya membantu banget buat latihan mandiri di rumah tanpa harus liat layar terus."</p>
                    <div class="user-info">
                        <img src="https://i.pravatar.cc/150?img=16" alt="Eka" class="avatar">
                        <div>
                            <h5>Eka Putri</h5>
                            <span class="achievement text-red">LOLOS STAN</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
    <section class="section-padding bg-light-alt" id="faq">
        <div class="container faq-container">
            <div class="section-header text-center">
                <p class="subtitle">BANTUAN</p>
                <h2>Pertanyaan <span class="text-red">Umum</span></h2>
                <p class="desc">Segala hal yang sering ditanyakan oleh calon juara.</p>
            </div>

            <div class="faq-list">
                <details class="faq-item" open>
                    <summary class="faq-question">Bagaimana cara mendaftar di Core Plasma?</summary>
                    <div class="faq-answer">
                        <p>Cukup klik tombol "Daftar Sekarang" di paket yang kamu inginkan, lengkapi formulir pendaftaran, dan lakukan pembayaran. Akun belajarmu akan langsung aktif setelah konfirmasi otomatis.</p>
                    </div>
                </details>

                <details class="faq-item">
                    <summary class="faq-question">Apakah materi belajarnya bisa diakses selamanya?</summary>
                    <div class="faq-answer">
                        <p>Materi belajar dapat diakses selama masa aktif paket yang kamu pilih. Biasanya akses berlaku hingga masa ujian UTBK dan Mandiri selesai.</p>
                    </div>
                </details>

                <details class="faq-item">
                    <summary class="faq-question">Apakah ada jaminan uang kembali jika tidak puas?</summary>
                    <div class="faq-answer">
                        <p>Kami memberikan garansi 100% uang kembali dalam 7 hari pertama jika kamu merasa metode belajar kami tidak cocok untukmu (Syarat & Ketentuan berlaku).</p>
                    </div>
                </details>

                <details class="faq-item">
                    <summary class="faq-question">Bisakah saya berkonsultasi langsung dengan tutor?</summary>
                    <div class="faq-answer">
                        <p>Tentu! Untuk pengguna Paket Pro dan Ultimate, disediakan grup khusus dan sesi live mentoring untuk berkonsultasi langsung dengan Super Teacher.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <section class="section-padding" style="background-color: #FFFFFF;" id="promo">
        <div class="container">
            <div class="cta-box">
                <h2>Siap Untuk Menjadi <br> <span class="text-yellow">Siswa Juara</span> Selanjutnya?</h2>
                <p>Jangan tunda kesempatanmu untuk masuk PTN impian. Mulai perjalanan suksesmu hari ini bersama Core Plasma.</p>
                <div class="cta-buttons">
                    <a href="#paket" class="btn-yellow">Daftar Sekarang</a>
                    <a href="#" class="btn-dark-red">Hubungi Admin</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container footer-content">
            <div class="footer-brand">
                <h3 class="text-red">Core Plasma</h3>
                <p>&copy; {{ date('Y') }} Core Plasma Education.<br>Melampaui Batas Belajar.</p>
            </div>

            <div class="footer-links">
                <a href="#">Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kontak</a>
                <a href="#">Karir</a>
            </div>

            <div class="footer-social">
                <a href="#" class="social-icon" title="Website">&#127760;</a>
                <a href="#" class="social-icon" title="Email">&#9993;</a>
                <a href="#" class="social-icon" title="YouTube">&#9654;</a>
            </div>
        </div>
    </footer>


    <script>
        const testiGrid = document.getElementById('testiGrid');
        const prevBtn = document.getElementById('prevTesti');
        const nextBtn = document.getElementById('nextTesti');
        let isTransitioning = false;

        function updateActive() {
            const cards = testiGrid.querySelectorAll('.testi-card');
            cards.forEach(card => card.classList.remove('active'));
            // Kartu tengah dari 3 yang muncul adalah indeks ke-1
            if (cards.length > 1) {
                cards[1].classList.add('active');
            }
        }

        if (testiGrid && prevBtn && nextBtn) {
            updateActive();

            nextBtn.addEventListener('click', () => {
                if (isTransitioning) return;
                isTransitioning = true;

                const cardWidth = 350 + 30; // Lebar kartu + Gap
                testiGrid.style.transform = `translateX(-${cardWidth}px)`;

                testiGrid.addEventListener('transitionend', function handleNext() {
                    testiGrid.style.transition = 'none';
                    testiGrid.appendChild(testiGrid.firstElementChild);
                    testiGrid.style.transform = 'translateX(0)';
                    
                    // Force reflow
                    testiGrid.offsetHeight;
                    
                    testiGrid.style.transition = 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    updateActive();
                    isTransitioning = false;
                    testiGrid.removeEventListener('transitionend', handleNext);
                });
            });

            prevBtn.addEventListener('click', () => {
                if (isTransitioning) return;
                isTransitioning = true;

                const cardWidth = 350 + 30;
                
                // Pindah elemen dulu tanpa animasi
                testiGrid.style.transition = 'none';
                testiGrid.insertBefore(testiGrid.lastElementChild, testiGrid.firstElementChild);
                testiGrid.style.transform = `translateX(-${cardWidth}px)`;
                
                // Force reflow
                testiGrid.offsetHeight;

                // Baru geser dengan animasi ke 0
                testiGrid.style.transition = 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                testiGrid.style.transform = 'translateX(0)';
                
                setTimeout(() => {
                    updateActive();
                    isTransitioning = false;
                }, 600);
            });
        }
    </script>
</body>
</html>
