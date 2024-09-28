<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RentalDetailsToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $total_cost;
    public $status;
    public $rental;

    public function __construct($customerName, $rental, $total_cost, $status)
    {
        $this->customerName = $customerName;
        $this->rental = $rental;
        $this->total_cost = $total_cost;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Your Rental Details')
                    ->view('emails.rental_details')
                    ->with([
                                'customerName', $this->customerName,
                                'rental', $this->rental,
                                'total_cost', $this->total_cost,
                                'status', $this->status,
                            ]);
    }
}
