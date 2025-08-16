<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\ReviewLink;

class ReviewLinkEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $reviewLink;
    public $reviewUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, ReviewLink $reviewLink)
    {
        $this->order = $order;
        $this->reviewLink = $reviewLink;
        $this->reviewUrl = route('reviews.show', $reviewLink->unique_token);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Review Your Order - Zayn\'s Beauty',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.review-link',
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
