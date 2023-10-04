<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;

class TripMeterRequest extends FormRequest
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
            'trip_id' => 'required | integer', 
            'previous_reading' => 'required | numeric | lte:current_reading',
            'current_reading' => 'required | numeric | gt:previous_reading',
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
            'trip_id.required' => 'ট্রিপ আইডি থাকতে হবে',
            'trip_id.integer' => 'ট্রিপ ইন্টিজার থাকতে হবে',

            'previous_reading.required' => __('cmn.give_the_reading_of_the_previous_meter'),
            'previous_reading.numeric' => 'শুরুর রিডিং অবশ্যই নিউমেরিক হতে হবে',
            'previous_reading.lte' => __('cmn.start_meter_reading_is_more_than_the_last_meter_reading'),

            'current_reading.required' => __('cmn.give_the_reading_of_the_running_meter'),
            'current_reading.numeric' => 'শেষ রিডিং অবশ্যই নিউমেরিক হতে হবে',
            'current_reading.gt' => 'শেষ রিডিং অবশ্যই 0 থেকে বেশি হতে হবে',
        ];
    }
}
