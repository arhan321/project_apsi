<?php

namespace App\Http\Controllers;

use Log;
use App\User;
use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\Notification;

class PaymentController extends Controller
{
    public function index()
    {
        return view('frontend.pages.confirmation');
    }

    public function checkout(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'country' => 'required|string',
            'address1' => 'required|string',
            'post_code' => 'nullable|string',
            'address2' => 'nullable|string',
        ]);

        // Check if the cart is empty
        if (Cart::where('user_id', Auth::id())->whereNull('order_id')->doesntExist()) {
            return redirect()->back()->with('error', 'Cart is Empty!');
        }

        $user_id = Auth::id();
        $cartSubtotal = DB::table('carts')->where('user_id', $user_id)->sum('amount');

        // Generate a unique order_id
        $order_id = Str::random(50);

        $orderData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'total_price' => $cartSubtotal,
            'order_id' => $order_id,
            'country' => $request->country,
            'address_line1' => $request->address1,
            'address_line2' => $request->address2,
            'postal_code' => $request->post_code,
        ];

        DB::beginTransaction();

        try {
            // Save payment details
            $order = Payment::create($orderData);

            // Midtrans configuration
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update carts with order_id
            Cart::where('user_id', $user_id)
                ->whereNull('order_id')
                ->update(['order_id' => $order_id]);

            // Notify admin
            $admin = User::where('role', 'admin')->first();
            $details = [
                'title' => 'New order created',
                'actionURL' => route('order.show', $order_id),
                'fas' => 'fa-file-alt'
            ];

            Notification::send($admin, new StatusNotification($details));

            DB::commit();

            return view('frontend.pages.confirmation', compact('snapToken', 'order'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // public function notification(Request $request)
    // {
    //     $notif = $request->all();
    //     $status = $notif['transaction_status'] ?? null;
    //     $order_id = $notif['order_id'] ?? null;

    //     if ($status == 'settlement') {
    //         $this->processSuccessfulPayment($order_id);
    //     }

    //     return response()->json(['status' => 'success']);
    // }

    // protected function processSuccessfulPayment($order_id)
    // {
    //     $user_id = Auth::id();

    //     if (!$user_id) {
    //         return;
    //     }

    //     DB::beginTransaction();

    //     try {
    //         // Check if the order_id exists in payments before processing carts
    //         $paymentExists = Payment::where('order_id', $order_id)->exists();

    //         if (!$paymentExists) {
    //             Log::error('Order ID does not exist in payments: ' . $order_id);
    //             DB::rollBack();
    //             return;
    //         }

    //         // Process carts related to the order
    //         $carts = DB::table('carts')
    //             ->where('user_id', $user_id)
    //             ->where('order_id', $order_id)
    //             ->get();

    //         foreach ($carts as $cart) {
    //             DB::table('products')
    //                 ->where('id', $cart->product_id)
    //                 ->decrement('quantity', $cart->quantity);
    //         }

    //         // Remove processed carts
    //         DB::table('carts')
    //             ->where('user_id', $user_id)
    //             ->where('order_id', $order_id)
    //             ->delete();

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Failed to process successful payment: ' . $e->getMessage());
    //     }
    // }
}
