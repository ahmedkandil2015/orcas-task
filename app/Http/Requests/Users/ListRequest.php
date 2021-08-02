<?php
namespace App\Http\Requests\Users;

use App\Http\Requests\ApiBaseRequest;

class ListRequest extends ApiBaseRequest
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
            "page"=>"nullable",
            "per_page"=>"nullable"
        ];
    }
}

