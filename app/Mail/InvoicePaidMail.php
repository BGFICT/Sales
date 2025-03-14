<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoicePaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoiceData;

    public function __construct($invoiceData)
    {
        $this->invoiceData = $invoiceData;
    }

    public function build()
    {
        return $this->subject('Invoice for Your Payment')
                    ->view('emails.invoice')
                    ->with('invoiceData', $this->invoiceData);
    }
}
