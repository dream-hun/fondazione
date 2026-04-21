<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enum\Reports\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'status' => ['required', Rule::enum(Status::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The report title is required.',
            'file.mimes' => 'The file must be a PDF.',
            'file.max' => 'The file may not be larger than 10MB.',
            'status.required' => 'Please select a status for the report.',
        ];
    }
}
