<?php

namespace App\Mail;

use App\Models\Order;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order, $user;

    /**
     * Create a new message instance.
     */
<<<<<<< HEAD
    public function __construct(Order $order ,User $user, $url)
    {
        $this->order = $order;
        $this->user = $user;
        $this->url =$url;
=======
    public function __construct(Order $order ,User $user)
    {
        $this->order = $order;
        $this->user = $user;
>>>>>>> 24d5f63bd6df7702583ee779b8cacfb38024a7e5
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Order is being Processed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders',
            with:[
                'order' => $this->order,
                'customer' => $this->user,
<<<<<<< HEAD
                //'order_url' => URL::route('user.order.show', $this->order->id)
                'order_url' => $this->url

=======
                'order_url' => URL::route('user.order.show', $this->order->id)
>>>>>>> 24d5f63bd6df7702583ee779b8cacfb38024a7e5
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}