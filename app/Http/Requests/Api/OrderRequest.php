<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
USE Illuminate\Http\Request;

class OrderRequest extends BaseRequest
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
            'applicant_name' => [
                'required',
                'string',
                "min:8",
                'max:80',
            ],
            'applicant_dni' => [
                'required',
                'string',
                "min:6",
                'max:40',
            ],
            'applicant_email' => [
                'required',
                'email',
                "min:8",
                'max:60',
            ],            
            'procedure_id' => [
                'required',
                'exists:procedures,id',
            ],            
            'payment_method_id' => [
                'required',
                'exists:payment_methods,id',
            ],
            "reference_number"=>[
                "required_if:payment_method_id,2",//Bank transfer payment method
                "string",
                "min:5",
                "max:20"
            ],
            "voucher_file"=>[
                "required_if:payment_method_id,2"//Bank transfer payment method
            ],
        ]);

        $this->addRule('PUT', [
            'applicant_name' => [
                'string',
                'max:80',
            ],
            'applicant_dni' => [
                'string',
                'max:40',
            ],
            'applicant_email' => [
                'email',
                'max:60',
            ],            
            'procedure_id' => [
                'exists:procedures,id',
            ],            
            'payment_method_id' => [
                'exists:payment_methods,id',
            ],
        ]);

    }
}
