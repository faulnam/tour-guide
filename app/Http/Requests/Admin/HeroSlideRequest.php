<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HeroSlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $slideId = $this->route('hero_slide') ? $this->route('hero_slide')->id : null;

        return [
            'page' => ['required', 'string', 'max:50'],
            'image' => [$slideId ? 'nullable' : 'nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:10240'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
