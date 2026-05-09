<?php

namespace App\Services;

use App\Models\LearningPackage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PackageInventoryService
{
    private const PER_PAGE = 4;

    /**
     * @param  array<string, mixed>  $filters
     * @return array<string, mixed>
     */
    public function getPackageInventoryPage(array $filters = []): array
    {
        $paginator = $this->packagesQuery($filters)
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $packages = $paginator->getCollection()
            ->map(fn (LearningPackage $package): array => $this->formatPackage($package))
            ->all();

        return [
            'stats' => $this->stats(),
            'packages' => $packages,
            'paginator' => $paginator,
            'pagination' => [
                'from' => $paginator->firstItem() ?? 0,
                'to' => $paginator->lastItem() ?? 0,
                'total' => $paginator->total(),
                'current' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ],
            'filters' => [
                'search' => $filters['search'] ?? '',
                'status' => $filters['status'] ?? '',
            ],
            'helpers' => [
                'bulk_upload' => [
                    'title' => 'Need to Bulk Upload?',
                    'description' => 'Quickly import question banks using our Excel template to populate your packages faster.',
                    'button' => 'Download Template',
                    'image' => 'image/package-bulk-upload.png',
                ],
                'tip' => [
                    'title' => 'Admin Tip',
                    'description' => 'Packages with more than 100 questions see a 35% higher student conversion rate in premium tiers.',
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getPackageFormPage(?LearningPackage $package = null): array
    {
        return [
            'package' => $package ? $this->formValues($package) : $this->emptyFormValues(),
            'categories' => $this->categories(),
            'statuses' => [
                'published' => 'Published',
                'draft' => 'Draft',
            ],
            'icons' => [
                'graduation' => 'Graduation',
                'rocket' => 'Rocket',
                'briefcase' => 'Briefcase',
                'school' => 'School',
            ],
            'tones' => [
                'blue' => 'Blue',
                'amber' => 'Amber',
                'muted' => 'Muted',
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function createPackage(array $data): LearningPackage
    {
        $payload = $this->payload($data);
        $payload['slug'] = $this->uniqueSlug($payload['name']);

        return LearningPackage::query()->create($payload);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updatePackage(LearningPackage $package, array $data): LearningPackage
    {
        $payload = $this->payload($data);

        if ($package->name !== $payload['name']) {
            $payload['slug'] = $this->uniqueSlug($payload['name'], $package->id);
        }

        $package->update($payload);

        return $package->refresh();
    }

    public function deletePackage(LearningPackage $package): void
    {
        $package->delete();
    }

    /**
     * @param  array<string, mixed>  $filters
     */
    private function packagesQuery(array $filters): Builder
    {
        return LearningPackage::query()
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->orderBy('id');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function stats(): array
    {
        $total = LearningPackage::query()->count();
        $published = LearningPackage::query()->where('status', 'published')->count();
        $participants = LearningPackage::query()->sum('participants_count');
        $revenue = LearningPackage::query()
            ->where('status', 'published')
            ->get(['price', 'participants_count'])
            ->sum(fn (LearningPackage $package): int => $package->price * max(1, $package->participants_count));

        return [
            [
                'label' => 'TOTAL PACKAGES',
                'value' => (string) $total,
                'accent' => 'blue',
                'meta' => '+12%',
                'meta_type' => 'trend',
            ],
            [
                'label' => 'ACTIVE PARTICIPANTS',
                'value' => $this->formatCompactNumber($participants),
                'accent' => 'amber',
                'meta' => 'Live',
                'meta_type' => 'live',
            ],
            [
                'label' => 'PUBLISHED RATE',
                'value' => $total === 0 ? '0%' : round(($published / $total) * 100).'%',
                'accent' => 'green',
                'meta' => $total === 0 ? 0 : (int) round(($published / $total) * 100),
                'meta_type' => 'progress',
            ],
            [
                'label' => 'PREMIUM REVENUE',
                'value' => $this->formatCompactRupiah($revenue),
                'accent' => 'premium',
                'meta_type' => 'premium',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function formatPackage(LearningPackage $package): array
    {
        return [
            'name' => $package->name,
            'slug' => $package->slug,
            'icon' => $package->icon,
            'tone' => $package->tone,
            'category' => $package->category,
            'questions' => number_format($package->question_count).' Items',
            'participants' => $package->show_participant_preview
                ? '+'.$this->formatCompactNumber($package->participants_count)
                : number_format($package->participants_count),
            'has_participant_preview' => $package->show_participant_preview,
            'price' => $this->formatRupiah($package->price),
            'status' => $package->status,
            'status_label' => Str::headline($package->status),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function formValues(LearningPackage $package): array
    {
        return [
            'name' => $package->name,
            'category' => $package->category,
            'question_count' => $package->question_count,
            'participants_count' => $package->participants_count,
            'price' => $package->price,
            'status' => $package->status,
            'icon' => $package->icon,
            'tone' => $package->tone,
            'show_participant_preview' => $package->show_participant_preview,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyFormValues(): array
    {
        return [
            'name' => '',
            'category' => 'KEDINASAN',
            'question_count' => 0,
            'participants_count' => 0,
            'price' => 0,
            'status' => 'draft',
            'icon' => 'graduation',
            'tone' => 'blue',
            'show_participant_preview' => false,
        ];
    }

    /**
     * @return array<int, string>
     */
    private function categories(): array
    {
        return collect(['KEDINASAN', 'UNIVERSITY', 'CAREER'])
            ->merge(LearningPackage::query()->distinct()->orderBy('category')->pluck('category'))
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(array $data): array
    {
        $status = $data['status'];

        return [
            'name' => $data['name'],
            'category' => Str::upper($data['category']),
            'question_count' => (int) $data['question_count'],
            'participants_count' => (int) $data['participants_count'],
            'price' => (int) $data['price'],
            'status' => $status,
            'icon' => $data['icon'],
            'tone' => $data['tone'],
            'show_participant_preview' => (bool) ($data['show_participant_preview'] ?? false),
            'published_at' => $status === 'published' ? now() : null,
        ];
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'package';
        $slug = $base;
        $counter = 2;

        while (LearningPackage::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function formatRupiah(int $value): string
    {
        return 'Rp '.number_format($value, 0, ',', '.');
    }

    private function formatCompactRupiah(int $value): string
    {
        if ($value >= 1_000_000_000) {
            return 'Rp '.$this->trimDecimal($value / 1_000_000_000).'B';
        }

        if ($value >= 1_000_000) {
            return 'Rp '.$this->trimDecimal($value / 1_000_000).'M';
        }

        return $this->formatRupiah($value);
    }

    private function formatCompactNumber(int|float $value): string
    {
        if ($value >= 1_000_000) {
            return $this->trimDecimal($value / 1_000_000).'M';
        }

        if ($value >= 1_000) {
            return $this->trimDecimal($value / 1_000).'k';
        }

        return (string) number_format($value);
    }

    private function trimDecimal(float $value): string
    {
        return rtrim(rtrim(number_format($value, 1), '0'), '.');
    }
}
