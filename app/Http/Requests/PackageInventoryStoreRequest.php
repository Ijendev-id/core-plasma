<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PackageInventoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'category' => Str::upper((string) $this->input('category')),
            'question_count' => $this->numericInput('question_count'),
            'duration_minutes' => $this->numericInput('duration_minutes'),
            'participants_count' => $this->numericInput('participants_count'),
            'price' => $this->numericInput('price'),
            'show_participant_preview' => $this->boolean('show_participant_preview'),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:60'],
            'question_count' => ['required', 'integer', 'min:0', 'max:100000'],
            'duration_minutes' => ['required', 'integer', 'min:0', 'max:100000'],
            'participants_count' => ['required', 'integer', 'min:0', 'max:10000000'],
            'price' => ['required', 'integer', 'min:0', 'max:1000000000'],
            'status' => ['required', Rule::in(['published', 'draft'])],
            'icon' => ['required', Rule::in(['graduation', 'rocket', 'briefcase', 'school'])],
            'tone' => ['required', Rule::in(['blue', 'amber', 'muted'])],
            'show_participant_preview' => ['boolean'],
        ];
    }

    private function numericInput(string $key): int
    {
        return (int) preg_replace('/\D+/', '', (string) $this->input($key, 0));
    }
}
