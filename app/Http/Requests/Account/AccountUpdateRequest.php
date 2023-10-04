<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AccountUpdateRequest extends FormRequest
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

    public function rules(Request $request)
    {
        return [

            'type' => 'required', 
            'bank_id' => 'required_if:type,bank',
            'holder_name' => 'required_if:type,bank',

            'account_number' => 'required_if:type,bank | unique:accounts,account_number,' . $request->input('id') . ',id,deleted_at,NULL',

            'user_name' => 'required', 
            'note' => 'nullable',

        ];
    }

    public function attributes()
    {
        return [
            'type' => __('cmn.account_type'),
            'bank_id' => __('cmn.bank_name'),
            'holder_name' => __('cmn.holder_name'),
            'account_number' => __('cmn.account_number'),
            'user_name' => __('cmn.user_name'),
            'note' => __('cmn.note'),
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'অ্যাকাউন্টের ধরণ থাকতে হবে',

            'bank_id.required_if' => 'ব্যাংক নির্বাচন করুন',
            'holder_name.required_if' => 'হোল্ডারের নাম লিখুন',
            'account_number.required_if' => 'অ্যাকাউন্ট নাম্বার লিখুন',
            'account_number.unique' => 'ইউনিক অ্যাকাউন্ট নাম্বার দিতে হবে',

            'user_name.required' => 'ব্যবহারকারীর নাম লিখুন',
        ];
    }
}
