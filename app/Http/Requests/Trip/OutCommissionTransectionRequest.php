<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;


class OutCommissionTransectionRequest extends FormRequest
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

        if(Request::isMethod('post')){
            $rule['number'] = 'required | unique:trips,number,NULL,id,deleted_at,NULL';
            $rule['account_take_date'] =  'required | date_format:d/m/Y';
        } else {
            $rule['number'] = 'required | unique:trips,number,' . $request->input('trip_id') . ',id,deleted_at,NULL';
        }
    
        // common
        $rule['ownership'] = 'required | string';
        $rule['vehicle_number'] = 'required | string';

        // others
        $rule['date'] = 'required | date_format:d/m/Y';

        $rule['load_id'] = 'required';
        $rule['unload_id'] = 'required';

        $rule['buyer_name'] = 'nullable | max:250';
        $rule['buyer_code'] = 'nullable | max:250';
        $rule['order_no'] = 'nullable | max:250';
        $rule['depu_change_bill'] = 'nullable | numeric | min:-1';
        $rule['gate_pass_no'] = 'nullable | max:250';
        $rule['lock_no'] = 'nullable | max:250';
        $rule['load_point_reach_time'] = 'nullable'; // need to add format
        
        $rule['box'] = 'nullable | numeric';
        $rule['weight'] = 'nullable | numeric';
        $rule['unit_id'] = 'nullable | integer';
        $rule['goods'] = 'nullable |  max:250';
        $rule['note'] = 'nullable';

        // provider
        $rule['vehicle_number'] = 'nullable | string | max:250';
        $rule['driver_name'] = 'nullable | string | max:250';
        $rule['driver_phone'] = 'nullable | string | max:250';
        $rule['owner_name'] = 'nullable | string | max:250';
        $rule['owner_phone'] = 'nullable | string | max:250';
        $rule['reference_name'] = 'nullable | string | max:250';
        $rule['reference_phone'] = 'nullable | string | max:250';

        $rule['contract_fair'] = 'required | numeric | min:-1 | gte:advance_fair'; // not_in:0, min:0
        $rule['advance_fair'] = 'required | numeric | min:-1 | lte:contract_fair';
        $rule['account_id'] = 'required | integer';


        // company
        $rule['company_id'] = 'required | integer';
        $rule['com_contract_fair'] = 'required | numeric | min:-1 | gte:com_advance_fair'; // not_in:0, min:0
        $rule['com_advance_fair'] = 'required | numeric | min:-1 | lte:com_contract_fair';
        $rule['com_account_id'] = 'required | integer';

        return $rule;

    }


    public function attributes()
    {
        return [

            // common
            'number' => __('cmn.challan_number'),
            'account_take_date' => __('cmn.account_receiving_date'),
            'ownership' => __('cmn.ownership'),
            'vehicle_number' => __('cmn.vehicle_number'),
            'date' => __('cmn.date'),
            'load_id' => __('cmn.load_point'),
            'unload_id' => __('cmn.unload_point'),

            'buyer_name' => __('cmn.buyer_name'),
            'buyer_code' => __('cmn.buyer_code'),
            'order_no' => __('cmn.order_no'),
            'depu_change_bill' => __('cmn.depu_change_bill'),
            'gate_pass_no' => __('cmn.gate_pass_no'),
            'lock_no' => __('cmn.lock_no'),
            'load_point_reach_time' => __('cmn.load_point_reach_time'),
            'box' => __('cmn.box_qty'),
            'weight' => __('cmn.weight'),
            'unit_id' => __('cmn.unit'),
            'goods' => __('cmn.goods'),
            'note' => __('cmn.note'),

            // provider
            'vehicle_number' => __('cmn.vehicle_number'),
            'driver_name' => __('cmn.driver_name'),
            'driver_phone' => __('cmn.driver_phone'),
            'owner_name' => __('cmn.owner_name'),
            'owner_phone' => __('cmn.owner_phone'),
            'reference_name' => __('cmn.reference_name'),
            'reference_phone' => __('cmn.reference_phone'),
            
            'contract_fair' => __('cmn.contract_fair'),
            'advance_fair' => __('cmn.advance_fair'),
            'account_id' => __('cmn.account_id'),

            // company
            'company_id' => __('cmn.company'),
            'com_contract_fair' => __('cmn.contract_rent'),
            'com_advance_fair' => __('cmn.received_rent'),
            'com_account_id' => __('cmn.accounts'),

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

            'date.required' => __('cmn.please_select_start_date'),
            'date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),

            'load_id.required' => __('cmn.please_select_load_point'),
            'unload_id.required' => __('cmn.please_select_unload_point'),

            'buyer_name.max' => __('cmn.max_250_character_allowed'),
            'buyer_code.max' => __('cmn.max_250_character_allowed'),
            'order_no.max' => __('cmn.max_250_character_allowed'),

            'depu_change_bill.numeric' => __('cmn.must_be_in_numeric'),
            'depu_change_bill.min' => __('cmn.give_the_correct_amount'),

            'gate_pass_no.max' => __('cmn.max_250_character_allowed'),
            'lock_no.max' => __('cmn.max_250_character_allowed'),

            'box.numeric' => __('cmn.please_provide_number_value'),
            'weight.numeric' => __('cmn.please_provide_number_value'),
            'unit_id.integer' => __('cmn.please_select_unit'),
            'goods.max' => __('cmn.max_250_character_allowed'),
            
            // provider
            'vehicle_number.max' => __('cmn.max_250_character_allowed'),
            'driver_name.max' => __('cmn.max_250_character_allowed'),
            'driver_phone.max' => __('cmn.max_250_character_allowed'),
            'owner_name.max' => __('cmn.max_250_character_allowed'),
            'owner_phone.max' => __('cmn.max_250_character_allowed'),
            'reference_name.max' => __('cmn.max_250_character_allowed'),
            'reference_phone.max' => __('cmn.max_250_character_allowed'),

            'contract_fair.required' => __('cmn.must_be_required'),
            'contract_fair.numeric' => __('cmn.must_be_in_numeric'),
            'contract_fair.min' => __('cmn.give_the_correct_amount'),
            'contract_fair.gte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),

            'advance_fair.required' => __('cmn.must_be_required'),
            'advance_fair.numeric' => __('cmn.must_be_in_numeric'),
            'advance_fair.min' => __('cmn.give_the_correct_amount'),
            'advance_fair.lte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),

            'account_id.required' => __('cmn.must_be_required'),
            'account_id.integer' => __('cmn.must_be_in_integer'),

            // company
            'company_id.required' => __('cmn.company_must_be_required'),
            'company_id.integer' => __('cmn.must_be_in_integer'),

            'com_contract_fair.required' => __('cmn.must_be_required'),
            'com_contract_fair.numeric' => __('cmn.must_be_in_numeric'),
            'com_contract_fair.min' => __('cmn.give_the_correct_amount'),
            // 'com_contract_fair.not_in' => __('cmn.minus_amount_cannot_be_given'),
            'com_contract_fair.gte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),

            'com_advance_fair.required' => __('cmn.must_be_required'),
            'com_advance_fair.numeric' => __('cmn.must_be_in_numeric'),
            'com_advance_fair.min' => __('cmn.give_the_correct_amount'),
            // 'com_advance_fair.not_in' => __('cmn.minus_amount_cannot_be_given'),
            'com_advance_fair.lte' => __('cmn.the_amount_of_advance_rent_is_more_than_the_amount_of_contract_rent'),

            'com_account_id.required' => __('cmn.must_be_required'),
            'com_account_id.integer' => __('cmn.must_be_in_integer'),
        ];
    }

}


