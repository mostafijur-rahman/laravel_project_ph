<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class VehicleRequest extends FormRequest
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

    public function rules(Request $request)
    {
        // $rules = [
        //     'gender' => 'required',
        // ];

        if(Request::isMethod('post')){

            if($request->input('number_plate')){
                $rules['number_plate'] = 'unique:setting_vehicles,number_plate,NULL,id,deleted_at,NULL'; // required
            }

        } else {

            if($request->input('number_plate')){
                $rules['number_plate'] = 'unique:setting_vehicles,number_plate,' . $request->input('setting_vehicle_id') . ',id,deleted_at,NULL'; // required
            }

        }

        return $rules;

    }

    public function attributes()
    {
        return [
            'number_plate' => __('cmn.number_plate'),
        ];
    }

    public function messages()
    {
        return [

            'number_plate.required' => __('cmn.must_be_required'), 
            'number_plate.unique' => __('cmn.already_exist_must_be_unique'), 
            
        ];
    }
}
