<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Daftar artikel statis. Pada tahap berikutnya dapat diganti dengan query model.
     *
     * @var array<string, array<string, mixed>>
     */
    private array $articles = [
        'strategi-jitu-lolos-cpns-pppk-2026' => [
            'slug' => 'strategi-jitu-lolos-cpns-pppk-2026',
            'category' => 'CPNS & PPPK',
            'tag_class' => '',
            'date' => '20 Desember 2025',
            'author' => 'Tim Core Plasma',
            'reading_time' => '6 menit baca',
            'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'title' => 'Strategi Jitu Lolos CPNS & PPPK dengan Skor Maksimal',
            'excerpt' => 'Pahami tipe soal ASN, kuasai time management, dan strategi mengerjakan soal CAT untuk meraih nilai tertinggi di seleksi CPNS & PPPK 2026.',
            'content' => [
                'Seleksi Calon Pegawai Negeri Sipil (CPNS) dan Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) 2026 diprediksi akan berlangsung lebih ketat dari tahun-tahun sebelumnya. Ribuan formasi dibuka, namun persaingannya juga sangat tinggi. Karena itu, persiapan matang menjadi kunci utama.',
                'Langkah pertama yang harus kamu lakukan adalah memahami blueprint dan kisi-kisi soal terbaru. Tahun ini, BKN menekankan pada Tes Kompetensi Dasar (TKD), Tes Kompetensi Bidang (TKB), dan Tes Karakteristik Pribadi (TKP). Ketiganya memiliki bobot berbeda, sehingga alokasi waktu belajarmu juga perlu disesuaikan.',
                'Selain pemahaman materi, kelincahan dalam mengerjakan soal berbasis CAT sangat menentukan. Biasakan diri dengan simulasi try out berbatas waktu agar kamu terbiasa mengelola tekanan. Manfaatkan juga fitur analisis skor dari Core Plasma untuk melihat kelemahanmu dan memperbaikinya secara bertahap.',
            ],
            'tips' => [
                'Latihan soal minimal 100 butir per hari.',
                'Review pembahasan, bukan hanya benar atau salahnya.',
                'Tidur cukup 7-8 jam di H-1 ujian.',
            ],
        ],
        'tips-ampuh-lolos-bumn-kedinasan' => [
            'slug' => 'tips-ampuh-lolos-bumn-kedinasan',
            'category' => 'BUMN & KEDINASAN',
            'tag_class' => 'tag-yellow',
            'date' => '15 November 2025',
            'author' => 'Mentor Core Plasma',
            'reading_time' => '7 menit baca',
            'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'title' => 'Tips Ampuh Lolos Seleksi BUMN dan Kedinasan dengan Percaya Diri',
            'excerpt' => 'Analisis soal BUMN, pahami kompetensi yang diuji, dan strategi interview untuk diterima bekerja di BUMN dan Akademi Kedinasan impianmu.',
            'content' => [
                'Mimpi berkarier di BUMN atau Akademi Kedinasan seperti STAN, STIS, atau IPDN? Persaingan ketat bukan halangan bila kamu punya strategi yang tepat.',
                'Tahapan seleksi BUMN biasanya terdiri dari tes online, psikotes, fokus group discussion (FGD), dan wawancara. Setiap tahap punya karakteristik penilaian sendiri. Pelajari pola soal dari tahun sebelumnya, terutama tes numerik, verbal, dan logika.',
                'Untuk Kedinasan, penekanannya lebih pada akademik dan integritas. Pastikan kamu menguasai materi Matematika, Bahasa Indonesia, dan Pengetahuan Umum secara mendalam. Kombinasikan dengan latihan interview berbasis studi kasus agar jawabanmu lebih terstruktur dan meyakinkan.',
            ],
            'tips' => [
                'Latihan FGD bersama teman untuk melatih komunikasi.',
                'Siapkan jawaban STAR (Situation, Task, Action, Result) untuk wawancara.',
                'Tunjukkan motivasi yang tulus dan riset mendalam tentang instansi.',
            ],
        ],
        'raih-skor-utbk-tertinggi-2026' => [
            'slug' => 'raih-skor-utbk-tertinggi-2026',
            'category' => 'UTBK & PTN',
            'tag_class' => '',
            'date' => '10 Oktober 2025',
            'author' => 'Super Teacher Core Plasma',
            'reading_time' => '8 menit baca',
            'image' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'title' => 'Raih Skor UTBK Tertinggi dengan Metode Belajar Revolusioner',
            'excerpt' => 'Kuasai seluruh subtes UTBK (TPS, Literasi, Penalaran), manfaatkan try out berkala, dan maksimalkan peluang lolos PTN di jalur SNBT.',
            'content' => [
                'UTBK SNBT 2026 akan menguji tiga subtes utama: Tes Potensi Skolastik (TPS), Literasi dalam Bahasa Indonesia dan Bahasa Inggris, serta Penalaran Matematika. Untuk menembus PTN favorit, kamu perlu skor minimal 600+. Bukan hal mustahil, asal kamu tahu cara memetakan kekuatan dan kelemahanmu.',
                'Mulailah dengan diagnostic test untuk mengetahui baseline kemampuan. Dari situ, buat jadwal belajar 8-12 minggu yang berfokus pada penguasaan konsep dasar, lalu meningkat ke latihan soal bertingkat dan try out mingguan.',
                'Konsistensi adalah segalanya. Setiap hari, luangkan minimal 90 menit untuk latihan terbimbing dan 30 menit review. Evaluasi progres setiap akhir pekan dan ubah strategi jika diperlukan. Gunakan fitur try out adaptif Core Plasma agar persiapanmu terasa personal dan efektif.',
            ],
            'tips' => [
                'Hindari belajar maraton semalam sebelum try out.',
                'Catat jenis kesalahan dan perbaiki pola belajarmu.',
                'Bergabung dengan komunitas belajar untuk saling memotivasi.',
            ],
        ],
    ];

    /**
     * Tampilkan halaman detail artikel berdasarkan slug.
     */
    public function show(string $slug): View
    {
        abort_unless(array_key_exists($slug, $this->articles), 404);

        $article = $this->articles[$slug];

        $related = collect($this->articles)
            ->reject(fn ($item) => $item['slug'] === $slug)
            ->take(3)
            ->values()
            ->all();

        return view('landing.article', [
            'article' => $article,
            'related' => $related,
        ]);
    }

    /**
     * Daftar seluruh artikel.
     */
    public function index(): View
    {
        return view('landing.articles', [
            'articles' => array_values($this->articles),
        ]);
    }
}
