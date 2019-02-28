<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * HTTP request for item entity.
 */
class ItemRequest extends FormRequest
{
    /**
     * Validation rules for item.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'string|required|max:255',
            'protein' => 'numeric|required',
            'fat' => 'numeric|required',
            'carbohydrates' => 'numeric|required',
            'fiber' => 'numeric|required',
        ];

        if ($this->getMethod() === 'PATCH') {
            $rules = array_map(function ($value) {
                return $value . '|sometimes';
            }, $rules);
        }

        return $rules;
    }

    /**
     * Check access locate in controller.
     *
     * @see \App\Api\Http\Controllers\ItemController
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
