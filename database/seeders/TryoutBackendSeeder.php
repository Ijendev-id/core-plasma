<?php

namespace Database\Seeders;

use App\Models\LearningPackage;
use App\Models\Member;
use App\Models\PackageEnrollment;
use App\Models\TryoutAttempt;
use App\Models\TryoutQuestion;
use Illuminate\Database\Seeder;

class TryoutBackendSeeder extends Seeder
{
    /**
     * Seed question banks, enrollments, and leaderboard attempts.
     */
    public function run(): void
    {
        $packages = LearningPackage::query()->orderBy("id")->take(4)->get();
        $members = Member::query()->orderBy("id")->get();

        if ($packages->isEmpty() || $members->isEmpty()) {
            return;
        }

        foreach ($packages as $packageIndex => $package) {
            $this->seedQuestions($package);

            foreach ($members->take(6) as $memberIndex => $member) {
                PackageEnrollment::query()->updateOrCreate(
                    [
                        "member_id" => $member->id,
                        "learning_package_id" => $package->id,
                    ],
                    [
                        "status" => $package->status === "published" ? "active" : "pending",
                        "progress_percent" => min(98, 32 + ($memberIndex * 9) + ($packageIndex * 6)),
                        "enrolled_at" => now()->subDays($memberIndex + $packageIndex + 1),
                    ],
                );
            }
        }

        foreach ($members as $index => $member) {
            $package = $packages[$index % max(1, $packages->count())];
            $twk = 120 + (($index * 7) % 35);
            $tiu = 130 + (($index * 11) % 38);
            $tkp = 135 + (($index * 13) % 45);
            $score = $twk + $tiu + $tkp;

            TryoutAttempt::query()->updateOrCreate(
                [
                    "member_id" => $member->id,
                    "learning_package_id" => $package->id,
                ],
                [
                    "score" => $score,
                    "twk_score" => $twk,
                    "tiu_score" => $tiu,
                    "tkp_score" => $tkp,
                    "answered_count" => 100,
                    "correct_count" => min(100, (int) floor($score / 5)),
                    "duration_seconds" => 2500 + ($index * 173),
                    "status" => $score >= 430 ? "certified" : "failed",
                    "started_at" => now()->subDays($index + 1)->subMinutes(72),
                    "finished_at" => now()->subDays($index + 1)->startOfMinute(),
                ],
            );
        }
    }

    private function seedQuestions(LearningPackage $package): void
    {
        $questions = $this->questionsForPackage($package);
        foreach ($questions as $index => $question) {
            $model = TryoutQuestion::query()->updateOrCreate(
                [
                    "learning_package_id" => $package->id,
                    "order_number" => $index + 1,
                ],
                [
                    "section" => $question["section"],
                    "prompt" => $question["prompt"],
                    "attachment_path" => $question["attachment_path"] ?? null,
                    "points" => 5,
                    "is_active" => true,
                ],
            );

            foreach (["A", "B", "C", "D", "E"] as $answerIndex => $label) {
                $model->answers()->updateOrCreate(
                    ["label" => $label],
                    [
                        "answer_text" => $question["answers"][$answerIndex],
                        "is_correct" => $label === $question["correct"],
                    ],
                );
            }
        }
    }

    /**
     * Pilih bank soal sesuai kategori / nama / slug paket.
     */
    private function questionsForPackage(LearningPackage $package): array
    {
        $slug = strtolower((string) $package->slug);
        $name = strtolower((string) $package->name);
        $category = strtolower((string) $package->category);

        if (str_contains($slug, "cpns") || str_contains($name, "cpns")) {
            return $this->cpnsQuestions();
        }
        if (str_contains($slug, "stan") || str_contains($name, "stan")) {
            return $this->stanQuestions();
        }
        if (str_contains($slug, "bumn") || str_contains($name, "bumn")) {
            return $this->bumnQuestions();
        }
        if (str_contains($slug, "utbk") || str_contains($slug, "utk") || str_contains($name, "utbk")) {
            return $this->utbkQuestions();
        }
        if (str_contains($category, "university")) {
            return $this->utbkQuestions();
        }
        if (str_contains($category, "career")) {
            return $this->bumnQuestions();
        }
        if (str_contains($category, "kedinasan")) {
            return $this->stanQuestions();
        }

        return $this->genericQuestions();
    }

