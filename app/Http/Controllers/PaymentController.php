<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\AddPaymentRequest;
use App\Http\Requests\DeletePaymentRequest;
use App\Jobs\ListPayment;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Display view list payments
     *
     * @return view
     */
    public function index()
    {
        $payments = Payment::all();
        return view('payment', ['payments' => $payments]);
    }

    /**
     * EndPoint for Add Payment
     *
     * @param  AddPaymentRequest  $request
     * @return ResponseFormatter
     */
    public function store(AddPaymentRequest $request)
    {
        try {
            $payment = Payment::create([
                'name' => $request->name
            ]);
            return ResponseFormatter::success(['payment' => $payment], $payment->name . ' telah ditambahkan');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specific payment from database.
     *
     * @param  DeletePaymentRequest  $request
     * @return ResponseFormatter
     */
    public function destroy(DeletePaymentRequest $request)
    {
        try {
            foreach ($request->ids as $id) {
                ListPayment::dispatch($id);
            }
            return ResponseFormatter::success([], 'Sedang Diproses');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 400);
        }
    }
}
