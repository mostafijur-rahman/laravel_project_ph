

        // if($request->input('report_name') == 'company_billing'){

//     $report_name = $request->input('report_name');

//     if($report_name == 'company_billing'){
//         $data['title'] = __('cmn.company_billing');
//     }

//     $query = Trip::query()->with('company','provider');

//     // ->whereHas('company', function($subQuery) {
//     //     $subQuery->where('due_fair','>',0);
//     // });
//     // if($request->input('number')){
//     //     $query = $query->where('trip_id', $request->input('number'));
//     // }
//     if($request->input('trip_number')){
//         $query = $query->where('number', $request->input('trip_number'));
//     }
//     if($request->input('vehicle_number')){
//         $query = $query->whereHas('provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_number', 'like', '%' . $request->input('vehicle_number') . '%');
//         });
//     }

//     if($request->input('company_id')){
//         $query->whereHas('company', function($subQuery) use($request) {
//                 $subQuery->where('company_id',$request->input('company_id'));
//         });
//         $company = SettingCompany::where('id', $request->input('company_id'))->select('name')->first();
//         $data['title'] .= ' - (' . __('cmn.company_name') .'- ' .$company->name. ')';
//     }

    
//     if($date_range_status == 'date_wise' && $daterange){
    
//         $date = explode(' - ', $daterange);
//         $start_date = Carbon::parse($date[0])->startOfDay();
//         $end_date = Carbon::parse($date[1])->endOfDay();
//         $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
        
//         $query = $query->whereBetween('date', [$start_date, $end_date]);
//     }
//     // mothly report start
//     if($date_range_status == 'monthly_report'){
//         if(!$month){
//             Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         $month_name = CommonService::getMonthNameByMonthId($month);
//         $data['title'] .= ' - (' . __('cmn.month') .'- ' .$month_name. ', ' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//         $query = $query->whereMonth('date',$month)->whereYear('date',$year);
//     }
//     // monthly report end
//     // yearly report start
//     if($date_range_status == 'yearly_report'){
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//         // expense -----
//         $query = $query->whereYear('date',$year);
//     }
//     // yearly_report_end
//     if($request->input('vehicle_id')){
//         $query = $query->whereHas('provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_id', $request->input('vehicle_id')); 
//         });
//     }

//     $data['lists'] = $query->orderBy('date','desc')->get();
//     $pdf = PDF::loadView('company.report.company_billing_report_pdf', $data);
//     if($request->input('download_pdf') == 'true'){
//         return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
//     } else {
//         return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
//     }
// }




//     // query
// // $data['challans'] = TripChallan::where('for', 'company_trip')->orderBy('date', 'desc')->Paginate(10
// if($request->input('type') == 'chalan_due'){
    
//     // if($request->input('number')){
//     //     $query = $query->where('trip_id', $request->input('number'));
//     // }
//     if($request->input('trip_number')){

//         $query = $query->where('number', $request->input('trip_number'));
    
//     }
//     if($request->input('vehicle_number')){

//         $query = $query->whereHas('provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_number', $request->input('vehicle_number')); 
//     });
    
//     }
//     if($date_range_status == 'date_wise' && $daterange){
    
//         $date = explode(' - ', $daterange);
//         $start_date = Carbon::parse($date[0])->startOfDay();
//         $end_date = Carbon::parse($date[1])->endOfDay();
//         $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
        
//         $query = $query->whereBetween('date', [$start_date, $end_date]);
//     }
//     // mothly report start
//     if($date_range_status == 'monthly_report'){
//         if(!$month){
//             Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         $month_name = CommonService::getMonthNameByMonthId($month);
//         $data['title'] .= ' - (' . __('cmn.month') .'- ' .$month_name. ', ' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//         $query = $query->whereMonth('date',$month)->whereYear('date',$year);
//     }
//     // monthly report end
//     // yearly report start
//     if($date_range_status == 'yearly_report'){
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//         // expense -----
//         $query = $query->whereYear('date',$year);
//     }
//     // yearly_report_end
//     if($request->input('vehicle_id')){

//         $query = $query->whereHas('provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_id', $request->input('vehicle_id')); 
//         });
//     }
//     $data['trips'] = $query->orderBy('date','desc')->get();
//     // dd($data['lists']);

    
// }




// if($request->input('type') == 'chalan_paid'){
//     $query = TripChallan::with('trip')->where('for', 'company_trip');
//     // if($request->input('number')){
//     //     $query = $query->where('trip_id', $request->input('number'));
//     // }
//     if($request->input('trip_number')){

//         $query = $query->whereHas('trip', function($subQuery) use($request) {
//             $subQuery->where('number', $request->input('trip_number'));  
//     });

//     }
//     if($request->input('vehicle_number')){

//         $query = $query->whereHas('trip.provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_number', $request->input('vehicle_number')); 
//     });