    /**
     * Bank soal khusus paket bertemaCPNS (kedinasan ASN).
     *
     * @return array<int, array<string, mixed>>
     */
    private function cpnsQuestions(): array
    {
        return [
            [
                "section" => "TWK", "prompt" => "Lembaga negara yang memiliki kewenangan membentuk undang-undang adalah...", "answers" => ["DPR", "BPK", "Mahkamah Agung", "KY", "MA"], "correct" => "A"
            ],
            [
                "section" => "TWK", "prompt" => "Sila keempat Pancasila mengandung nilai...", "answers" => ["Ketuhanan", "Persatuan", "Kerakyatan", "Kemanusiaan", "Keadilan sosial"], "correct" => "C"
            ],
            [
                "section" => "TIU", "prompt" => "Jika 5x + 3 = 28, maka nilai x adalah...", "answers" => ["3", "4", "5", "6", "7"], "correct" => "C"
            ],
            [
                "section" => "TIU", "prompt" => "Sebuah barisan aritmatika memiliki suku pertama 7 dan beda 4. Suku ke-8 adalah...", "answers" => ["31", "32", "35", "39", "43"], "correct" => "C"
            ],
            [
                "section" => "TIU", "prompt" => "Sinonim kata AMAN adalah...", "answers" => ["Bahaya", "Terlindung", "Takterduga", "Rawan", "Khawatir"], "correct" => "B"
            ],
            [
                "section" => "TKP", "prompt" => "Saat rekan kerja kesulitan menyelesaikan tugas, responsi paling tepat adalah...", "answers" => ["Membiarkan", "Membantu sesuai prioritas", "Mengkritik", "Menunda semua", "Melapor tanpa solusi"], "correct" => "B"
            ],
            [
                "section" => "TKP", "prompt" => "Dalam pelayanan publik, prinsip utama yang harus dijaga adalah...", "answers" => ["Kecepatan saja", "Transparansi dan akuntabilitas", "Kedekatan dengan atasan", "Memprioritaskan kenalan", "Menutup informasi"], "correct" => "B"
            ],
            [
                "section" => "TWK", "prompt" => "Bhinneka Tunggal Ika berarti...", "answers" => ["Satu negara", "Berbeda-beda tetapi tetap satu", "Satu bahasa", "Satu budaya", "Satu pemimpin"], "correct" => "B"
            ],
        ];
    }

    /**
     * Bank soal khusus paket bertema STAN (kedinasan).
     *
     * @return array<int, array<string, mixed>>
     */
    private function stanQuestions(): array
    {
        return [
            [
                "section" => "TWK", "prompt" => "Lembaga yang berwenang menetapkan APBN adalah...", "answers" => ["DPR bersama Presiden", "BPK", "Mahkamah Agung", "KY", "DPD"], "correct" => "A"
            ],
            [
                "section" => "TWK", "prompt" => "Sila keempat Pancasila adalah...", "answers" => ["Ketuhanan YME", "Kemanusiaan", "Persatuan", "Kerakyatan", "Keadilan"], "correct" => "D"
            ],
            [
                "section" => "TIU", "prompt" => "Jika 3x + 5 = 20, maka nilai x adalah...", "answers" => ["3", "4", "5", "6", "7"], "correct" => "C"
            ],
            [
                "section" => "TIU", "prompt" => "Suku pertama barisan aritmatika 5, beda 3. Suku ke-10 adalah...", "answers" => ["29", "30", "32", "35", "38"], "correct" => "C"
            ],
            [
                "section" => "TIU", "prompt" => "Antonim kata OPTIMIS adalah...", "answers" => ["Pesimis", "Yakin", "Ceria", "Antusias", "Positif"], "correct" => "A"
            ],
            [
                "section" => "TKP", "prompt" => "Saat menghadapi soal HOTS STAN, strategi yang efektif adalah...", "answers" => ["Mengerjakan paling akhir", "Mengerjakan paling awal", "Mengidentifikasi kata kunci lalu eliminasi", "Menjawab asal", "Menghindari soal HOTS"], "correct" => "C"
            ],
            [
                "section" => "TKP", "prompt" => "Ketika tim gagal mencapai target, sikap Anda sebaiknya...", "answers" => ["Menyalahkan anggota", "Mengevaluasi bersama dan mencari solusi", "Diam dan menunggu", "Mundur dari tim", "Melapor ke atasan tanpa data"], "correct" => "B"
            ],
            [
                "section" => "TWK", "prompt" => "Pancasila sebagai dasar negara Indonesia tertuang dalam...", "answers" => ["UUD 1945", "PPI 1945", "Proklamasi", "Tap MPR", "GBHN"], "correct" => "B"
            ],
        ];
    }

    /**
     * Bank soal khusus paket bertema BUMN / seleksi perusahaan negara.
     *
     * @return array<int, array<string, mixed>>
     */
    private function bumnQuestions(): array
    {
        return [
            [
                "section" => "TWK", "prompt" => "BUMN dikelola oleh...", "answers" => ["Swasta", "Koperasi", "Pemerintah", "Perseorangan", "Asing"], "correct" => "C"
            ],
            [
                "section" => "TWK", "prompt" => "Tujuan BUMN menurut UU adalah...", "answers" => ["Keuntungan pribadi", "Memberikan sumbangan bagi perekonomian nasional", "Mengeksploitasi karyawan", "Monopoli pasar", "Menghindari pajak"], "correct" => "B"
            ],
            [
                "section" => "TIU", "prompt" => "Jika sebuah barang dijual Rp 120.000 dengan untung 20%, harga beli adalah...", "answers" => ["Rp 96.000", "Rp 100.000", "Rp 110.000", "Rp 144.000", "Rp 150.000"], "correct" => "B"
            ],
            [
                "section" => "TIU", "prompt" => "Rata-rata 8, 10, 12, 14, 16 adalah...", "answers" => ["10", "11", "12", "13", "14"], "correct" => "C"
            ],
            [
                "section" => "TIU", "prompt" => "Sinonim kata EFEKTIF adalah...", "answers" => ["Efisien", "Manjur", "Boros", "Lambat", "Berlebihan"], "correct" => "B"
            ],
            [
                "section" => "TKP", "prompt" => "Saat atasan memberikan tugas mendadak di luar jobdesc, sikap Anda...", "answers" => ["Menolak langsung", "Mendiskusikan prioritas dengan atasan", "Mendiamkan", "Mengerjakan sambil mengeluh", "Mendelegasikan tanpa izin"], "correct" => "B"
            ],
            [
                "section" => "TKP", "prompt" => "Dalam kerja tim lintas departemen, Anda sebaiknya...", "answers" => ["Bertahan di zona sendiri", "Berkomunikasi dan berkolaborasi", "Diam saja", "Memonopoli keputusan", "Menghindari koordinasi"], "correct" => "B"
            ],
            [
                "section" => "TWK", "prompt" => "Pancasila sebagai pandangan hidup bangsa disebut juga...", "answers" => ["Dasar negara", "Ideologi terbuka", "Pledge of nation", "Konstitusi", "Norma hukum"], "correct" => "B"
            ],
        ];
    }

