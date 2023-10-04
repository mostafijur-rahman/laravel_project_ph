<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountBalanceTransferRequest extends FormRequest
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
            'sender_account_id' => 'required', // in
            'recipient_account_id' => 'required', 
            'amount' => 'required | gt:0', 
            'note' => 'nullable', 
        ];
    }

    public function attributes()
    {
        return [
            'date' => __('cmn.date'),
            'sender_account_id' => __('cmn.sender_account'),
            'recipient_account_id' => __('cmn.recipient_account'),
            'amount' => __('cmn.amount'),
            'note' => __('cmn.note'),
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'তারিখ নির্বাচন করুন',

            'sender_account_id.required' => 'প্রেরকের অ্যাকাউন্ট নির্বাচন করুন',
            'recipient_account_id.required' => 'প্রাপক অ্যাকাউন্ট নির্বাচন করুন',

            'amount.required' => 'এমাউন্ট লিখুন',
            'amount.gt' =>  __('cmn.give_the_correct_amount'),
        ];
    }
}