//     }
//     if($date_range_status == 'date_wise' && $daterange){

//         $date = explode(' - ', $daterange);
//         $start_date = Carbon::parse($date[0])->startOfDay();
//         $end_date = Carbon::parse($date[1])->endOfDay();
//         $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
    
//         $query = $query->whereBetween('date', [$start_date, $end_date]);
//     }
//     // mothly report start
//     if($date_range_status == 'monthly_report'){
//         if(!$month){
//             Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }

//             $month_name = CommonService::getMonthNameByMonthId($month);
//             $data['title'] .= ' - (' . __('cmn.month') .'- ' .$month_name. ', ' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//             $query = $query->whereMonth('date',$month)->whereYear('date',$year); 
    
//     }
//     // monthly report end
//     // yearly report start
//     if($date_range_status == 'yearly_report'){
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//         // expense -----
//         $query = $query->whereYear('date',$year);
//     }
//     // yearly_report_end
//     if($request->input('vehicle_id')){

//         $query = $query->whereHas('trip.provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_id', $request->input('vehicle_id')); 
//         });
//     }
//     $data['lists'] = $query->orderBy('date','desc')->get();
//     // dd($data['lists']);

//     $pdf = PDF::loadView('company.report.company_pdf', $data);
//     if($request->input('download_pdf') == 'true'){
//         return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
//     } else {
//         return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
//     }
// }




// if($request->input('type') == 'demarage_due'){
//     $query = Trip::query()->with('vehicle','getTripsByGroupId')->whereHas('company', function($subQuery) {
//         $subQuery->where('demarage_due','>',0);
//     });
//     // if($request->input('number')){
//     //     $query = $query->where('trip_id', $request->input('number'));
//     // }
//     if($request->input('trip_number')){

//         $query = $query->where('number', $request->input('trip_number'));

//     }
//     if($request->input('vehicle_number')){

//         $query = $query->whereHas('provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_number', $request->input('vehicle_number')); 
//     });

//     }
//     if($date_range_status == 'date_wise' && $daterange){

//         $date = explode(' - ', $daterange);
//         $start_date = Carbon::parse($date[0])->startOfDay();
//         $end_date = Carbon::parse($date[1])->endOfDay();
//         $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
    
//         $query = $query->whereBetween('date', [$start_date, $end_date]);
//     }
//     // mothly report start
//     if($date_range_status == 'monthly_report'){
//         if(!$month){
//             Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }

//             $month_name = CommonService::getMonthNameByMonthId($month);
//             $data['title'] .= ' - (' . __('cmn.month') .'- ' .$month_name. ', ' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//             $query = $query->whereMonth('date',$month)->whereYear('date',$year); 
//     }
//     // monthly report end
//     // yearly report start
//     if($date_range_status == 'yearly_report'){
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//         // expense -----
//         $query = $query->whereYear('date',$year);
//     }
//     // yearly_report_end
//     if($request->input('vehicle_id')){

//         $query = $query->whereHas('provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_id', $request->input('vehicle_id')); 
//         });
//     }
//     $data['trips'] = $query->orderBy('date','desc')->get();
//     // dd($data['lists']);

//     $pdf = PDF::loadView('company.report.chalan_due_pdf', $data);
//     if($request->input('download_pdf') == 'true'){
//         return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
//     } else {
//         return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
//     }
// }





// if($request->input('type') == 'demarage_paid'){
//     $query = TripChallan::with('trip')->where('for', 'company_demarage');
//     // if($request->input('number')){
//     //     $query = $query->where('trip_id', $request->input('number'));
//     // }
//     if($request->input('trip_number')){

//         $query = $query->whereHas('trip', function($subQuery) use($request) {
//             $subQuery->where('number', $request->input('trip_number'));  
//     });

//     }
//     if($request->input('vehicle_number')){

//         $query = $query->whereHas('trip.provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_number', $request->input('vehicle_number')); 
//     });

//     }
//     if($date_range_status == 'date_wise' && $daterange){

//         $date = explode(' - ', $daterange);
//         $start_date = Carbon::parse($date[0])->startOfDay();
//         $end_date = Carbon::parse($date[1])->endOfDay();
//         $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
    
//         $query = $query->whereBetween('date', [$start_date, $end_date]);
//     }
//     // mothly report start
//     if($date_range_status == 'monthly_report'){
//         if(!$month){
//             Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }

//             $month_name = CommonService::getMonthNameByMonthId($month);
//             $data['title'] .= ' - (' . __('cmn.month') .'- ' .$month_name. ', ' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//             $query = $query->whereMonth('date',$month)->whereYear('date',$year); 
//     }
//     // monthly report end
//     // yearly report start
//     if($date_range_status == 'yearly_report'){
//         if(!$year){
//             Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
//             return redirect()->back();
//         }
//         $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
//         // expense -----
//         $query = $query->whereYear('date',$year);
//     }
//     // yearly_report_end
//     if($request->input('vehicle_id')){

