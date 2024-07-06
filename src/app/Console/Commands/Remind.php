<?php

namespace App\Console\Commands;

use App\Models\Reserve;

use Carbon\Carbon;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Remind extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'remind';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = '予約当日にリマインドメールを送信する';
    
    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {
        $dt = Carbon::now()->toDateString();
        
        $reserves = DB::table('reserves')
        ->where('date', $dt)
        ->get();
        
        foreach($reserves as $reserve) {
            $user = DB::table('users')
            ->where('id', $reserve->user_id)
            ->select('name', 'email')
            ->first();
            
            $shopName = DB::table('shops')
            ->where('id', $reserve->shop_id)
            ->select('name')
            ->first();
            
            Mail::send([], [], function ($message) use ($user, $shopName, $reserve){
                $message->to($user->email)
                ->subject('<Rese>本日ご来店予約のお知らせ')
                ->setBody($user->name . ' 様' . "\n" .
                "\n" .
                '本日 ' . substr($reserve->time, 0, 5) . ' より、' . $shopName . ' に ' . $reserve->number . ' 名様でのご来店予定となっております。' . "\n" .
                '従業員一同、心よりお待ちいたしております。' . "\n" .
                "\n" .
                'こちら配信専用メールとなっております。' . "\n" .
                '店舗への連絡は直接店舗の方へよろしくお願い致します。' . "\n" .
                "\n" .
                'Rese');
            });
        }
    }
}
