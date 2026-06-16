<?php

namespace App\Http\Requests;

use App\Models\TryoutSection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TryoutQuestionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'section' => ['required', Rule::in(TryoutSection::query()->pluck('code')->all())],
            'prompt' => ['required', 'string', 'min:12'],
            'attachment_path' => ['nullable', 'string', 'max:255'],
            'points' => ['required', 'integer', 'min:1', 'max:100'],
            'is_active' => ['sometimes', 'boolean'],
            'correct_label' => ['required', Rule::in(['A', 'B', 'C', 'D', 'E'])],
            'answers' => ['required', 'array', 'size:5'],
            'answers.A' => ['required', 'string', 'max:1000'],
            'answers.B' => ['required', 'string', 'max:1000'],
            'answers.C' => ['required', 'string', 'max:1000'],
            'answers.D' => ['required', 'string', 'max:1000'],
            'answers.E' => ['required', 'string', 'max:1000'],
        ];
    }
}
