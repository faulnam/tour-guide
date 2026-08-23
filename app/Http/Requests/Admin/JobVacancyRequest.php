<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobVacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jobVacancyId = $this->route('job_vacancy') ? $this->route('job_vacancy')->id : null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('job_vacancies', 'slug')->ignore($jobVacancyId)],
            'responsibilities' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'email_subject' => ['nullable', 'string', 'max:255'],
            'posted_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
