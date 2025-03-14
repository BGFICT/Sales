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

class AdminOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $order, $user;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, User $user)
    {
        $this->order=$order;
        $this->user=$user;
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Order',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin_orders',
            with:[
                'order' => $this->order,
                'customer' => $this->user
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
