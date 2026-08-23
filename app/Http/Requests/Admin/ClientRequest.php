<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client') ? $this->route('client')->id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'logo' => [$clientId ? 'nullable' : 'nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