//         $query = $query->whereHas('trip.provider', function($subQuery) use($request) {
//             $subQuery->where('vehicle_id', $request->input('vehicle_id')); 
//         });
//     }
//     $data['lists'] = $query->orderBy('date','desc')->get();
//     // dd($data['lists']);

//     $pdf = PDF::loadView('company.report.company_pdf', $data);
//     if($request->input('download_pdf') == 'true'){
//         return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
//     } else {
//         return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
//     }
// }

// 31 july 2022
// Multi trip transection TripTransectionRequest
    // public function duePaymentReceivedFromCompany(Request $request){

    //     dd($request);

    //     try {
    //         DB::beginTransaction();
    //         $amount = $request->input('amount');
    //         $trip_id = $request->input('trip_id');
    //         $date = $request->input('date');
    //         $recipients_name = $request->input('recipients_name');
    //         $recipients_phone = $request->input('recipients_phone');
    //         $payment_type = $request->input('payment_type');

    //         if($trip_id){



    //             $query = TripCompany::query()->whereIn('trip_id', $trip_id);


    //             if($payment_type=='challan_due'){
    //                 $query = $query->where('due_fair', '>', 0);
    //             } else {
    //                 $query = $query->where('demarage_due', '>', 0);
    //             }
    //             $tripCompanies = $query->get();
    //         }

    //         $due_amount_sum = ($payment_type=='challan_due')?$tripCompanies->sum('due_fair'):$tripCompanies->sum('demarage_due');

    //         if($due_amount_sum == 0){
    //             Toastr::error('', __('cmn.no_due'));
    //             return redirect()->back();
    //         }
            
    //         if($amount != $due_amount_sum){
    //             Toastr::error('', 'গ্রহণ করতে হবে '.number_format($due_amount_sum).' টাকা আর আপনি পোস্টিং দিচ্ছেন '. number_format($amount) .' টাকা, তাই পোস্টিং টি গ্রহণ যোগ্য হলো না !');
    //             return redirect()->back();
    //         }


    //         if(count($tripCompanies)>0){
    //             $due_amount = 0;
    //             foreach ($tripCompanies as $tripCompany) {
    //                 $due_amount = ($payment_type=='challan_due')?$tripCompany->due_fair:$tripCompany->demarage_due;
    //                 Toastr::success('', 'ট্রিপের বিল হিসাবে '. number_format($due_amount) .' টাকা গ্রহণ করা হল');
    //                 Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
                    
    //                 if($payment_type=='challan_due'){
    //                     $tripCompany->received_fair += $due_amount; // increase deposit
    //                     $tripCompany->due_fair = 0; // decrease due
    //                     $for = 'challan_bill_has_been_received_from_the_company_for_the_trip';
    //                 } else {
    //                     $tripCompany->demarage_received += $due_amount;
    //                     $tripCompany->demarage_due = 0; // decrease due
    //                     $for = 'demarage_has_been_received_from_the_company_for_the_trip';
    //                 }
    //                 $tripCompany->save();

    //                 // transection
    //                 $trans['account_id'] = $request->input('account_id');
    //                 $trans['amount'] = $due_amount;
    //                 $trans['type'] = 'in';
    //                 $trans['date'] = $date;
    //                 $trans['transactionable_id'] = $tripCompany->trip_id;
    //                 $trans['transactionable_type'] = 'trip';
    //                 $trans['for'] = $for;
    //                 $transaction = $this->transaction($trans);

    //                 // pivot table transection
    //                 $tripChallanModel = new TripChallan();
    //                 $tripChallanFillData = collect($request->only($tripChallanModel->getFillable()));
    //                 $tripChallanFinalData = $tripChallanFillData->merge(['trip_id' => $tripCompany->trip_id,
    //                                                     'account_transection_id' => $transaction->id,
    //                                                     'for'=> ($payment_type=='challan_due')?'company_trip':'company_demarage'])->toArray();
    //                 $tripChallanModel->create($tripChallanFinalData);

    //                 // account update
    //                 $account = Account::where('id', $trans['account_id']);
    //                 $account->increment('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);

    //                 // amount re-calculate
    //                 $amount -= ($payment_type=='challan_due')?$tripCompany->due_fair:$tripCompany->demarage_due;
    //             }
    //         } else {
    //             Toastr::error('', __('cmn.must_select_trip'));
    //             return redirect()->back();
    //         }
    //         DB::commit();
    //         return redirect()->back();
    //     }catch (ModelNotFoundException $e) {
    //         DB::rollback();
    //         dd($e->message());
    //         Toastr::error(__('cmn.sorry'), $e->message());
    //         return redirect()->back();
    //     }
    // }
