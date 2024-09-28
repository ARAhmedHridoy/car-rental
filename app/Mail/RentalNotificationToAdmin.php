<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RentalNotificationToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $customerEmail;
    public $customerPhone;
    public $customerAddress;
    public $carDetails;
    public $status;

    public function __construct($customerEmail,$customerName, $customerPhone, $customerAddress, $carDetails, $status)
    {
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
        $this->customerPhone = $customerPhone;
        $this->customerAddress = $customerAddress;
        $this->carDetails = $carDetails;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('New Car Rental Notification')
                    ->view('emails.rental_notification')
                    ->with([
                        'customerEmail' => $this->customerEmail,
                        'customerName' => $this->customerName,
                        'customerPhone' => $this->customerPhone,
                        'customerAddress' => $this->customerAddress,
                        'carDetails' => $this->carDetails,
                        'status' => $this->status,
                    ]);
    }
}


