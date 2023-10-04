<?php

namespace App\Http\Requests\Trip\Demurrage;

use Illuminate\Foundation\Http\FormRequest;

class OwnVehicleRequest extends FormRequest
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
            'trip_id' => 'required', 
            'date' => 'required', // date_format:d/m/Y // we need to apply this
            'company_amount' => 'nullable | numeric | min:1',
            'provider_amount' => 'nullable | numeric | min:1',
            'note' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'trip_id' => __('cmn.trip_id'),
            'date' => __('cmn.date'),
            'company_amount' => __('cmn.amount'),
            'provider_amount' => __('cmn.amount'),
            'note' =>  __('cmn.note'),
        ];
    }

    public function messages()
    {
        return [
            'trip_id.required' => __('cmn.must_be_required'),

            'date.required' => __('cmn.must_be_required'),
            'date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),

            'company_amount.required' => __('cmn.must_be_required'),
            'company_amount.min' => __('cmn.give_the_correct_amount'),
            'company_amount.numeric' => __('cmn.give_the_correct_amount'),
        
            'provider_amount.required' => __('cmn.must_be_required'),
            'provider_amount.min' => __('cmn.give_the_correct_amount'),
            'provider_amount.numeric' => __('cmn.give_the_correct_amount'),
        ];
    }
}
