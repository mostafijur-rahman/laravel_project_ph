<?php

// import class
use Carbon\Carbon;
use App\Trip;
use App\Models\Expenses\Expense;

/**
 * for any single value
 * @author MR
 */
function hybrid_first($table,$column,$case,$select) {
    $result = DB::table("$table")
            ->where("$column", $case)
            ->select($select)
            ->first();
    if (isset($result->$select)) {
        return $result->$select;
    } else {
        return null;
    }
}
/**
* This function is used get any single row data
* @author Mostafijur Rahman
*/
function hybrid_first_all($table,$column,$case,$select) {
    $result = DB::table("$table")
            ->where("$column", $case)
            ->select("$select")
            ->first();
    if (isset($result)) {
        return $result;
    } else {
        return null;
    }
}
/**
* This function is used get any multi row data
* @author Mostafijur Rahman
*/
function hybrid_get($table,$column,$case,$select,$asc_desc_select,$asc_desc) {
    $result = DB::table("$table")
            ->where("$column", $case)
            ->select("$select")
            ->orderBy($asc_desc_select,"$asc_desc")
            ->get();
    if (isset($result)) {
        return $result;
    } else {
        return [];
    }
}

function tripOilBillSumByTripNumber($tripNumber) {
    $result = DB::table('trips')
                ->join('trip_oil_expenses','trips.id','=','trip_oil_expenses.trip_id')
                ->select(
                    DB::raw('sum(bill) as sum_bill')
                )
                ->where('trips.number',$tripNumber)
                ->first();
    if ($result->sum_bill) {
        return $result->sum_bill;
    } else {
        return 0;
    }
}

function tripOilBillSumByGroupId($groupId) {
    $result = DB::table('trips')
                ->join('trip_oil_expenses','trips.id','=','trip_oil_expenses.trip_id')
                ->select(
                    DB::raw('sum(bill) as sum_bill')
                )
                ->where('trips.group_id',$groupId)
                ->whereNull('trip_oil_expenses.deleted_at')
                ->first();
    if ($result->sum_bill) {
        return $result->sum_bill;
    } else {
        return 0;
    }
}

function tripOilBillSumByTripId($tripId) {
    $result = DB::table('trips')
                ->join('trip_oil_expenses','trips.id','=','trip_oil_expenses.trip_id')
                ->select(
                    DB::raw('sum(bill) as sum_bill')
                )
                ->where('trips.id',$tripId)
                ->whereNull('trip_oil_expenses.deleted_at')
                ->first();
    if ($result->sum_bill) {
        return $result->sum_bill;
    } else {
        return 0;
    }
}

function tripOilLiterSumByGroupId($groupId) {
    $result = DB::table('trips')
                ->join('trip_oil_expenses','trips.id','=','trip_oil_expenses.trip_id')
                ->select(
                    DB::raw('sum(liter) as sum_liter')
                )
                ->where('trips.group_id',$groupId)
                ->whereNull('trip_oil_expenses.deleted_at')
                ->first();
    if ($result->sum_liter) {
        return $result->sum_liter;
    } else {
        return 0;
    }
}

function tripOilLiterSumByTripId($tripId) {
    $result = DB::table('trips')
                ->join('trip_oil_expenses','trips.id','=','trip_oil_expenses.trip_id')
                ->select(
                    DB::raw('sum(liter) as sum_liter')
                )
                ->where('trips.id',$tripId)
                ->whereNull('trip_oil_expenses.deleted_at')
                ->first();
    if ($result->sum_liter) {
        return $result->sum_liter;
    } else {
        return 0;
    }
}

// function tripGeneralExpenseSumByTripNumber($tripNumber) {
//     $result = DB::table('trips')
//                 ->join('trip_general_expenses','trips.id','=','trip_general_expenses.trip_id')
//                 ->select(
//                     DB::raw('sum(amount) as sum_amount')
//                 )
//                 ->where('trips.number',$tripNumber)
//                 ->first();
//     if ($result->sum_amount) {
//         return $result->sum_amount;
//     } else {
//         return 0;
//     }
// }

