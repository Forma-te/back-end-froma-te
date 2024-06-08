<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailSaleToNewMembers extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $member;
    public $course;
    public $password;
    public $bankUsers;

    /**
     * Create a new message instance.
     */
    public function __construct(User $member, Course $course, $password, $bankUsers)
    {
        $this->member = $member;
        $this->course = $course;
        $this->password = $password;
        $this->bankUsers = $bankUsers;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "{$this->member->name} o seu produto está agora disponível!",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'Sale.emails.send_mail_sale_to_new_members',
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
