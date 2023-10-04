<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;

class TripOilExpenseRequest extends FormRequest
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
            'pump_id' => 'nullable', 
            'account_id' => 'required', // integer
            'liter' => "required | numeric | between:0.01,9999.99",
            'rate' => 'required | numeric | gt:0',
            'trip_id' => 'nullable',
            'trip_date' => 'nullable',
            'vehicle_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'pump_id' => 'pump_id', 
            'account_id' => 'account_id',
            'liter' => 'liter',
            'rate' => 'rate',
            'trip_id' => 'trip_id',
            'trip_date' => 'trip_date',
            'vehicle_id' => 'vehicle_id',
        ];
    }

    public function messages()
    {
        return [
            'account_id.required' => 'একাউন্ট নির্বাচন করুন',
            // 'account_id.integer' => 'সঠিক একাউন্ট আইডি নির্বাচন করুন',

            'liter.required' => __('cmn.give_the_correct_amount'),
            'liter.numeric' => 'লিটার অবশ্যই নিউমেরিক হতে হবে',
            'liter.between' => 'লিটারে 0.01 থেকে 9999.99  এর মধ্যে এন্ট্রি দিতে হবে',

            'rate.required' => 'রেট দিতে হবে',
            'rate.numeric' => 'রেট অবশ্যই নিউমেরিক হতে হবে',
            'rate.gt' => __('cmn.give_the_correct_amount'),

            'vehicle_id.required' => 'গাড়ী নির্বাচন করুন',
        ];
    }
}
