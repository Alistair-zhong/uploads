<?php

namespace niro\Uploads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
        if($rule = config('uploads.rule')){
            return $rule;
        }
        
        $max_size = config('uploads.max_size');
        return [
            config('uploads.input_name')    => "required|file|max:{$max_size}" ,
        ];
    }
}
