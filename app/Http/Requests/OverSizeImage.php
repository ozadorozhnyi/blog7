<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OverSizeImage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => sprintf('dimensions:max_width=%d,max_height=%d',
                config('blog.image')->resolution->width,
                config('blog.image')->resolution->height
            ),
        ];
    }
}
