<?php

namespace App\Console\Commands;

use App\Modules\System\Models\BuyerBill;
use App\Modules\System\Models\BuyerOrder;
use App\Modules\System\Models\CoverCharse;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use DB;

class createBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成账单';

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
     * @return mixed
     */
    public function handle()
    {
        $today = Carbon::today();
        $length_days = $today->diffInDays($today->copy()->addMonth(1));
        $buyer_orders = BuyerOrder::whereStatus(BuyerOrder::ORDER_REFUSE)->get();
        foreach ($buyer_orders as $buyer_order){
            $bill = $buyer_order->order_bills()->latest()->first();

            if(($bill->amortize_time + 1) < $buyer_order->amortize_time && $bill->end_time <= $today){
                DB::transaction(function () use($buyer_order,$today,$length_days) {
                    $bill = new BuyerBill();
                    $bill->order_sn = $buyer_order->order_no . '000';
                    $bill->cover_charse = bcmul($buyer_order->order_account, ($length_days * 0.00005), 2);
                    $bill->month_account = bcadd(bcdiv($buyer_order->order_account, $buyer_order->amortize_time, 2), $bill->cover_charse, 2);
                    $bill->refund_account = 0.00;
                    $bill->status = $bill::STATUS_NOT_PAY;
                    $bill->amortize_time = $buyer_order->amortize_now + 1;
                    $bill->end_time = strtotime($today->copy()->addMonth(1));
                    $bill->buyer_id = $buyer_order->buyer_id;
                    $bill->save();

                    $bill->order_sn = bcadd($bill->order_sn + $bill->id);
                    $bill->save();

                    $buyer_order->assigeOrderBill(array($bill->id));

                    $cover_charse = new CoverCharse();
                    $cover_charse->service_num = $bill->cover_charse;
                    $cover_charse->over_service_num = 0.00;
                    $cover_charse->save();

                    BuyerOrder::whereId($buyer_order->id)->increment('amortize_now', 1);
                });
            }

            if(($bill->amortize_time + 1) == $buyer_order->amortize_time && $bill->end_time <= $today){
                DB::transaction(function () use($buyer_order,$today,$length_days) {
                    $bill = new BuyerBill();
                    $bill->order_sn = $buyer_order->order_no . '000';
                    $bill->cover_charse = bcmul($buyer_order->order_account, ($length_days * 0.00005), 2);
                    $bill->month_account = bcdiv($buyer_order->order_total, $buyer_order->has_payment, 2);
                    $bill->refund_account = 0.00;
                    $bill->status = $bill::STATUS_NOT_PAY;
                    $bill->amortize_time = $buyer_order->amortize_now + 1;
                    $bill->end_time = strtotime($today->copy()->addMonth(1));
                    $bill->buyer_id = $buyer_order->buyer_id;
                    $bill->save();

                    $bill->order_sn = bcadd($bill->order_sn + $bill->id);
                    $bill->save();

                    $buyer_order->assigeOrderBill(array($bill->id));

                    $cover_charse = new CoverCharse();
                    $cover_charse->service_num = $bill->cover_charse;
                    $cover_charse->over_service_num = 0.00;
                    $cover_charse->save();

                    BuyerOrder::whereId($buyer_order->id)->increment('amortize_now', 1);
                });
            }
        }
    }
}
