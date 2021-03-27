<?php

namespace App\Http\Controllers;

use App\Events\Deleting;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\AddPaymentRequest;
use App\Http\Requests\DeletePaymentRequest;
use App\Jobs\ListPayment;
use App\Models\Payment;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Pusher\Pusher;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();
        return view('payment', ['payments' => $payments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tambah_payment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
