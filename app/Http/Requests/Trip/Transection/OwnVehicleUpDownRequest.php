<?php

namespace App\Http\Requests\Trip\Transection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class OwnVehicleUpDownRequest extends FormRequest
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
            'trip_id' => "required",
            'transection_type' => "required",
            'date' => 'required | date_format:d/m/Y',
            'account_id' => 'required',
            'voucher_id' => 'nullable',
            'amount' => 'required | numeric | min:1',
            'recipients_name' => 'nullable',
            'recipients_phone' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'trip_id' => __('cmn.trip_id'),
            'transection_type' => __('cmn.transection_type'),
            'date' => __('cmn.date'),
            'account_id' => __('cmn.account_id'),
            'voucher_id' => __('cmn.voucher_id'),
            'amount' => __('cmn.amount'),
            'recipients_name' => __('cmn.recipients_name'),
            'recipients_phone' => __('cmn.recipients_phone'),

        ];
    }

    public function messages()
    {
        return [
            // common
            'trip_id.required' => __('cmn.must_be_required'),

            'transection_type.required' => __('cmn.must_be_required'),

            'date.required' => __('cmn.must_be_required'),
            'date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),
            
            'account_id.required' => __('cmn.must_be_required'),

            'amount.required' => __('cmn.must_be_required'),
            'amount.numeric' => __('cmn.must_be_in_numeric'),
            'amount.min' => __('cmn.give_the_correct_amount'),
        ];
    }

}
