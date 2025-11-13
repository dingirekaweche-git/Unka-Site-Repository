<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CashOutController extends Controller
{
    private $baseUrl = 'https://proxy.momoapi.mtn.com';
    private $authSubscriptionKey = '2e524cb2d28b46aeaa3c33ee6ab57c97'; // for token
    private $disbursementSubscriptionKey = '021ea3c09767493aad0d6c08c9cd59f7'; // for transfer
    private $apiUser = '8c2ab96c-7b2b-4698-9770-525a4e02a2b6';
    private $apiKey = '86b86e6030f742a0adc933e014633ceb';

    public function index()
    {
        return view('cashout');
    }

    public function cashOut(Request $request)
    {
        $request->validate([
            'msisdn' => 'required|string|min:9',
            'amount' => 'required|numeric|min:1'
        ]);

        // Ensure X-Reference-Id is string
        $referenceId = (string) Str::uuid();

        try {
            /**
             * 🔹 Step 1: Get Token
             */
            $authResponse = Http::withHeaders([
                'Ocp-Apim-Subscription-Key' => $this->authSubscriptionKey,
                'Authorization' => 'Basic ' . base64_encode("{$this->apiUser}:{$this->apiKey}"),
                'Cache-control' => 'no-cache',
                'Accept' => '*/*',
                'Connection' => 'keep-alive',
            ])->post("{$this->baseUrl}/collection/token/");

            if (!$authResponse->ok()) {
                Log::error('CashOut Auth Failed', ['response' => $authResponse->body()]);
                return back()->with('error', 'Authentication failed: ' . $authResponse->body());
            }

            $token = $authResponse['access_token'];

            /**
             * 🔹 Step 2: Perform Disbursement Transfer
             */
            $transferBody = [
                'amount' => (string) $request->amount,
                'currency' => 'ZMW',
                'externalId' => rand(100000, 999999),
                'payee' => [
                    'partyIdType' => 'MSISDN',
                    'partyId' => $request->msisdn
                ],
                'payerMessage' => 'Cash Out Payment',
                'payeeNote' => 'Cash Out Payment'
            ];

            $transferResponse = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Ocp-Apim-Subscription-Key' => $this->disbursementSubscriptionKey,
                'X-Reference-Id' => $referenceId, // must be string
                'X-Target-Environment' => 'mtnzambia',
                'Cache-control' => 'no-cache',
                'Accept' => '*/*',
                'Connection' => 'keep-alive',
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/disbursement/v1_0/transfer", $transferBody);

            Log::info('CashOut Request', [
                'referenceId' => $referenceId,
                'request' => $transferBody,
                'response_status' => $transferResponse->status(),
                'response_body' => $transferResponse->body(),
            ]);

            if ($transferResponse->status() === 202) {
                return back()->with('success', "Cash Out initiated successfully! Reference ID: {$referenceId}");
            } else {
                return back()->with('error', 'Cash Out failed: ' . $transferResponse->body());
            }

        } catch (\Exception $e) {
            Log::error('CashOut Exception', ['message' => $e->getMessage()]);
            return back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
