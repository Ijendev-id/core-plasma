<?php

namespace App\Services;

use App\Models\LearningPackage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PackageInventoryService
{
    private const PER_PAGE = 10;

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
                'sort' => $filters['sort'] ?? '',
                'direction' => $filters['direction'] ?? 'asc',
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
        [$sort, $direction] = $this->resolveSort($filters);

        return LearningPackage::query()
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $term = trim($search);

                // Short terms (< 4 chars) are ignored by MySQL FULLTEXT, so fall back to LIKE.
                if (mb_strlen($term) < 4) {
                    $query->where(function ($query) use ($term): void {
                        $query
                            ->where('name', 'like', "%{$term}%")
                            ->orWhere('category', 'like', "%{$term}%");
                    });

                    return;
                }

                // Boolean-mode with a trailing wildcard so partial words still match.
                $boolean = collect(preg_split('/\s+/', $term))
                    ->filter()
                    ->map(fn (string $word): string => '+'.$word.'*')
                    ->implode(' ');

                $query->whereFullText(['name', 'category'], $boolean, ['mode' => 'boolean']);
            })
            ->orderBy($sort, $direction);
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return array{0: string, 1: string}
     */
    private function resolveSort(array $filters): array
    {
        $allowed = [
            'name' => 'name',
            'questions' => 'question_count',
            'participants' => 'participants_count',
            'price' => 'price',
        ];

        $sort = $allowed[$filters['sort'] ?? ''] ?? 'id';
        $direction = strtolower((string) ($filters['direction'] ?? 'asc')) === 'desc' ? 'desc' : 'asc';

        return [$sort, $direction];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function stats(): array
    {
        $total = LearningPackage::query()->count();

        return [
            [
                'label' => 'TOTAL TRYOUT',
                'value' => (string) $total,
                'accent' => 'blue',
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
            'participants' => number_format($package->participants_count),
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
            'duration_minutes' => $package->duration_minutes,
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
            'duration_minutes' => 0,
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
        return \App\Models\TryoutCategory::query()
            ->orderBy('name')
            ->pluck('name')
            ->merge(LearningPackage::query()->distinct()->orderBy('category')->pluck('category'))
            ->filter()
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
            'duration_minutes' => (int) ($data['duration_minutes'] ?? 0),
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
}
