<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enum\Notices\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateNoticeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $noticeId = $this->route('notice')->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('notices', 'slug')->ignore($noticeId)],
            'body' => ['required', 'string'],
            'status' => ['required', Rule::enum(Status::class)],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png,gif,webp,avif', 'max:5120'], // 5MB max
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The notice title is required.',
            'body.required' => 'The notice content is required.',
            'status.required' => 'Please select a status for the notice.',
            'attachment.mimes' => 'The attachment must be a PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, or image file (JPG, JPEG, PNG, GIF, WebP, AVIF).',
            'attachment.max' => 'The attachment must not be larger than 5MB.',
        ];
    }
}
