<?php
namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notifications\Notification;
use App\Models\Settings\SettingVehicle;

use Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{

    public function checkDocumentNotification(Request $request)
    {

        echo '======= Started checking document expiration notification =======' . '</br></br>';
        Log::channel('cron')->info('======= Started checking document expiration notification. =======');

        // cheking date generate
        $notify_days_for_document = setting('client_system.notify_days_for_document');
        $checkingDate = Carbon::now()->addDays($notify_days_for_document);

        $settingVehicles = SettingVehicle::get();

        if(count($settingVehicles) > 0){
            foreach($settingVehicles as $settingVehicle){

                // tax token check
                if($settingVehicle->tax_token_expire_date){

                    // if previous day of today
                    if($settingVehicle->tax_token_expire_date <= Carbon::now()->subDays(1)){
                        // content
                        $content = $settingVehicle->number_plate . ' নং গাড়ীর ট্যাক্স টোকেন এর মেয়াদ ' . Carbon::parse($settingVehicle->tax_token_expire_date)->format('M d Y') . ' তারিখে শেষ হয়ে গেছে!' ;
                    
                        // save
                        $notification = New Notification;
                        $notification->type = 'expire';
                        $notification->content = $content;
                        $notification->seen = 0;
                        $notification->save();

                    } elseif($settingVehicle->tax_token_expire_date <= $checkingDate){
                        // content
                        $content = $settingVehicle->number_plate . ' নং গাড়ীর ট্যাক্স টোকেন এর মেয়াদ শেষ হবার তারিখ ' . Carbon::parse($settingVehicle->tax_token_expire_date)->format('M d Y');
                    
                        // save
                        $notification = New Notification;
                        $notification->type = 'expire';
                        $notification->content = $content;
                        $notification->seen = 0;
                        $notification->save();
                    }

                }

                // fitness
                if($settingVehicle->fitness_expire_date){

                    // if previous day of today
                    if($settingVehicle->fitness_expire_date <= Carbon::now()->subDays(1)){
                        // content
                        $content = $settingVehicle->number_plate . ' নং গাড়ীর ফিটনেস এর মেয়াদ ' . Carbon::parse($settingVehicle->fitness_expire_date)->format('M d Y') . ' তারিখে শেষ হয়ে গেছে!' ;
                    
                        // save
                        $notification = New Notification;
                        $notification->type = 'expire';
                        $notification->content = $content;
                        $notification->seen = 0;
                        $notification->save();

                    } elseif($settingVehicle->fitness_expire_date <= $checkingDate){
                        // content
                        $content = $settingVehicle->number_plate . ' নং গাড়ীর ফিটনেস এর মেয়াদ শেষ হবার তারিখ ' . Carbon::parse($settingVehicle->fitness_expire_date)->format('M d Y');
                    
                        // save
                        $notification = New Notification;
                        $notification->type = 'expire';
                        $notification->content = $content;
                        $notification->seen = 0;
                        $notification->save();
                    }
                }

                // insurance
                if($settingVehicle->insurance_expire_date){

                    // if previous day of today
                    if($settingVehicle->insurance_expire_date <= Carbon::now()->subDays(1)){
                        // content
                        $content = $settingVehicle->number_plate . ' নং গাড়ীর ইন্স্যুরেন্স এর মেয়াদ ' . Carbon::parse($settingVehicle->insurance_expire_date)->format('M d Y') . ' তারিখে শেষ হয়ে গেছে!' ;
                    
                        // save
                        $notification = New Notification;
                        $notification->type = 'expire';
                        $notification->content = $content;
                        $notification->seen = 0;
                        $notification->save();

                    } elseif($settingVehicle->insurance_expire_date <= $checkingDate){

                        // content
                        $content = $settingVehicle->number_plate . ' নং গাড়ীর ইন্স্যুরেন্স এর মেয়াদ শেষ হবার তারিখ ' . Carbon::parse($settingVehicle->insurance_expire_date)->format('M d Y');
                        
                        // save
                        $notification = New Notification;
                        $notification->type = 'expiring';
                        $notification->content = $content;
                        $notification->seen = 0;
                        $notification->save();
                    }
                }

            }
        }

        echo '======= Ended checking document expiration notification =======' . '</br></br>';
        Log::channel('cron')->info('======= Ended checking document expiration notification. =======');

    }

}
