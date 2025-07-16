<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
    {
        use Queueable, SerializesModels;

        public $user;
        public $resetLink;

        /**
         * Buat instance pesan baru.
         */
        public function __construct($user, $resetLink)
        {
            $this->user = $user;
            $this->resetLink = $resetLink;
        }

        /**
         * Dapatkan amplop pesan.
         */
        public function envelope(): Envelope
        {
            return new Envelope(
                subject: 'Reset Password Akun Anda',
            );
        }

        /**
         * Dapatkan definisi konten pesan.
         */
        public function content(): Content
        {
            return new Content(
                markdown: 'emails.password-reset',
                with: [
                    'user' => $this->user,
                    'resetLink' => $this->resetLink,
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
