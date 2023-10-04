<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountTransectionRequest extends FormRequest
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

    public function rules()
    {
        return [
            'date' => 'required', 
            'type' => 'required', // in
            'investor_id' => 'required', 
            'account_id' => 'required', 
            'amount' => 'required | gt:0', 
            'note' => 'nullable', 
        ];
    }

    public function attributes()
    {
        return [
            'date' => __('cmn.date'),
            'type' => __('cmn.type'),
            'investor_id' => __('cmn.investor'),
            'account_id' => __('cmn.account'),
            'amount' => __('cmn.amount'),
            'note' => __('cmn.note'),
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'তারিখ নির্বাচন করুন',

            'type.required' => 'ধরণ থাকতে হবে',

            'investor_id.required' => 'ইনভেস্টর নির্বাচন করুন',
            'account_id.required' => 'অ্যাকাউন্টের নাম্বার লিখুন',
            'amount.required' => 'এমাউন্ট লিখুন',
            'amount.gt' =>  __('cmn.give_the_correct_amount'),
        ];
    }
}
