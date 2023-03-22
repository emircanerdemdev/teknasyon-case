<?php

namespace App\Http\Requests;

use App\Models\Device;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "uid" => "required|max:100",
            "app_id" => "required|in:" . implode(',', array_keys(Device::APPS)),
            "language" => "required|in:" . implode(',', array_keys(Device::LANGUAGES)),
            "os" => "required|in:" . implode(',', array_keys(Device::OS_TYPES))
        ];
    }
}
