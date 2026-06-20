@extends('landing.app')

@section('content')

    <section class="hero-wrapper" id="beranda">
        <div class="container hero">
            <div class="hero-content">
                <div class="badge">#PLATFORM TRYOUT TERPERCAYA</div>
                <h1>
                    Kuasai <br> Materi, <br>
                    <span class="text-red">Raih</span>
                    <span class="text-red">Impianmu.</span>
                </h1>
                <p>Metode belajar revolusioner yang dirancang untuk mempercepat pemahaman materi sulit menjadi konsep yang menyenangkan.</p>
                <a href="#paket" class="btn-primary">Lihat Try Out Gratis</a>

                <div class="social-proof">
                    {{-- <div class="avatars">
                        <img src="https://i.pravatar.cc/100?img=1" alt="Siswa 1">
                        <img src="https://i.pravatar.cc/100?img=2" alt="Siswa 2">
                        <img src="https://i.pravatar.cc/100?img=3" alt="Siswa 3">
                    </div> --}}
                    <div class="proof-text">
                        <strong>500+</strong> Peserta Try Out Core plasma lolos PTN, Kedinasan, CPNS dan BUMN
                    </div>
                </div>
            </div>

            <div class="hero-image-wrapper">
                <img src="{{ asset('image/siswacoreplasma.png') }}" alt="Siswa Core Plasma">
            </div>
        </div>
    </section>

    <section class="section-padding bg-light-alt" id="artikel">
        <div class="container">
            <div class="section-header text-center">
                <p class="subtitle">WAWASAN TERBARU</p>
                <h2>Artikel <span class="text-red">Terupdate</span></h2>
            </div>

            <div class="article-grid">
                <a href="{{ route('artikel.show', ['slug' => 'strategi-jitu-lolos-cpns-pppk-2026']) }}" class="article-card">
                    <div class="card-img-wrap">
                        <span class="badge-tag">CPNS & PPPK</span>
                        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Artikel 1">
                    </div>
                    <div class="card-content">
                        <span class="date">Desember 2025</span>
                        <h3>Strategi Jitu Lolos CPNS & PPPK dengan Skor Maksimal</h3>
                        <p>Pahami tipe soal ASN, kuasai time management, dan strategi mengerjakan soal CAT untuk meraih nilai tertinggi di seleksi CPNS & PPPK 2026...</p>
                        <span class="read-more">Baca Selengkapnya &rsaquo;</span>
                    </div>
                </a>

                <a href="{{ route('artikel.show', ['slug' => 'tips-ampuh-lolos-bumn-kedinasan']) }}" class="article-card">
                    <div class="card-img-wrap">
                        <span class="badge-tag tag-yellow">BUMN & KEDINASAN</span>
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Artikel 2">
                    </div>
                    <div class="card-content">
                        <span class="date">November 2025</span>
                        <h3>Tips Ampuh Lolos Seleksi BUMN dan Kedinasan dengan Percaya Diri</h3>
                        <p>Analisis soal BUMN, pahami kompetensi yang diuji, dan strategi interview untuk diterima bekerja di BUMN dan Akademi Kedinasan impianmu...</p>
                        <span class="read-more">Baca Selengkapnya &rsaquo;</span>
                    </div>
                </a>

                <a href="{{ route('artikel.show', ['slug' => 'raih-skor-utbk-tertinggi-2026']) }}" class="article-card">
                    <div class="card-img-wrap">
                        <span class="badge-tag">UTBK & PTN</span>
                        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Artikel 3">
                    </div>
                    <div class="card-content">
                        <span class="date">Oktober 2025</span>
                        <h3>Raih Skor UTBK Tertinggi dengan Metode Belajar Revolusioner</h3>
                        <p>Kuasai seluruh subtes UTBK (TPS, Literasi, Penalaran), manfaatkan try out berkala, dan maksimalkan peluang lolos PTN di jalur SNBT...</p>
                        <span class="read-more">Baca Selengkapnya &rsaquo;</span>
                    </div>
                </a>
            </div>

            <div class="text-center mt-12">
                <br>
                <a href="{{ route('artikel') }}" class="view-all">Lihat Semua Blog &rarr;</a>
            </div>
        </div>
    </section>
    <section class="section-padding bg-light" id="paket">
        <div class="container text-center">
            <div class="section-header align-center">
                <p class="subtitle">INVESTASI MASA DEPAN</p>
                <h2>Pilih Try Out  <span class="text-red">Juaramu</span></h2>
                <p class="desc">Pilih try out CPNS | PPPK | Kedinasan | UTBK Gratis hanya di core plasma</p>
            </div>

            <div class="pricing-grid" id="pricingGrid">
                @forelse($packages as $index => $package)
                    <div class="pricing-card js-pricing-card @if($index === 1) featured @endif" data-package-id="{{ $package->id }}">
                        @if($index === 1)
                            <div class="ribbon">TERBARU</div>
                        @endif
                        <h4 @if($index === 1) class="text-red js-card-title" @endif class="js-card-title">{{ $package->name }}</h4>
                        <div class="price">
                            <h2>Rp {{ number_format($package->price / 1000, 0, ',', '.') }}k</h2><span>/bulan</span>
                        </div>
                        <p class="pricing-desc">{{ $package->category }}</p>
                        <ul class="features">
                            @if($package->question_count > 0)
                                <li><span class="icon-check{{ $index === 1 ? '-red' : '' }} js-icon-check">&#10003;</span> {{ $package->question_count }} Soal Try Out</li>
                            @endif
                            @if($package->participants_count > 0)
                                <li><span class="icon-check{{ $index === 1 ? '-red' : '' }} js-icon-check">&#10003;</span> {{ $package->participants_count }}+ Peserta Aktif</li>
                            @endif
                        </ul>
                        <a href="{{ $index === 1 ? route('member.register') : '#' }}" class="btn-pricing {{ $index === 1 ? 'btn-primary-block' : 'btn-outline' }} js-pricing-btn">
                            <span class="js-btn-label">{{ $index === 1 ? 'Daftar Sekarang' : 'Pilih Paket' }}</span>
                        </a>
                    </div>
                @empty
                    <div class="pricing-card">
                        <p>Paket belajar sedang dalam persiapan. Silakan kembali lagi nanti.</p>
                    </div>
                @endforelse
            </div>

            @once
                <script>
                    (function () {
                        var grid = document.getElementById('pricingGrid');
                        if (!grid) return;

                        var registerUrl = @json(route('member.register'));

                        grid.addEventListener('click', function (event) {
                            var card = event.target.closest('.js-pricing-card');
                            if (!card || !grid.contains(card)) return;

                            // Kalau klik tombol, tunda navigasi supaya perpindahan featured terlihat dulu
                            var clickedBtn = event.target.closest('.js-pricing-btn');
                            if (clickedBtn) event.preventDefault();

                            var cards = grid.querySelectorAll('.js-pricing-card');
                            cards.forEach(function (c) {
                                if (c === card) return;
                                c.classList.remove('featured');
                                var ribbon = c.querySelector('.ribbon');
                                if (ribbon) ribbon.remove();
                                var title = c.querySelector('.js-card-title');
                                if (title) title.classList.remove('text-red');
                                c.querySelectorAll('.js-icon-check').forEach(function (i) {
                                    i.classList.remove('icon-check-red');
                                });
                                var btn = c.querySelector('.js-pricing-btn');
                                if (btn) {
                                    btn.classList.remove('btn-primary-block');
                                    btn.classList.add('btn-outline');
                                    btn.setAttribute('href', '#');
                                    var label = btn.querySelector('.js-btn-label');
                                    if (label) label.textContent = 'Pilih Paket';
                                }
                            });

                            card.classList.add('featured');
                            if (!card.querySelector('.ribbon')) {
                                var ribbon = document.createElement('div');
                                ribbon.className = 'ribbon';
                                ribbon.textContent = 'TERBARU';
                                card.insertBefore(ribbon, card.firstChild);
                            }
                            var title = card.querySelector('.js-card-title');
                            if (title) title.classList.add('text-red');
                            card.querySelectorAll('.js-icon-check').forEach(function (i) {
                                i.classList.add('icon-check-red');
                            });
                            var btn = card.querySelector('.js-pricing-btn');
                            if (btn) {
                                btn.classList.remove('btn-outline');
                                btn.classList.add('btn-primary-block');
                                btn.setAttribute('href', registerUrl);
                                var label = btn.querySelector('.js-btn-label');
                                if (label) label.textContent = 'Daftar Sekarang';
                            }

                            // Kalau yang diklik adalah tombol, baru navigasi setelah jeda singkat
                            if (clickedBtn) {
                                setTimeout(function () { window.location.href = registerUrl; }, 250);
                            }
                        });
                    })();
                </script>
            @endonce
        </div>
    </section>

    <section class="section-padding" style="background-color: #FFFFFF;" id="tentang">
        <div class="container about-wrapper">
            <div class="about-gallery">
                <div class="gallery-col col-push-down">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Belajar Bersama" class="img-radius mb-20">
                    <div class="stat-card bg-yellow">
                        <div class="stat-icon">&#8599;</div>
                        <div class="stat-text">
                            <small>SUCCESS RATE</small>
                            <strong>Naik 45% Per Tahun</strong>
                        </div>
                    </div>
                </div>
                <div class="gallery-col">
                    <div class="stat-card bg-red mb-20">
                        <div class="stat-icon">&#9733;</div>
                        <div class="stat-text text-white">
                            <strong class="large-num">98%</strong>
                            <small>Tingkat Kepuasan Pengguna</small>
                        </div>
                    </div>
                    <img src="https://images.unsplash.com/photo-1456406644174-8ddd4cd52a06?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Menulis Notes" class="img-radius">
                </div>
            </div>

            <div class="about-content" id="keunggulan">
                <p class="subtitle">TENTANG KAMI</p>
                <h2>Membangun Masa Depan Melalui <br> <span class="text-red">Platform Try Out Terbaik</span></h2>

                <div class="vision-mission-list">
                    <div class="vm-item">
                        <div class="vm-icon box-light-red">
                            <span class="text-red">&#128161;</span>
                        </div>
                        <div class="vm-text">
                            <h4>Visi Kami</h4>
                            <p>Menjadi Platform Try Out Terbaik yang membantu lolos CPNS PPPK kedinasan BUMN atau Perguruan Tinggi Negeri</p>
                        </div>
                    </div>

                    <div class="vm-item">
                        <div class="vm-icon box-yellow">
                            <span style="color: #000;">&#128640;</span>
                        </div>
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
                    <button class="btn-nav">&larr;</button>
                    <button class="btn-nav">&rarr;</button>
                </div>
            </div>

            <div class="testi-grid">
                <div class="testi-card">
                    <div class="stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="review-text">"Metode penghitungan cepat di Core Plasma bener-bener ngebantu aku pas UTBK kemarin. Waktu pengerjaan soal MTK jadi lebih efisien banget!"</p>
                    <div class="user-info">
                        <img src="https://i.pravatar.cc/150?img=5" alt="Anisa" class="avatar">
                        <div>
                            <h5>Anisa Rahma</h5>
                            <span class="achievement text-red">LOLOS KEDOKTERAN UI</span>
                        </div>
                    </div>
                </div>

                <div class="testi-card border-bottom-red">
                    <div class="stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
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
                    <div class="stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="review-text">"Try Out Nasionalnya dapet banget feel ujian aslinya. Analisis skornya akurat dan membantu aku buat fokus di materi yang kurang."</p>
                    <div class="user-info">
                        <img src="https://i.pravatar.cc/150?img=9" alt="Citra" class="avatar">
                        <div>
                            <h5>Citra Lestari</h5>
                            <span class="achievement text-red">LOLOS MANAJEMEN UGM</span>
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

    <section class="section-padding" style="background-color: #FFFFFF;" id="cta-banner">
        <div class="container">
            <div class="cta-box">
                <h2>Siap Untuk Menjadi <br> <span class="text-yellow">Siswa Juara</span> Selanjutnya?</h2>
                <p>Jangan tunda kesempatanmu untuk masuk PTN impian. Mulai perjalanan suksesmu hari ini bersama Core Plasma.</p>
                <div class="cta-buttons">
                    <a href="{{ route('member.register') }}" class="btn-yellow">Daftar Sekarang</a>
                    <a href="#" class="btn-dark-red">Hubungi Admin</a>
                </div>
            </div>
        </div>
    </section>

@endsection

