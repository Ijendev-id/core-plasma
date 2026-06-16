<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfilePhotoService
{
    private const DIRECTORY = 'profile-photos';

    /**
     * Simpan foto profil ke disk default (FILESYSTEM_DISK: local atau s3/MinIO),
     * hapus foto lama, lalu kembalikan path yang tersimpan.
     */
    public function store(Member $member, UploadedFile $file): string
    {
        $this->delete($member->photo_profile);

        // Nama file di-random untuk hindari overwrite & path traversal; ekstensi diambil dari mime tepercaya.
        $filename = Str::uuid()->toString().'.'.$file->extension();

        // Upload private (tidak publik) — diakses lewat temporary signed URL.
        $path = $file->storeAs(self::DIRECTORY, $filename, [
            'disk' => $this->disk(),
            'visibility' => 'private',
        ]);

        return $path;
    }

    /**
     * Hapus file foto bila ada.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk($this->disk())->exists($path)) {
            Storage::disk($this->disk())->delete($path);
        }
    }

    /**
     * URL untuk menampilkan foto. Memakai temporary signed URL agar file tetap private,
     * baik di S3/MinIO maupun disk local (driver local mendukung temporaryUrl bila 'serve' aktif).
     */
    public function url(?string $path, int $minutes = 30): ?string
    {
        if (! $path) {
            return null;
        }

        $disk = Storage::disk($this->disk());

        if (! $disk->exists($path)) {
            return null;
        }

        try {
            return $disk->temporaryUrl($path, now()->addMinutes($minutes));
        } catch (\Throwable) {
            // Fallback bila driver tidak mendukung temporaryUrl.
            return $disk->url($path);
        }
    }

    private function disk(): string
    {
        return (string) config('filesystems.default', 'local');
    }
}