function tripExpenseSumByGroupId($groupId) {
    $result = DB::table('trips')
                ->join('expenses','trips.id','=','expenses.trip_id')
                ->select(
                    DB::raw('sum(amount) as sum_amount')
                )
                ->whereNull('expenses.deleted_at')
                ->where('trips.group_id',$groupId)
                ->first();
    if ($result->sum_amount) {
        return $result->sum_amount;
    } else {
        return 0;
    }
}

function tripExpenseSumByTripId($tripId) {
    $result = DB::table('trips')
                ->join('expenses','trips.id','=','expenses.trip_id')
                ->select(
                    DB::raw('sum(amount) as sum_amount')
                )
                ->whereNull('expenses.deleted_at')
                ->where('trips.id',$tripId)
                ->first();
    if ($result->sum_amount) {
        return $result->sum_amount;
    } else {
        return 0;
    }
}


// function tripGeneralExpenseListByTripNumber($tripNumber) {
//     $result = DB::table('trips')
//                 ->join('trip_general_expenses','trips.id','=','trip_general_expenses.trip_id')
//                 ->join('setting_general_expenses','trip_general_expenses.general_expense_id','=','setting_general_expenses.id')
//                 ->select(
//                     DB::raw('trip_general_expenses.trip_id,
//                             setting_general_expenses.head,
//                             sum(trip_general_expenses.amount) as trip_general_single_expense_sum')
//                 )
//                 ->where('trips.number',$tripNumber)
//                 ->groupBy('trip_general_expenses.trip_id','setting_general_expenses.head')
//                 ->get()
//                 ->toArray();        
//     if (isset($result[0])) {
//         return $result;
//     } else {
//         return false;
//     }
// }

