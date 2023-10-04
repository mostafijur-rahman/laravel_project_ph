<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TripTransectionRequest extends FormRequest
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
    public function rules(Request $request)
    {

        if($request->has('up_down_status')){

            $rule['group_id'] =  'required';
            $rule['up_down_status'] =  'required';

        } else {

            $rule['trip_id'] =  'required';

        }

        // common
        $rule['payment_type'] = 'required';
        $rule['transection_type'] = 'required | string';
        $rule['date'] = 'required';
        $rule['account_id'] = 'required';
        $rule['voucher_id'] = 'nullable | string';
        $rule['amount'] = 'required | min:1';
        $rule['recipients_name'] =  'nullable | string';
        $rule['recipients_phone'] =  'nullable | string';

        return $rule;

    }

    public function attributes()
    {
        return [

            'group_id' => __('cmn.group_id'),
            'up_down_status' => __('cmn.up_down_status'),

            'trip_id' => __('cmn.trip_id'),

            'payment_type' => __('cmn.payment_type'),
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

            'group_id.required' => __('cmn.must_select_trip'),
            'up_down_status.required' => __('cmn.must_select_trip'),

            'trip_id.required' => __('cmn.must_select_trip'),

            'payment_type.required' => __('cmn.payment_type_required'),

            'transection_type.required' => __('cmn.transection_type_required'),
            'transection_type.string' => '',
            'date.required' => __('cmn.please_select_date'),
            'account_id.required' => __('cmn.account_id_is_required'),

            'amount.required' => __('cmn.give_the_correct_amount'),
            'amount.min' => __('cmn.give_the_correct_amount'),

            'recipients_name.string' => '',
            'recipients_phone.string' => '',
        ];

    }
}
