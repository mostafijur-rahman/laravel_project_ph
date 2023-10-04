<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;

class TripGeneralExpenseRequest extends FormRequest
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
            'expense_id' => 'required | integer', 
            'account_id' => 'required | integer',
            'amount' => 'required | numeric | min:1',
            'note' => 'nullable',
            'trip_id' => 'nullable',
            'vehicle_id' => 'nullable',
            'date' => 'required | date_format:d/m/Y',
        ];
    }

    public function attributes()
    {
        return [
            'expense_id' => __('cmn.expense_id'),
            'account_id' => __('cmn.account_id'),
            'amount' => __('cmn.amount'),
            'note' => __('cmn.note'),
            'trip_id' => __('cmn.trip_id'),
            'vehicle_id' => __('cmn.vehicle'),
            'date' => __('cmn.date'),
        ];
    }

    public function messages()
    {
        return [
            'expense_id.required' => __('cmn.must_be_required'),
            'expense_id.integer' => __('cmn.must_be_in_integer'),

            'account_id.required' => __('cmn.must_be_required'),
            'account_id.integer' => __('cmn.must_be_in_integer'),

            'amount.required' => __('cmn.must_be_required'),
            'amount.numeric' => __('cmn.give_the_correct_amount'),
            'amount.min' => __('cmn.give_the_correct_amount'),

            'date.required' => __('cmn.must_be_required'),
            'date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),
        ];
    }
}
