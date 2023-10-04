<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StaffRequest extends FormRequest
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
        $rules = [
            'gender' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => '',
            'father_name' => '', // required
            'mother_name' => '',
            'spouse_name' => '',
            'present_address' => '', // required
            'permanent_address' => '',
            'dob' => 'required | date_format:d/m/Y',
            'joining_date' => 'required | date_format:d/m/Y',
            'blood_group' => '',
            'note' => '',
            'designation_id' => '',
            'driving_license_number' => '', // unique
            'passport_number' => '',
            'birth_certificate_number' => '',
            'port_id' => '',
            'bank_id' => '',
            'bank_account_number' => '',
            'salary_amount' => '',
            'termination_date' => 'nullable',
            'reference_name' => '', // required
            'reference_phone' => '', // required
            'reference_nid_number' => '',
            'reference_present_address' => '',
        ];

        if(Request::isMethod('post')){

            if($request->input('company_id')){
                $rules['company_id'] = 'unique:setting_staffs,company_id,NULL,id,deleted_at,NULL'; // required
            }
            if($request->input('nid_number')){
                $rules['nid_number'] = 'unique:setting_staffs,nid_number,NULL,id,deleted_at,NULL'; // required
            }

        } else {

            if($request->input('company_id')){
                $rules['company_id'] = 'unique:setting_staffs,company_id,' . $request->input('setting_staff_id') . ',id,deleted_at,NULL'; // required
            }
            if($request->input('nid_number')){
                $rules['nid_number'] = 'unique:setting_staffs,nid_number,' . $request->input('setting_staff_id') . ',id,deleted_at,NULL'; // required
            }

        }

        return $rules;

    }

    public function attributes()
    {
        return [
            'gender' => __('cmn.gender'),
            'name' => __('cmn.name'),
            'phone' => __('cmn.phone'),
            'email' => __('cmn.email'),
            'father_name' => __('cmn.father_name'),
            'mother_name' => __('cmn.mother_name'),
            'spouse_name' => __('cmn.spouse_name'),
            'present_address' => __('cmn.present_address'),
            'permanent_address' => __('cmn.permanent_address'),
            'dob' => __('cmn.date_of_birth'),
            'joining_date' => __('cmn.joining_date'),
            'blood_group' => __('cmn.blood_group'),
            'note' => __('cmn.note'),
            'designation_id' => __('cmn.designation'),
            'driving_license_number' => __('cmn.driving_license_number'),
            'passport_number'=> __('cmn.passport_number'),
            'birth_certificate_number'=> __('cmn.birth_certificate_number'),
            'port_id' =>__('cmn.port_id'),
            'bank_id' => __('cmn.bank'),
            'bank_account_number' => __('cmn.bank_account_number'),
            'salary_amount' => __('cmn.salary_amount'),
            'termination_date' => __('cmn.termination_date'),

            'reference_name' => __('cmn.reference'),
            'reference_phone' => __('cmn.phone'),
            'reference_nid_number' => __('cmn.nid_number'),
            'reference_present_address' => __('cmn.present_address'),

            'nid_number' => __('cmn.nid_number'),
            'company_id' => __('cmn.company_id'),
        ];
    }

    public function messages()
    {
        return [
            'gender.required' => __('cmn.must_be_required'), 
            'name.required' => __('cmn.must_be_required'), 
            'phone.required' => __('cmn.must_be_required'), 
            'father_name.required' => __('cmn.must_be_required'), 
            'present_address.required' => __('cmn.must_be_required'), 

            'dob.required' => __('cmn.must_be_required'), 
            'dob.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),

            'joining_date.required' => __('cmn.must_be_required'), 
            'joining_date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),

            'termination_date.date_format' => __('cmn.date_provide_with_this_format_dd_mm_YY'),

            'reference_name.required' => __('cmn.must_be_required'), 
            'reference_phone.required' => __('cmn.must_be_required'), 

            'company_id.required' => __('cmn.must_be_required'), 
            'company_id.unique' => __('cmn.already_exist_must_be_unique'), 

            'nid_number.required' => __('cmn.must_be_required'), 
            'nid_number.unique' => __('cmn.already_exist_must_be_unique'), 
            
        ];
    }
}
