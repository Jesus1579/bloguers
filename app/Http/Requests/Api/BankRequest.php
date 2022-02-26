<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
USE Illuminate\Http\Request;

class BankRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        parent::authorize();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function __construct(Request $request)
    {
        $this->addRule('POST', [
            'name' => [
                'required',
                'string',
                'max:50',
                'unique:banks,name'
            ],
            'address' => [
                'required',
                'max:50'
            ]
        ]);

        $this->addRule('PUT', [
            'name' => [
                'sometimes',
                'string',
                'max:50',
                'unique:banks,name,'.$request->route('id')
            ],
            'address' => [
                'sometimes',
                'max:50'
            ]
        ]);

        $this->addClassInRuleDelete(Bank::class);
    }
}
