<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private array $dummyArticles = [
        [
            'id' => 1,
            'title' => 'Strategi Menjawab Soal Literasi Bahasa Inggris di UTBK 2024',
            'slug' => 'strategi-menjawab-soal-literasi-bahasa-inggris-utbk-2024',
            'category' => 'TIPS & TRIK',
            'date' => '24 Mei 2024',
            'author' => 'Admin Core Plasma',
            'thumbnail' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Kuasai teknik scanning dan skimming untuk menghemat waktu pengerjaan soal bacaan literasi yang panjang.',
            'content' => '<p>UTBK 2024 semakin dekat! Salah satu tantangan terbesar bagi para pejuang PTN adalah soal Literasi Bahasa Inggris yang seringkali memiliki teks sangat panjang.</p><p>Untuk menghadapi ini, Anda tidak perlu membaca setiap kata. Gunakan teknik <strong>Scanning</strong> untuk mencari informasi spesifik dan <strong>Skimming</strong> untuk mendapatkan gambaran umum isi teks.</p><p>Selain itu, perhatikan juga keywords pada soal sebelum membaca teks agar Anda tahu apa yang dicari.</p>',
        ],
        [
            'id' => 2,
            'title' => 'Daftar Jurusan Paling Ketat di Universitas Indonesia (UI) Tahun Ini',
            'slug' => 'daftar-jurusan-paling-ketat-ui-2024',
            'category' => 'INFO KAMPUS',
            'date' => '20 Mei 2024',
            'author' => 'Tim Akademik',
            'thumbnail' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Simak data keketatan prodi SAINTEK dan SOSHUM sebagai referensi pemilihan jurusan di jalur SNBT.',
            'content' => '<p>Memilih jurusan bukan hanya soal minat, tapi juga soal strategi. Universitas Indonesia tetap menjadi primadona di SNBT 2024.</p><p>Berdasarkan data tahun lalu, prodi seperti Kedokteran, Ilmu Komputer, dan Ilmu Komunikasi masih menempati urutan teratas dengan tingkat keketatan di bawah 3%.</p><p>Pastikan skor tryout Anda sudah konsisten di angka aman sebelum menetapkan pilihan di UI.</p>',
        ],
        [
            'id' => 3,
            'title' => 'Pentingnya Mental Health Selama Menghadapi Persiapan Ujian Nasional',
            'slug' => 'pentingnya-mental-health-persiapan-ujian',
            'category' => 'MOTIVASI',
            'date' => '18 Mei 2024',
            'author' => 'Psikolog Pendidikan',
            'thumbnail' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'excerpt' => 'Jangan sampai burnout! Inilah tips menjaga keseimbangan mental agar tetap fokus saat belajar intensif.',
            'content' => '<p>Belajar 12 jam sehari tidak akan efektif jika mental Anda sedang dalam kondisi lelah atau stres berat.</p><p>Istirahat yang cukup dan menjaga pola makan adalah kunci utama. Jangan lupa untuk tetap bersosialisasi dan melakukan hobi ringan di sela-sela waktu belajar untuk melepas penat.</p><p>Ingat, hasil yang maksimal datang dari tubuh yang sehat dan pikiran yang tenang.</p>',
        ],
    ];

    public function index(): View
    {
        return view('landing.blog.index', [
            'articles' => $this->dummyArticles
        ]);
    }

    public function show(string $slug): View
    {
        $article = collect($this->dummyArticles)->firstWhere('slug', $slug);

        if (!$article) {
            abort(404);
        }

        return view('landing.blog.show', [
            'article' => $article
        ]);
    }
}
