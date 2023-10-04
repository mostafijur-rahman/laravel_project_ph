<?php

namespace App\Services;

// use Illuminate\Support\Collection;
// use Illuminate\Session\SessionManager;
use App\Models\Notifications\Notification;
use App\Activity;

class CommonService {


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    
    static public function getMonthNameByMonthId($month_number)
    {
        $months = [1=>'january','february','march','april','may','june','july','august','september','october','november','december'];
        return (array_key_exists($month_number, $months))?__('cmn.'.$months[$month_number].''):'Invalid month id!';
    }

    static public function fireNotification($data)
    {
        dd($data);
        // Notification::insert();
    }

    static public function permission($data)
    {
        dd($data);
        // Notification::insert();
    }

    static public function activity($table_name,$table_id,$for){
        $activityModel = new Activity();
        $finalData = collect($activityModel->getFillable())
                            ->merge(['table_name'=> $table_name,'table_id' => $table_id,'for'=>$for])
                            ->toArray(); 
        $activityModel->create($finalData);
    }


}