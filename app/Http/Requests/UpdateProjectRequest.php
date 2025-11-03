<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateProjectRequest extends FormRequest
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
        $projectId = $this->route('project')->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($projectId)],
            'description' => ['required', 'string'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'beneficiaries_count' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['boolean'],
            'featured_image' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp,avif', 'max:2048'],
            'gallery_images.*' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp,avif', 'max:2048'],
            'remove_featured_image' => ['boolean'],
            'remove_gallery_images' => ['array'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The project title is required.',
            'description.required' => 'The project description is required.',
            'content.required' => 'The project content is required.',
            'status.required' => 'Please select a status for the project.',
            'status.in' => 'The status must be either draft, published, or archived.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'budget.numeric' => 'The budget must be a valid number.',
            'budget.min' => 'The budget must be at least 0.',
            'beneficiaries_count.integer' => 'The beneficiaries count must be a valid integer.',
            'beneficiaries_count.min' => 'The beneficiaries count must be at least 0.',
            'featured_image.image' => 'The featured image must be a valid image file.',
            'featured_image.mimes' => 'The featured image must be a JPEG, PNG, JPG, GIF, WebP, or AVIF file.',
            'featured_image.max' => 'The featured image must not be larger than 2MB.',
            'gallery_images.*.image' => 'Each gallery image must be a valid image file.',
            'gallery_images.*.mimes' => 'Each gallery image must be a JPEG, PNG, JPG, GIF, WebP, or AVIF file.',
            'gallery_images.*.max' => 'Each gallery image must not be larger than 2MB.',
            'slug.unique' => 'This slug is already in use.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
