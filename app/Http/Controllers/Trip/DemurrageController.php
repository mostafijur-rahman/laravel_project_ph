<?php

namespace App\Http\Controllers\Trip;
use App\Http\Controllers\Controller;

// request
use Illuminate\Http\Request;
use App\Http\Requests\Trip\Demurrage\OwnVehicleRequest; 
use App\Http\Requests\Trip\Demurrage\OutCommissionTransectionRequest; 

// model
use App\Models\Trips\Trip;
use App\Models\Trips\TripCompany;
use App\Models\Trips\TripProvider;
use App\Models\Trips\TripDemarage;

// other class
use DB;
use Toastr;
use Auth;


class DemurrageController extends Controller {

    public function forOwnVehicle(OwnVehicleRequest $request){

        // consider as up down challan
        if($request->has('challan_type')){

            if($request->input('challan_type') == 'up'){
                // up trip
                $trip_id = $request->input('trip_id');
    
            } else {
                // down trip
                $trip_id = $request->input('down_trip_id');
    
            }

        // consider as single challan
        } else {
            $trip_id = $request->input('trip_id');
        }

        DB::beginTransaction();
        try {

            // insert on main table
            $demurrage = new TripDemarage();
            $demurrage->trip_id = $trip_id;
            $demurrage->date = $request->input('date');
            $demurrage->company_amount = $request->input('company_amount');
            $demurrage->note = $request->input('note');
            $demurrage->created_by = Auth::user()->id;
            $demurrage->save();

            // save to company
            $tripCompany = TripCompany::where('trip_id', $trip_id)->first();
            $tripCompany->demarage += $request->input('company_amount');
            $tripCompany->demarage_due += $request->input('company_amount');
            $tripCompany->save();

            // update trip info
            Trip::where('id', $trip_id)->update(['updated_by' => Auth::user()->id]);

            DB::commit();
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('',$e->getMessage());
            return redirect()->back();
        }
    }

    public function forOutCommissionTransection(OutCommissionTransectionRequest $request){
        
        // assign
        $trip_id = $request->input('trip_id');

        DB::beginTransaction();
        try {

            // insert on main table
            $demurrage = new TripDemarage();
            $demurrage->trip_id = $trip_id;
            $demurrage->date = $request->input('date');
            $demurrage->company_amount = $request->input('company_amount');
            $demurrage->provider_amount = $request->input('provider_amount');
            $demurrage->note = $request->input('note');
            $demurrage->created_by = Auth::user()->id;
            $demurrage->save();

            // save to company
            $tripCompany = TripCompany::where('trip_id', $trip_id)->first();
            $tripCompany->demarage += $request->input('company_amount');
            $tripCompany->demarage_due += $request->input('company_amount');
            $tripCompany->save();

            // save to company
            $tripProvider = TripProvider::where('trip_id', $trip_id)->first();
            $tripProvider->demarage += $request->input('provider_amount');
            $tripProvider->demarage_due += $request->input('provider_amount');
            $tripProvider->save();

            // update trip info
            Trip::where('id', $trip_id)->update(['updated_by' => Auth::user()->id]);

            DB::commit();
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('',$e->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id){
        if (!TripDemarage::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $trip_demarage =  TripDemarage::where('id', $id)->first();

            // update to company
            $tripCompany = TripCompany::where('trip_id', $trip_demarage->trip_id)->first();

            if($tripCompany->demarage_due < $trip_demarage->company_amount){
                Toastr::error('', 'কোম্পানি থেকে আগে থেকেই এই পরিমান টাকা ডেমারেজ বিল গ্রহণ করা হয়েছে, তাই ডিলিট হচ্ছে না।');
                return redirect()->back();
            }
            
            $tripCompany->demarage -= $trip_demarage->company_amount;
            $tripCompany->demarage_due -= $trip_demarage->company_amount;
            $tripCompany->save();

            // update to provider
            $tripProvider = TripProvider::where('trip_id', $trip_demarage->trip_id)->first();

            if($tripProvider->demarage_due < $trip_demarage->provider_amount){
                Toastr::error('', 'প্রদানকারীকে আগে থেকেই এই পরিমান টাকা ডেমারেজ বিল দেয়া হয়েছে, তাই ডিলিট হচ্ছে না।');
                return redirect()->back();
            }

            $tripProvider->demarage -= $trip_demarage->provider_amount;
            $tripProvider->demarage_due -= $trip_demarage->provider_amount;
            $tripProvider->save();

            $trip_demarage->delete();

            DB::commit();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }

    // public function forSingleChallan(TripDemurrageRequest $request){

    //     // dd($request);

    //     // "trip_id" => "3"
    //     // "type" => "own_vehicle_up_down"
    //     // "challan_type" => "up"
    //     // "date" => "2022-08-19"
    //     // "company_amount" => "100"
    //     // "note" => null

    //     $trip_id = $request->input('trip_id');

    //     DB::beginTransaction();
    //     try {

    //         $demurrage = new TripDemarage();
    //         $demurrage->trip_id = $trip_id;
    //         $demurrage->date = $request->input('date');
    //         $demurrage->company_amount = $request->input('company_amount');
            
    //         if($request->input('type') == 'own_vehicle_single' || $request->input('type') == 'own_vehicle_up_down'){
                
    //         } else {
    //             $demurrage->company_amount = $request->input('company_amount');
    //             $demurrage->provider_amount = $request->input('provider_amount');
    //         }
    //         $demurrage->note = $request->input('note');
    //         $demurrage->created_by = Auth::user()->id;
    //         $demurrage->save();

    //         // save to company
    //         $tripCompany = TripCompany::where('trip_id', $trip_id)->first();
    //         $tripCompany->demarage += $request->input('company_amount');
    //         $tripCompany->demarage_due += $request->input('company_amount');
    //         $tripCompany->save();

    //         // save to provider
    //         if($request->input('type') != 'own_vehicle_single'
    //             || $request->input('type') != 'own_vehicle_up_down'){

    //             $tripProvider = TripProvider::where('trip_id', $trip_id)->first();
    //             $tripProvider->demarage += $request->input('provider_amount');
    //             $tripProvider->demarage_due += $request->input('provider_amount');
    //             $tripProvider->save();   
    //         }

    //         Trip::where('id', $trip_id)->update(['updated_by' => Auth::user()->id]);

    //         DB::commit();
    //         Toastr::success('',__('cmn.successfully_posted'));
    //         return redirect()->back();

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Toastr::error('',$e->getMessage());
    //         return redirect()->back();
    //     }
    // }

}