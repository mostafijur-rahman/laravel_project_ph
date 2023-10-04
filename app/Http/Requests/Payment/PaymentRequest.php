<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'company_id' => 'required|integer', 
            'business_type' => 'required',
            'group_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'company_id' => __('cmn.company'),
            'business_type' => __('cmn.business_type'),
            'group_id' => __('cmn.group'),
            'date' => __('cmn.date'),
            'amount' => __('cmn.amount'),
        ];
    }

}
