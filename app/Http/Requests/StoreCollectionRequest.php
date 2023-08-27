<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function expectsJson():bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "title"=>['required'],
            "description"=>['required'],
            "target_amount"=>['required'],
            "link"=>['required']
        ];
    }

    public function prepareForValidation():void
    {
        $this->mergeIfMissing([
            "created_at"=>Carbon::now()
        ]);
    }

}
