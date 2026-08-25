<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enum\Notices\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();

        return $user !== null && $user->is_admin;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:400000'],
            'status' => ['required', Rule::enum(Status::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The report title is required.',
            'file.required' => 'Please upload a PDF file.',
            'file.mimes' => 'The file must be a PDF.',
            'file.max' => 'The file may not be larger than 400MB.',
            'status.required' => 'Please select a status for the report.',
        ];
    }
}
