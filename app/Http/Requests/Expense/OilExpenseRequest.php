<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class OilExpenseRequest extends FormRequest
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
            'date' => 'required | date_format:d/m/Y',
            'account_id' => 'required | integer',
            'pump_id' => 'nullable | integer', 
            'vehicle_id' => 'nullable | integer',
            'liter' => "required | numeric | min:1",
            'rate' => 'required | numeric | min:1',
            'note' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'date' => __('cmn.date'),
            'account_id' => __('cmn.account_id'),
            'pump_id' => __('cmn.pump_id'),
            'vehicle_id' => __('cmn.vehicle_id'),
            'liter' => __('cmn.liter'),
            'rate' => __('cmn.rate'),
            'note' => __('cmn.note'),
        ];
    }

    public function messages()
    {
        return [
            'date.required' => __('cmn.must_be_required'),
            'date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),

            'account_id.required' => __('cmn.must_be_required'),
            'account_id.integer' => __('cmn.must_be_in_integer'),

            'pump_id.integer' => __('cmn.must_be_in_integer'),
            'vehicle_id.integer' => __('cmn.must_be_in_integer'),

            'liter.required' => __('cmn.must_be_required'),
            'liter.numeric' => __('cmn.give_the_correct_amount'),
            'liter.min' => __('cmn.give_the_correct_amount'),

            'rate.required' => __('cmn.must_be_required'),
            'rate.numeric' => __('cmn.give_the_correct_amount'),
            'rate.min' => __('cmn.give_the_correct_amount'),
        ];
    }
}
