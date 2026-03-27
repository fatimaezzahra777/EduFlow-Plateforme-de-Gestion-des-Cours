<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Course;

class PaymentService
{
    public function createSession($courseId)
    {
        $course = Course::findOrFail($courseId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',

            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $course->title,
                    ],
                    'unit_amount' => $course->price * 100,
                ],
                'quantity' => 1,
            ]],

            'success_url' => 'http://localhost:8000/success?course_id=' . $courseId,
            'cancel_url' => 'http://localhost:8000/cancel',
        ]);

        return $session;
    }
}