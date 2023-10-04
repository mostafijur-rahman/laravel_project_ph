<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class wTripUpdateRequest extends FormRequest
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
        return [
            // trip
            'number' => 'required|unique:trips,number,' . $request->input('trip_id') . ',id,deleted_at,NULL',
            'date' => 'required',

            'load_id' => 'required',
            'unload_id' => 'required',

            'box' => 'nullable | integer', 
            'weight' => 'nullable | numeric',
            'unit_id' => 'nullable | integer', 
            'goods' => 'nullable | string', 
            'note' => 'nullable | string',

            // for provider
            'vehicle_id' => 'required_if:ownership,own',
            'vehicle_number' => 'required_if:ownership,out',

            'driver_name' => 'nullable | string', 
            'driver_phone' => 'nullable | string', 
            'owner_name' => 'nullable | string', 
            'owner_phone' => 'nullable | string',
            'reference_name' => 'nullable | string', 
            'reference_phone' => 'nullable | string',

            // for company
            'company_id' => 'required | integer',
        ];
    }


    public function attributes()
    {
        return [

            'trip_id' => 'trip_id',
            'number' => 'trip_number',
            'date' => __('cmn.date'),

            'load_id' => __('cmn.load_point'),
            'unload_id' => __('cmn.unload_point'),

            'box' => 'box',
            'weight' => 'weight',
            'unit_id' => 'unit_id',
            'goods' => 'goods',
            'note' => 'note',

            // for provider
            'vehicle_id' => __('cmn.vehicle'),
            'vehicle_number' => 'vehicle_number',

            'driver_name' => 'driver_name', 
            'driver_phone' => 'driver_phone', 
            'owner_name' => 'owner_name', 
            'owner_phone' => 'owner_phone',
            'reference_name' => 'reference_name', 
            'reference_phone' => 'reference_phone',

            // for company
            'company_id' => __('cmn.company'),
        ];
    }

    public function messages()
    {
        return [
            
            'trip_id' => 'main_trip_id not found',
            'number.required' => 'চালান নম্বর দিতে হবে',
            'number.unique' => 'ইউনিক চালান নম্বর দিতে হবে',
            
            'date.required' => __('cmn.please_select_start_date'),
            
            'load_id.required' => __('cmn.please_select_load_point'),
            'unload_id.required' => __('cmn.please_select_unloadload_point'),
            
            'vehicle_id.required_if' => __('cmn.please_select_vehilce'),
            'vehicle_number.required_if' => 'গাড়ীর নম্বর দিতে হবে',

            // for provider

            // for company
            'company_id.required' => __('cmn.please_select_company'),
        ];
    }

}
