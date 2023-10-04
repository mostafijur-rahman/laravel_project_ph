<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Relations\Relation;

use App\Models\Settings\SettingDefault;
use App\Models\Notifications\Notification;

use Setting;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Relation::morphMap([
            'tyre'=>'App\Models\Tyres\Tyre',
            'mobil'=>'App\Models\Mobils\Mobil',
            'expense'=>'App\Models\Expenses\Expense',
            'due_collection'=>'App\Models\Dues\DueCollection',
            'trip'=>'App\Models\Trips\Trip',
            'trip_oil_expense'=>'App\Models\Trips\TripOilExpense',
            'purchase'=>'App\Models\Purchases\Purchase',
            'account'=>'App\Models\Accounts\Account',
        ]);

    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(255);

        if (Schema::hasTable('setting_defaults') && Schema::hasTable('notifications')) {
            
            // load company setup
            $settingDefaults = SettingDefault::all();
            foreach ($settingDefaults as $settingDefault) {
                $setDefault[$settingDefault->key] = $settingDefault->value;
            }

            // load notice
            $notice_qty = Notification::whereNull('deleted_at')->where('seen', 0)->count();
            $notices = Notification::whereNull('deleted_at')->latest()->take(50)->get();

            // billing notice
            $top_notice = null;
            $top_notice_class = null;

            if(setting('admin_system.last_date_of_bill_payment') && setting('admin_system.notify_days_for_bill')){

                $last_date_of_bill_payment = Carbon::parse(setting('admin_system.last_date_of_bill_payment'));
                $today_date = Carbon::now();

                // if last_date_of_bill_payment is less then or equal from today_date then 'isExpired' consider is 'TRUE'
                $isExpired = $last_date_of_bill_payment->lt($today_date);

                $last_date_for_show = $last_date_of_bill_payment->format('l, d M Y');
                $total_bill = number_format(setting('admin_system.total_bill'));

                // if not yet expired
                if(!$isExpired){

                    // then check day diff and notice show based on it 
                    $left_days = $last_date_of_bill_payment->diffInDays($today_date);

                    if(setting('admin_system.notify_days_for_bill') > $left_days ){
                        
                        switch (setting('admin_system.due_payment_action')) {
                            case 'warning':
                                $top_notice = 'উন্নতর সার্ভিস প্রদানের লক্ষ্যে আমাদের কার্যক্রম গতিশীল রাখতে ('  . $last_date_for_show .  ') তারিখের পূর্বে আপনার বকেয়া বিল ' . $total_bill . ' টাকা পরিশোধ করুন, ধন্যবাদ।';
                                break;

                            case 'lock':
                                $top_notice = 'উন্নতর সার্ভিস প্রদানের লক্ষ্যে আমাদের কার্যক্রম গতিশীল রাখতে ('  . $last_date_for_show .  ') তারিখের পূর্বে আপনার বকেয়া বিল ' . $total_bill . ' টাকা পরিশোধ করুন, অন্যথায় নির্ধারিত তারিখের পর যেকোন সময় আপনার সার্ভারটি স্বয়ংক্রিয়ভাবে সাময়িক সময়ের জন্য বন্ধ হয়ে যেতে পারে, এই অনাকাঙ্খিত পরিস্থিতি এড়াতে দ্রুত বকেয়া বিল পরিশোধ করুন, ধন্যবাদ।';
                                break;

                            case 'shutdown':
                                $top_notice = 'উন্নতর সার্ভিস প্রদানের লক্ষ্যে আমাদের কার্যক্রম গতিশীল রাখতে ('  . $last_date_for_show .  ') তারিখের পূর্বে আপনার বকেয়া বিল ' . $total_bill . ' টাকা পরিশোধ করুন, অন্যথায় নির্ধারিত তারিখের পর যেকোন সময় আপনার সার্ভারটি স্বয়ংক্রিয়ভাবে সাময়িক সময়ের জন্য বন্ধ হয়ে যেতে পারে, এই অনাকাঙ্খিত পরিস্থিতি এড়াতে দ্রুত বকেয়া বিল পরিশোধ করুন, ধন্যবাদ।';
                                break;

                            default:
                            $top_notice = 'উন্নতর সার্ভিস প্রদানের লক্ষ্যে আমাদের কার্যক্রম গতিশীল রাখতে ('  . $last_date_for_show .  ') তারিখের পূর্বে আপনার বকেয়া বিল ' . $total_bill . ' টাকা পরিশোধ করুন, ধন্যবাদ।';
                                break;
                        }
                        $top_notice_class = 'text-danger';
                    }

                } 
                // if expired
                else {

                    switch (setting('admin_system.due_payment_action')) {
                        case 'warning':
                            $top_notice = 'আপনার বকেয়া বিল ' . $total_bill . ' টাকা পরিশোধের সময় সীমা ' . $last_date_for_show . ' তারিখে চলে গেছে, ধন্যবাদ।';
                            break;

                        case 'lock':
                            $top_notice = 'আপনার বকেয়া বিল ' . $total_bill . ' টাকা পরিশোধের সময় সীমা ' . $last_date_for_show . ' তারিখে চলে গেছে, তাই আপনার সার্ভারটি যেকোন সময় স্বয়ংক্রিয়ভাবে সাময়িক সময়ের জন্য বন্ধ হয়ে যেতে পারে, এই অনাকাঙ্খিত পরিস্থিতি এড়াতে দ্রুত বকেয়া বিল পরিশোধ করুন, ধন্যবাদ।';
                            break;

                        case 'shutdown':
                            $top_notice = 'আপনার বকেয়া বিল ' . $total_bill . ' টাকা পরিশোধের সময় সীমা ' . $last_date_for_show . ' তারিখে চলে গেছে, তাই আপনার সার্ভারটি যেকোন সময় স্বয়ংক্রিয়ভাবে সাময়িক সময়ের জন্য বন্ধ হয়ে যেতে পারে, এই অনাকাঙ্খিত পরিস্থিতি এড়াতে দ্রুত বকেয়া বিল পরিশোধ করুন, ধন্যবাদ।';
                            break;

                        default:
                        $top_notice = 'আপনার বকেয়া বিল ' . $total_bill . ' টাকা পরিশোধের সময় সীমা ' . $last_date_for_show . ' তারিখে চলে গেছে, ধন্যবাদ।';
                            break;
                    }
                    $top_notice_class = 'text-danger';

                }

            }

            View::share([
                'setComp' => $setDefault,
                'notices' => $notices, 
                'notice_qty' => $notice_qty, 
                'top_notice' => $top_notice, 
                'top_notice_class' => $top_notice_class,
            ]);
        } 
    }

}