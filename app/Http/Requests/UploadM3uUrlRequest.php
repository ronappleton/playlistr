<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadM3uUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
          'playlist_id' => 'required|integer',
          'm3uUrl' => 'required|string|url',
        ];
    }
}
