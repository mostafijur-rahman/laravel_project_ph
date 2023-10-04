<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;


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
    public function rules(Request $request)
    {
        // is exist group id then treat this request as down trip
        if($request->has('group_id')){

            // just check that is exist challan number or not
            $rule['group_id'] = 'required | integer';
            $rule['number'] = 'required | unique:trips,number,' . $request->input('number') . ',id,deleted_at,NULL';
            $rule['account_take_date'] =  'required | date_format:d/m/Y';

        }

        // then this request treat as up challan / new challan
        else{

            $rule['number'] = 'required | unique:trips,number,NULL,id,deleted_at,NULL';
            $rule['account_take_date'] =  'required | date_format:d/m/Y';

        }

        // we will use this code for update value 
        // post = create
        // if(Request::isMethod('post')){
        //     $rule['number'] = 'required | unique:trips,number,NULL,id,deleted_at,NULL';
        //     $rule['account_take_date'] =  'required | date_format:d/m/Y';
        // // put = update
        // } else {
        //     $rule['number'] = 'required | unique:trips,number,' . $request->input('trip_id') . ',id,deleted_at,NULL';
        // }

        // common
        $rule['ownership'] = 'required | string';
        $rule['vehicle_id'] = 'required | integer';

        // others
        $rule['date'] = 'required | date_format:d/m/Y';
        $rule['driver_id'] = 'required | integer';
        $rule['helper_id'] = 'nullable | integer';
        $rule['load_id'] = 'required';
        $rule['unload_id'] = 'required';

        $rule['buyer_name'] = 'nullable | max:250';
        $rule['buyer_code'] = 'nullable | max:250';
        $rule['order_no'] = 'nullable | max:250';
        $rule['depu_change_bill'] = 'nullable | numeric';
        $rule['gate_pass_no'] = 'nullable | max:250';
        $rule['lock_no'] = 'nullable | max:250';
        $rule['load_point_reach_time'] = 'nullable'; // need to add format
        
        $rule['box'] = 'nullable | numeric';
        $rule['weight'] = 'nullable | numeric';
        $rule['unit_id'] = 'nullable | integer';
        $rule['goods'] = 'nullable |  max:250';
        $rule['note'] = 'nullable';

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
            'group_id' => __('cmn.group_id'),
            'account_take_date' => __('cmn.account_receiving_date'),
            'ownership' => __('cmn.ownership'),
            'vehicle_id' => __('cmn.vehicle'),

            // up challan
            'date' => __('cmn.date'),
            'driver_id' => __('cmn.driver'),
            'helper_id' => __('cmn.helper'),
            'load_id' => __('cmn.load_point'),
            'unload_id' => __('cmn.unload_point'),

            'box' => __('cmn.box_qty'),
            'weight' => __('cmn.weight'),
            'unit_id' => __('cmn.unit'),
            'goods' => __('cmn.goods'),
            'note' => __('cmn.note'),

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

            'group_id.required' => __('cmn.must_be_required'),
            'group_id.integer' => __('cmn.must_be_in_integer'),

            'account_take_date.required' => __('cmn.account_take_date_required'),
            'account_take_date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),
            
            'ownership.required' => __('cmn.ownership_must_be_required'),
            'ownership.string' => __('cmn.ownership_must_be_required'),

            'vehicle_id.required' => __('cmn.vehicle_must_be_required'),
            'vehicle_id.integer' => __('cmn.vehicle_must_be_required'),


            // up challan
            'date.required' => __('cmn.please_select_start_date'),
            'date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),
            
            'driver_id.required' => __('cmn.driver_must_be_required'),
            'driver_id.integer' => __('cmn.driver_must_be_required'),

            'helper_id.integer' => '',

            'load_id.required' => __('cmn.please_select_load_point'),
            // 'up_load_id.integer' => __('cmn.please_select_load_point'),

            'unload_id.required' => __('cmn.please_select_unload_point'),
            // 'up_unload_id.integer' => __('cmn.please_select_unload_point'),

            'box.numeric' => __('cmn.please_provide_number_value'),
            'weight.numeric' => __('cmn.please_provide_number_value'),
            'unit_id.integer' => __('cmn.please_select_unit'),
            'goods.max' => __('cmn.max_250_character_allowed'),

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


