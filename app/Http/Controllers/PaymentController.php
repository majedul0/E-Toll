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
        // SSLCommerz sends back transaction data via POST
        // Extract transaction ID from request (could be tran_id or value_a/value_b/value_c)
        $tranId = $request->input('tran_id') ?? $request->input('value_c');
        
        if (!$tranId) {
            return redirect('/payment')->withErrors(['payment' => 'Invalid transaction ID.']);
        }
        
        // TODO: In production, validate the payment with SSLCommerz and store in database
        // For now, redirect to public QR code view
        return redirect('/qr-code/view?txn=' . $tranId);
    }

    public function showQrCode(Request $request)
    {
        // Public method to show QR code (no auth required)
        // This is called after payment success callback
        $tranId = $request->input('txn');
        
        if (!$tranId) {
            return redirect('/payment')->withErrors(['payment' => 'No transaction found.']);
        }
        
        return view('qr-code', ['transactionId' => $tranId]);
    }

    public function fail(Request $request)
    {
        // Log failed payment for debugging
        \Log::warning('Payment failed', ['data' => $request->all()]);
        return redirect('/payment')->withErrors(['payment' => 'Payment failed. Please try again.']);
    }

    public function cancel(Request $request)
    {
        // Log cancelled payment for debugging
        \Log::info('Payment cancelled', ['data' => $request->all()]);
        return redirect('/payment')->withErrors(['payment' => 'Payment cancelled.']);
    }
}