    /**
     * Bank soal khusus paket bertema UTBK / PTN.
     *
     * @return array<int, array<string, mixed>>
     */
    private function utbkQuestions(): array
    {
        return [
            [
                "section" => "TIU", "prompt" => "Jika f(x) = 2x + 3, maka f(5) adalah...", "answers" => ["10", "11", "12", "13", "14"], "correct" => "D"
            ],
            [
                "section" => "TIU", "prompt" => "Akar persamaan kuadrat x^2 - 5x + 6 = 0 adalah...", "answers" => ["1 dan 6", "2 dan 3", "3 dan 4", "-2 dan -3", "0 dan 5"], "correct" => "B"
            ],
            [
                "section" => "TIU", "prompt" => "Sinonim kata GENUINE adalah...", "answers" => ["Palsu", "Asli", "Campuran", "Modern", "Beku"], "correct" => "B"
            ],
            [
                "section" => "TIU", "prompt" => "Sebuah segitiga memiliki alas 10 cm dan tinggi 8 cm. Luasnya adalah...", "answers" => ["40 cm2", "60 cm2", "80 cm2", "100 cm2", "120 cm2"], "correct" => "A"
            ],
            [
                "section" => "TIU", "prompt" => "Jika P adalah subset Q, maka...", "answers" => ["Setiap anggota P ada di Q", "P sama dengan Q", "P dan Q saling lepas", "P lebih besar dari Q", "Tidak ada hubungan"], "correct" => "A"
            ],
            [
                "section" => "TWK", "prompt" => "Pancasila resmi menjadi dasar negara pada tanggal...", "answers" => ["17 Agustus 1945", "18 Agustus 1945", "1 Juni 1945", "22 Juni 1945", "10 November 1945"], "correct" => "B"
            ],
            [
                "section" => "TKP", "prompt" => "Strategi mengerjakan soal UTBK yang efektif adalah...", "answers" => ["Kerjakan sulit dulu", "Kerjakan mudah dulu lalu kembali", "Acak urutan", "Hanya kerjakan subtes favorit", "Menyerah di tengah"], "correct" => "B"
            ],
            [
                "section" => "TKP", "prompt" => "Saat kehabisan waktu di subtes terakhir, Anda sebaiknya...", "answers" => ["Panik", "Mengerjakan seadanya dan rapi", "Menyerah total", "Hapus jawaban", "Acak klik"], "correct" => "B"
            ],
        ];
    }

    /**
     * Bank soal generic untuk paket tanpa tema spesifik.
     *
     * @return array<int, array<string, mixed>>
     */
    private function genericQuestions(): array
    {
        return [
            [
                "section" => "TWK", "prompt" => "Nilai utama Pancasila dalam kehidupan berbangsa adalah...", "answers" => ["Individualisme", "Persatuan", "Primordialisme", "Feodalisme", "Anarkisme"], "correct" => "B"
            ],
            [
                "section" => "TIU", "prompt" => "Berapakah 15% dari 200?", "answers" => ["20", "25", "30", "35", "40"], "correct" => "C"
            ],
            [
                "section" => "TIU", "prompt" => "Antonim kata KONSTAN adalah...", "answers" => ["Stabil", "Berubah-ubah", "Tetap", "Selalu", "Berkala"], "correct" => "B"
            ],
            [
                "section" => "TKP", "prompt" => "Saat mendapat kritik dari atasan, sikap Anda sebaiknya...", "answers" => ["Marah", "Mendengarkan dan introspeksi", "Mengabaikan", "Membalas", "Pindah kerja"], "correct" => "B"
            ],
            [
                "section" => "TKP", "prompt" => "Dalam rapat, jika Anda berbeda pendapat dengan rekan, Anda sebaiknya...", "answers" => ["Diam saja", "Menyampaikan argumen dengan sopan", "Memaksakan pendapat", "Meninggalkan rapat", "Mengejek rekan"], "correct" => "B"
            ],
        ];
    }
}
