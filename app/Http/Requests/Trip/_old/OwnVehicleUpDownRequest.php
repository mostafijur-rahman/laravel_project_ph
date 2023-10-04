<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

class OwnVehicleUpDownRequest extends FormRequest
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

            // common
            'number' => "required | unique:trips,number,NULL,id,deleted_at,NULL", // string
            'account_take_date' => 'required | date_format:d/m/Y', // date format validation
            'ownership' => 'required | string',
            'vehicle_id' => 'required | integer',

            // up challan
            'up_date' => 'required | date_format:d/m/Y', // date format validation
            'up_driver_id' => 'required | integer',
            'up_helper_id' => 'nullable | integer',
            'up_load_id' => 'required',
            'up_unload_id' => 'required',

            'up_box' => 'nullable | numeric',
            'up_weight' => 'nullable | numeric',
            'up_unit_id' => 'nullable | integer',
            'up_goods' => 'nullable |  max:250', 
            'up_note' => 'nullable',

            'up_company_id' => 'required | integer',
            'up_com_contract_fair' => 'required | numeric | min:-1 | gte:up_com_advance_fair', // not_in:0, min:0
            'up_com_advance_fair' => 'required | numeric | min:-1 | lte:up_com_contract_fair',
            'up_com_account_id' => 'required | integer',
            
            // down challan
            'down_date' => 'nullable | date_format:d/m/Y', // required
            'down_driver_id' => 'nullable | integer', // required
            'down_helper_id' => 'nullable | integer',
            'down_load_id' => 'nullable', // required
            'down_unload_id' => 'nullable', // required

            'down_box' => 'nullable | numeric',
            'down_weight' => 'nullable | numeric',
            'down_unit_id' => 'nullable | integer',
            'down_goods' => 'nullable |  max:250',
            'down_note' => 'nullable',

            'down_company_id' => 'nullable | integer', // required
            'down_com_contract_fair' => 'nullable | numeric | min:-1 | gte:down_com_advance_fair', // required
            'down_com_advance_fair' => 'nullable | numeric | min:-1 | lte:down_com_contract_fair', // required
            'down_com_account_id' => 'nullable | integer', // required

        ];
    }


    public function attributes()
    {
        return [

            // common
            'number' => __('cmn.challan_number'),
            'account_take_date' => __('cmn.account_receiving_date'),
            'ownership' => __('cmn.ownership'),
            'vehicle_id' => __('cmn.vehicle'),

            // up challan
            'up_date' => __('cmn.date'),
            'up_driver_id' => __('cmn.driver'),
            'up_helper_id' => __('cmn.helper'),
            'up_load_id' => __('cmn.load_point'),
            'up_unload_id' => __('cmn.unload_point'),

            'up_box' => __('cmn.box_qty'),
            'up_weight' => __('cmn.weight'),
            'up_unit_id' => __('cmn.unit'),
            'up_goods' => __('cmn.goods'),
            'up_note' => __('cmn.note'),

            'up_company_id' => __('cmn.company'),
            'up_com_contract_fair' => __('cmn.contract_rent'),
            'up_com_advance_fair' => __('cmn.received_rent'),
            'up_com_account_id' => __('cmn.accounts'),

            // down challan
            'down_date' => __('cmn.date'),
            'down_driver_id' => __('cmn.driver'),
            'down_helper_id' => __('cmn.helper'),
            'down_load_id' => __('cmn.load_point'),
            'down_unload_id' => __('cmn.unload_point'),

            'down_box' => __('cmn.box_qty'),
            'down_weight' => __('cmn.weight'),
            'down_unit_id' => __('cmn.unit'),
            'down_goods' => __('cmn.goods'),
            'down_note' => __('cmn.note'),

            'down_company_id' => __('cmn.company'),
            'down_com_contract_fair' => __('cmn.contract_rent'),
            'down_com_advance_fair' => __('cmn.received_rent'),
            'down_com_account_id' => __('cmn.accounts'),

        ];
    }

    public function messages()
    {
        return [

            // common
            'number.required' => __('cmn.challan_number_required'),
            'number.unique' => __('cmn.challan_number_need_to_be_unique'),

            'account_take_date.required' => __('cmn.account_take_date_required'),
            'account_take_date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),
            
            'ownership.required' => __('cmn.ownership_must_be_required'),
            'ownership.string' => __('cmn.ownership_must_be_required'),

            'vehicle_id.required' => __('cmn.vehicle_must_be_required'),
            'vehicle_id.integer' => __('cmn.vehicle_must_be_required'),


            // up challan
            'up_date.required' => __('cmn.please_select_start_date'),
            'up_date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),
            
            'up_driver_id.required' => __('cmn.driver_must_be_required'),
            'up_driver_id.integer' => __('cmn.driver_must_be_required'),

            'up_helper_id.integer' => '',

            'up_load_id.required' => __('cmn.please_select_load_point'),
            // 'up_load_id.integer' => __('cmn.please_select_load_point'),

            'up_unload_id.required' => __('cmn.please_select_unload_point'),
            // 'up_unload_id.integer' => __('cmn.please_select_unload_point'),

            'up_box.numeric' => __('cmn.please_provide_number_value'),
            'up_weight.numeric' => __('cmn.please_provide_number_value'),
            'up_unit_id.integer' => __('cmn.please_select_unit'),
            'up_goods.max' => __('cmn.max_250_character_allowed'),

            'up_company_id.required' => __('cmn.company_must_be_required'),
            'up_company_id.integer' => __('cmn.must_be_in_integer'),

            'up_com_contract_fair.required' => __('cmn.must_be_required'),
            'up_com_contract_fair.numeric' => __('cmn.must_be_in_numeric'),
            'up_com_contract_fair.min' => __('cmn.give_the_correct_amount'),
            'up_com_contract_fair.not_in' => __('cmn.minus_amount_cannot_be_given'),
            'up_com_contract_fair.gte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),

            'up_com_advance_fair.required' => __('cmn.must_be_required'),
            'up_com_advance_fair.numeric' => __('cmn.must_be_in_numeric'),
            'up_com_advance_fair.min' => __('cmn.give_the_correct_amount'),
            'up_com_advance_fair.not_in' => __('cmn.minus_amount_cannot_be_given'),
            'up_com_advance_fair.lte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),

            'up_com_account_id.required' => __('cmn.must_be_required'),
            'up_com_account_id.integer' => __('cmn.must_be_in_integer'),


            // down challan
            'down_date.required' => __('cmn.please_select_start_date'),
            'down_date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),

            'down_driver_id.required' => __('cmn.driver_must_be_required'),
            'down_driver_id.integer' => __('cmn.driver_must_be_required'),

            'down_helper_id.integer' => '',

            'down_load_id.required' => __('cmn.please_select_load_point'),
            // 'down_load_id.integer' => __('cmn.please_select_load_point'),

            'down_unload_id.required' => __('cmn.please_select_unload_point'),
            // 'down_unload_id.integer' => __('cmn.please_select_unload_point'),

            'down_box.numeric' => __('cmn.please_provide_number_value'),
            'down_weight.numeric' => __('cmn.please_provide_number_value'),
            'down_unit_id.integer' => __('cmn.please_select_unit'),
            'down_goods.max' => __('cmn.max_250_character_allowed'),

            'down_company_id.required' => __('cmn.company_must_be_required'),
            'down_company_id.integer' => __('cmn.must_be_in_integer'),

            'down_com_contract_fair.required' => __('cmn.must_be_required'),
            'down_com_contract_fair.numeric' => __('cmn.must_be_in_numeric'),
            'down_com_contract_fair.min' => __('cmn.give_the_correct_amount'),
            'down_com_contract_fair.not_in' => __('cmn.minus_amount_cannot_be_given'),
            'down_com_contract_fair.gte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),

            'down_com_advance_fair.required' => __('cmn.must_be_required'),
            'down_com_advance_fair.numeric' => __('cmn.must_be_in_numeric'),
            'down_com_advance_fair.min' => __('cmn.give_the_correct_amount'),
            'down_com_advance_fair.not_in' => __('cmn.minus_amount_cannot_be_given'),
            'down_com_advance_fair.gte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),

            'down_com_account_id.required' => __('cmn.must_be_required'),
            'down_com_account_id.integer' => __('cmn.must_be_in_integer'),
        ];
    }

}
