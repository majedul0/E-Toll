<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function createSession(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'method' => ['required', 'string'],
            'origin' => ['nullable', 'string'],
            'destination' => ['nullable', 'string'],
        ]);

        $storeId = config('services.sslcommerz.store_id');
        $storePass = config('services.sslcommerz.store_passwd');
        $mode = config('services.sslcommerz.mode', 'sandbox');

        if (! $storeId || ! $storePass) {
            return response()->json([
                'status' => 'FAILED',
                'failedreason' => 'Missing SSLCommerz sandbox credentials. Please set SSL_STORE_ID and SSL_STORE_PASSWD.',
            ], 400);
        }

        $endpoint = $mode === 'live'
            ? 'https://securepay.sslcommerz.com/gwprocess/v4/api.php'
            : 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php';

        $tranId = 'ETOLL-'.Str::upper(Str::random(8)).'-'.time();

        $user = Auth::user();

        $payload = [
            'store_id' => $storeId,
            'store_passwd' => $storePass,
            'total_amount' => $request->float('amount'),
            'currency' => 'BDT',
            'tran_id' => $tranId,
            'success_url' => route('payment.success'),
            'fail_url' => route('payment.fail'),
            'cancel_url' => route('payment.cancel'),
            'emi_option' => 0,
            'cus_name' => $user?->name ?? 'E-Toll User',
            'cus_email' => $user?->email ?? 'user@example.com',
            'cus_add1' => 'Bangladesh',
            'cus_city' => 'Dhaka',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $user?->phone ?? '01700000000',
            'shipping_method' => 'NO',
            'product_name' => 'E-Toll',
            'product_category' => 'Service',
            'product_profile' => 'general',
        ];

        // Optional extra data
        if ($request->filled('origin') && $request->filled('destination')) {
            $payload['value_a'] = $request->input('origin');
            $payload['value_b'] = $request->input('destination');
        }
        $payload['value_c'] = $request->input('method');

        $response = Http::asForm()->post($endpoint, $payload);

        if (! $response->successful()) {
            return response()->json([
                'status' => 'FAILED',
                'failedreason' => 'Gateway unreachable',
                'detail' => $response->body(),
            ], 500);
        }

        $data = $response->json();

        if (! $data || ($data['status'] ?? '') !== 'SUCCESS' || empty($data['GatewayPageURL'])) {
            return response()->json([
                'status' => $data['status'] ?? 'FAILED',
                'failedreason' => $data['failedreason'] ?? 'Invalid Information',
                'detail' => $data,
            ], 422);
        }

        return response()->json([
            'status' => 'SUCCESS',
            'gateway_url' => $data['GatewayPageURL'],
            'tran_id' => $tranId,
        ]);
    }

    public function success(Request $request)
    {
        return redirect('/qr-code?txn='.($request->input('tran_id') ?? $request->input('value_c')));
    }

    public function fail()
    {
        return redirect('/payment')->withErrors(['payment' => 'Payment failed or was cancelled.']);
    }

    public function cancel()
    {
        return redirect('/payment')->withErrors(['payment' => 'Payment cancelled.']);
    }
}

