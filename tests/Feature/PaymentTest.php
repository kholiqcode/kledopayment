<?php

namespace Tests\Feature;

use App\Jobs\ListPayment;
use App\Models\Payment;
use Faker\Factory;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequestAddPayment()
    {
        $faker = Factory::create();
        $payload = [
            'name' => $faker->name(),
        ];

        $this->json('POST', route('payments.store'), $payload)
            ->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequestDeletePayment()
    {
        $payments = Payment::select('id')->take(5)->get();
        foreach ($payments as $payment) {
            $payload['ids'][] = $payment;
        }

        $this->json('DELETE', route('payments.delete'), $payload)
            ->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testQueueSending()
    {
        Queue::fake();
        $payments = Payment::select('id')->take(5)->get();
        foreach ($payments as $payment) {
            ListPayment::dispatch($payment->id);
        }
        Queue::assertPushed(ListPayment::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testJobExecutionQueue()
    {
        // $this->expectsJobs(ListPayment::class);
    }
}
