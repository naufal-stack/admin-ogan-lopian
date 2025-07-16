<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Properti untuk menyimpan data pengguna
    public $activationLink; // Properti untuk menyimpan link aktivasi

    /**
     * Buat instance pesan baru.
     */
    public function __construct($user, $activationLink)
    {
        $this->user = $user;
        $this->activationLink = $activationLink;
    }

    /**
     * Dapatkan amplop pesan.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aktivasi Akun Anda', // Subjek email
        );
    }

    /**
     * Dapatkan definisi konten pesan.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.activation', // Menggunakan template Blade Markdown
            with: [
                'user' => $this->user,
                'activationLink' => $this->activationLink,
            ],
        );
    }

    /**
     * Dapatkan lampiran untuk pesan.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
