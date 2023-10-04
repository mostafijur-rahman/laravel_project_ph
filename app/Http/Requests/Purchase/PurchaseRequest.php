<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'trip_id' => 'required|integer', 
            'previous_reading' => 'required|integer',
            'current_reading' => 'required|integer|gt:previous_reading',
        ];
    }

    public function attributes()
    {
        return [
            'trip_id' => __('cmn.trip_id'),
            'previous_reading' => __('cmn.previous_meter'),
            'current_reading' => __('cmn.running_meter'),
        ];
    }

    public function messages()
    {
        return [
            'previous_reading.required' => __('cmn.give_the_reading_of_the_previous_meter'),
            'current_reading.required' => __('cmn.give_the_reading_of_the_running_meter'),
            'current_reading.gt' => __('cmn.the_reading_of_the_former_meter_is_more_than_the_reading_of_the_running_meter'),
        ];

    }
}