function tripExpenseListSumByGroupId($groupId) {
    $result = DB::table('trips')
                ->join('expenses','trips.id','=','expenses.trip_id')
                ->join('setting_expenses','expenses.expense_id','=','setting_expenses.id')
                ->select(
                    DB::raw('expenses.trip_id,
                            setting_expenses.head,
                            sum(expenses.amount) as trip_single_expense_sum')
                )
                ->where('trips.group_id', $groupId)
                ->whereNull('expenses.deleted_at')
                ->groupBy('expenses.trip_id','setting_expenses.head')
                ->get()
                ->toArray();        
    if (isset($result[0])) {
        return $result;
    } else {
        return false;
    }
}

function tripExpenseListSumByTripId($tripId) {
    $result = DB::table('trips')
                ->join('expenses','trips.id','=','expenses.trip_id')
                ->join('setting_expenses','expenses.expense_id','=','setting_expenses.id')
                ->select(
                    DB::raw('expenses.trip_id,
                            setting_expenses.head,
                            sum(expenses.amount) as trip_single_expense_sum')
                )
                ->where('trips.id', $tripId)
                ->whereNull('expenses.deleted_at')
                ->groupBy('expenses.trip_id','setting_expenses.head')
                ->get()
                ->toArray();        
    if (isset($result[0])) {
        return $result;
    } else {
        return false;
    }
}

function tripExpenseListsByTripId($tripId) {
    $result = DB::table('trips')
                ->join('expenses','trips.id','=','expenses.trip_id')
                ->join('setting_expenses','expenses.expense_id','=','setting_expenses.id')
                ->select(
                    DB::raw('expenses.*,setting_expenses.head')
                )
                ->where('trips.id', $tripId)
                ->whereNull('expenses.deleted_at')
                ->get()
                ->toArray();
    if (isset($result[0])) {
        return $result;
    } else {
        return false;
    }
}

function tripExpenseListsByGroupId($groupId) {
    $result = DB::table('trips')
                ->join('expenses','trips.id','=','expenses.trip_id')
                ->join('setting_expenses','expenses.expense_id','=','setting_expenses.id')
                ->select(
                    DB::raw('expenses.*,setting_expenses.head')
                )
                ->where('trips.group_id', $groupId)
                ->whereNull('expenses.deleted_at')
                ->get()
                ->toArray();
    if (isset($result[0])) {
        return $result;
    } else {
        return false;
    }
}
// function trip_common_expense_sum_by_trip_no($trip_no) {
//     $result = DB::table('trip_common_expenses')
//                 ->where('trip_common_expenses.trip_no',$trip_no)
//                 ->sum('trip_comn_exp_amount');
//     if (isset($result)) {
//         return $result;
//     } else {
//         return 0;
//     }
// }
function trip_received_fair_sum_by_trip_no($trip_no) {
    $result = DB::table('trips')
                ->where('trip_no',$trip_no)
                ->sum('trip_received_fair');
    if ($result) {
        return $result;
    } else {
        return 0;
    }
}
// function trip_oil_liter_sum_by_trip_no($trip_no) {
//     $result = DB::table('trip_oil_expenses')
//                 ->where('trip_no',$trip_no)
//                 ->select(
//                     DB::raw('sum(trip_oil_exp_liter) as sum_oil_liter')
//                 )
//                 ->first();
//     if ($result->sum_oil_liter) {
//         return $result->sum_oil_liter;
//     } else {
//         return 0;
//     }
// }

/* -----------------------------------------------------
transport section
----------------------------------------------------- */
function get_transport_cost($trip_id) {
    $result = DB::table('transport_common_expenses')
                ->join('common_expenses','transport_common_expenses.exp_id','=','common_expenses.exp_id')
                ->where('trip_id',$trip_id)
                ->select('transport_common_expenses.trip_comn_exp_amount', 'common_expenses.exp_head')
                ->get();
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

/* -----------------------------------------------------
deposite expense report
----------------------------------------------------- */
function get_expense_sum_by_exp_type_exp_id_and_daterange($exp_type, $exp_id, $date_range, $status){
    // date separate
    if($date_range){
        $date = explode(' - ', $date_range);
        $start_date = Carbon::parse($date[0])->startOfDay();
        $end_date = Carbon::parse($date[1])->endOfDay();
    }
    // project expense summary
    if($exp_type == 'project'){
        $query = DB::table('car_total_project_expenses')->where('project_exp_id', $exp_id);
        if ($status == 'running') {
            $query = $query->whereBetween('car_total_project_exp_date', [$start_date, $end_date]);
        } else {
            $query = $query->where('car_total_project_exp_date', '<', $start_date);
        }
        $result = $query->sum('car_total_project_exp_amount');
        if ($result)
            return $result;
        return 0;
    // common expense summary
    } elseif($exp_type == 'cmn'){
        $query = DB::table('trip_common_expenses')
                    ->join('trips','trip_common_expenses.trip_id','=','trips.trip_id')
                    ->where('trip_common_expenses.exp_id', $exp_id);
        if($status == 'running'){
            $query = $query->whereBetween('trips.trip_date', [$start_date, $end_date]);
        } else {
            $query = $query->where('trips.trip_date', '<', $start_date);
        }
        $result = $query->sum('trip_common_expenses.trip_comn_exp_amount');
        if ($result)
            return $result;
        return 0;
    }
    // $start_date='';
    // $end_date='';
}

function get_trip_by_id($id){
    $data = Trip::find($id);
    if($data){
        return $data;
    }else{
        return false;
    }
}

function getRunningKmByVehicleIdAndDateRange($vehicleId, $startDate=null, $endDate=null){
    $query = DB::table('trips')
            ->join('trip_meters','trips.id','=','trip_meters.trip_id')
            ->where('trips.vehicle_id', $vehicleId);           
    if($startDate && $endDate){
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();
        $query = $query->whereBetween('trips.date', [$startDate, $endDate]);
    }
    $query = $query->select(
                    DB::raw('sum(trip_meters.previous_reading) as total_previous_reading,
                        sum(trip_meters.current_reading) as total_current_reading')
                )->first();
    if($query->total_current_reading > 0){
        return $query->total_current_reading - $query->total_previous_reading;
    }else{
        return 0;
    }
}


/* ------------------------------------------
/ Expense module
/ ------------------------------------------ */

function getExpenseSumByParams($expense_id=null, $vehicle_id=null, $request) {

    // assign request
    $format = $request->input('format');
    $date_range_status = $request->input('date_range_status');
    $month = $request->input('month');
    $year = $request->input('year');
    $daterange = $request->input('daterange');
    // $expense_ids =  $request->input('expense_ids');
    // $vehicle_ids =  $request->input('vehicle_ids');
    $download_pdf =  $request->input('download_pdf');
    $expense_scope = $request->input('expense_scope');

    // query start
    $query = Expense::query();

    if($expense_scope == 'inside_of_challan'){
        $query = $query->whereNotNull('trip_id');
    } elseif($expense_scope == 'outside_of_challan'){
        $query = $query->whereNull('trip_id');
    }

    $query = $query->where('expense_id', $expense_id);

    if($vehicle_id){
        $query = $query->where('vehicle_id', $vehicle_id);
    }

    switch ($date_range_status) {

        case 'monthly_report':
            if(!$month){
                Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
                return redirect()->back();
            }
            if(!$year){
                Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                return redirect()->back();
            }
            $query = $query->whereMonth('date',$month)->whereYear('date',$year);
            break;
        
        case 'yearly_report':
            if(!$year){
                Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                return redirect()->back();
            }
            $query = $query->whereYear('date',$year);
            break;

        case 'date_wise':
            if(!$daterange){
                Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
                return redirect()->back();
            }
            $date = explode(' - ', $daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $query = $query->whereBetween('date', [$start_date, $end_date]);
            break;

    }

    return $query->sum('amount');

}

function getExpenseSumByAccordingToRange($expense_id=null, $range=null, $request) {


    // assign request
    $format = $request->input('format');
    $date_range_status = $request->input('date_range_status');
    $month = $request->input('month');
    $year = $request->input('year');
    $daterange = $request->input('daterange');
    // $expense_ids =  $request->input('expense_ids_3')??false;
    $vehicle_ids =  $request->input('vehicle_ids_3')??false;
    $download_pdf =  $request->input('download_pdf');
    $expense_scope = $request->input('expense_scope');

    // query start
    $query = Expense::query();

    if($expense_scope == 'inside_of_challan'){
        $query = $query->whereNotNull('trip_id');
    } elseif($expense_scope == 'outside_of_challan'){
        $query = $query->whereNull('trip_id');
    }

    $query = $query->where('expense_id', $expense_id);

    if($vehicle_ids){
        $query = $query->whereIn('vehicle_id', $vehicle_ids);
    }

    switch ($date_range_status) {

        case 'monthly_report':
            if(!$month){
                Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
                return redirect()->back();
            }
            if(!$year){
                Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                return redirect()->back();
            }
            $query = $query->whereDate('date', $range->format('Y-m-d'));
            // $query = $query->whereMonth('date',$month)->whereYear('date',$year);
            break;
        
        case 'yearly_report':
            if(!$year){
                Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                return redirect()->back();
            }
            $query = $query->whereMonth('date', $range)->whereYear('date', $year);
            break;

        case 'date_wise':
            if(!$daterange){
                Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
                return redirect()->back();
            }
            $date = explode(' - ', $daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $query = $query->whereDate('date', $range->format('Y-m-d'));
            break;

    }

    return $query->sum('amount');

}

function getExpenseAmountByExpenseIdAndVoucher($expense_id, $voucher) {

    // check is exist or not
    if(Expense::where('expense_id', $expense_id)->where('voucher_id', $voucher)->exists()){
        
        // if exist then fetch amount
        $result = Expense::where('expense_id', $expense_id)
                            ->where('voucher_id', $voucher)
                            ->select('amount')
                            ->first();

        return $result->amount;

    } else {

        return 0;
    }

}

function getInfoByVoucherId($voucher) {

    if(Expense::where('voucher_id', $voucher)->exists()){
        return Expense::with('vehicle')->where('voucher_id', $voucher)->first();
    } else {
        return false;
    }
}






