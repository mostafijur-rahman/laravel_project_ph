<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Brian2694\Toastr\Facades\Toastr;

class TripRequest extends FormRequest
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
            
            'main_trip_id' => 'nullable | integer', 
            'group_id' => 'nullable | integer', 
            'number' => "required | unique:trips,number,NULL,id,deleted_at,NULL", // string

            'account_take_date' => 'required', // date
            'date' => 'required', // date

            'load_id' => 'required',
            'unload_id' => 'required',

            'box' => 'nullable | integer', 
            'weight' => 'nullable | numeric',
            'unit_id' => 'nullable | integer', 
            'goods' => 'nullable |  max:250', // string 
            'note' => 'nullable', // string 

            'ownership' => 'required | string',

            'vehicle_id' => 'required_if:ownership,own',
            'vehicle_number' => 'required_if:ownership,out', // | max:50 - when we add this validation then 'required' validateion did not worked

            'driver_name' => 'nullable | max:250', // string
            'driver_phone' => 'nullable | max:250', // string
            'owner_name' => 'nullable | max:250', // string
            'owner_phone' => 'nullable | max:250', // string
            'reference_name' => 'nullable | max:250', // string
            'reference_phone' => 'nullable | max:250', // string

            // for provider
            'contract_fair' => 'required | min:-1 | integer | gte:advance_fair',
            'advance_fair' => 'required | min:-1 | integer | lte:contract_fair',
            'account_id' => 'required | integer',
            "to_account_id" => 'required_if:ownership,own',

            // for company
            'company_id' => 'required | integer',
            'com_contract_fair' => 'required | min:-1 | integer | gte:com_advance_fair',
            'com_advance_fair' => 'required | min:-1 | integer | lte:com_contract_fair',
            'com_account_id' => 'required | integer',

        ];
    }


    public function attributes()
    {
        return [

            'main_trip_id' => 'main_trip_id',
            'group_id' => 'group_id', 
            'number' => 'trip_number',

            'account_take_date' => 'account_take_date',
            'date' => __('cmn.date'),

            'load_id' => __('cmn.load_point'),
            'unload_id' => __('cmn.unload_point'),

            'box' => 'box',
            'weight' => 'weight',
            'unit_id' => 'unit_id',
            'goods' => 'goods',
            'note' => 'note',

            // 'ownership' => 'ownership',

            'vehicle_id' => __('cmn.vehicle'),
            'vehicle_number' => 'vehicle_number', 
            'driver_name' => 'driver_name', 
            'driver_phone' => 'driver_phone', 
            'owner_name' => 'owner_name', 
            'owner_phone' => 'owner_phone',
            'reference_name' => 'reference_name', 
            'reference_phone' => 'reference_phone',

            'contract_fair' => __('cmn.contract_rent'),
            'advance_fair' =>  __('cmn.received_rent'),
            'account_id' => 'account_id',
            'to_account_id' => 'to_account_id',

            'company_id' => __('cmn.company'),
            'com_contract_fair' => 'com_contract_fair',
            'com_advance_fair' => 'com_advance_fair',
            'com_account_id' => 'com_account_id',
        ];
    }

    public function messages()
    {
        return [
            
            'main_trip_id.integer' => 'main_trip_id must be in nunmber',
            'group_id.integer' => 'group_id must be in nunmber',

            'number.required' => 'চালান নম্বর দিতে হবে',
            'number.unique' => 'ইউনিক চালান নম্বর দিতে হবে',
            
            'account_take_date.required' => 'হিসাব গ্রহণের তারিখ নির্বাচন করুন',
            'date.required' => __('cmn.please_select_start_date'),

            'load_id.required' => __('cmn.please_select_load_point'),
            'unload_id.required' => __('cmn.please_select_unloadload_point'),
            
            'vehicle_id.required_if' => __('cmn.please_select_vehilce'),
            'vehicle_number.required_if' => 'গাড়ীর নম্বর দিতে হবে',

            // other 
            'box.integer' => 'box must be in nunmber',
            'weight.numeric' => 'weight must be in numeric',
            'unit_id.integer' => 'unit_id must be in integer',
            'goods.max:250' => 'goods must be in under 250 charecter',
            
            'ownership.required' => 'ownership must be required',
            'ownership.string' => 'ownership must be in string',

            'vehicle_id.required' => 'vehicle_id must be required',
            'vehicle_number.required' => 'vehicle_number must be required',
            'vehicle_number.max:50' => 'vehicle_number must be in under 50 string',
            
            'driver_name.max:250' => 'driver_name must be in under 250 charecter',
            'driver_phone.max:250' => 'driver_phone must be in under 250 charecter',
            'owner_name.max:250' => 'owner_name must be in under 250 charecter',
            'owner_phone.max:250' => 'owner_phone must be in under 250 charecter',
            'reference_name.max:250' => 'reference_name must be in under 250 charecter',
            'reference_phone.max:250' => 'reference_phone must be in under 250 charecter',
            
            // for provider
            'contract_fair.required' => __('cmn.please_provide_contract_fair'),
            'contract_fair.gte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),
            'contract_fair.min' => __('cmn.minus_amount_cannot_be_given'),
            
            'advance_fair.required' => __('cmn.please_provide_advance_fair'),
            'advance_fair.lte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),
            'advance_fair.min' => __('cmn.minus_amount_cannot_be_given'),
            
            'account_id' => 'provider account id required',
            'to_account_id.required_if' => 'to_account_id_required_if',

            // for company
            'company_id.required' => __('cmn.please_select_company'),
            
            'com_contract_fair.required' =>  __('cmn.please_provide_contract_fair'),
            'com_contract_fair.gte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),
            'com_contract_fair.min' => __('cmn.minus_amount_cannot_be_given'),
            
            'com_advance_fair.required' => __('cmn.please_provide_advance_fair'),
            'com_advance_fair.lte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),
            'com_advance_fair.min' => __('cmn.minus_amount_cannot_be_given'),
            
            'com_account_id.required' => 'com_account_id.required',

        ];
    }

    protected function formatErrors(Validator $validator)
    {
        $messages = $validator->messages();
        foreach ($messages->all() as $message){
            Toastr::error($message, 'Failed', ['timeOut' => 10000]);
        }
        // write file eror
        Storage::put('trip_create_error_report.txt', $messages);
        return $validator->errors()->all();
    }
}
