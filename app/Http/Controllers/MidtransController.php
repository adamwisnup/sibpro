<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Payment;

class MidtransController extends Controller
{

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        if (!empty($request->order_id) && !empty($request->status_code) && !empty($request->gross_amount)&& !empty($request->price)) {

            $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$request->price.$serverKey);

            if ($hashed == $request->signature_key) {
                if ($request->transaction_status == 'settlement') {
                    Payment::where("invoice_number",'=',$request->order_id)->update([
                        'status' => 'Paid',
                        'price' => $request->price
                    ]);
                    \Log::info('Pembayaran berhasil. ID Pesanan: ' . $request->order_id);
                }
                \Log::info('Callback Midtrans berhasil diproses.');
            } else {
                \Log::warning('Hash tidak cocok. Ada potensi perubahan data tidak sah.');
            }
        } else {
            \Log::error('Data callback tidak lengkap atau tidak valid.');
        }
    }
}
