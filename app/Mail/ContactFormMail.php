<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Mensaje de {$this->details['first_name']} {$this->details['last_name']} </title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    margin-top:20px;
                    width: 100%;
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                .header {
                    background-color: #4a90e2;
                    color: #ffffff;
                    padding: 20px;
                    text-align: center;
                }
                .content {
                    padding: 20px;
                }
                .footer {
                    background-color: #f4f4f4;
                    color: #888888;
                    padding: 10px;
                    text-align: center;
                    font-size: 12px;
                }
                .content h2 {
                    color: #333333;
                }
                .content p {
                    color: #555555;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Mensaje de {$this->details['first_name']} {$this->details['last_name']}</h1>
                </div>
                <div class='content'>
                    <p><strong>Nombre del remitente:</strong> {$this->details['first_name']} {$this->details['last_name']}</p>
                    <p><strong>Email del remitente:</strong> {$this->details['email']}</p>
                    <p><strong>Mensaje:</strong> {$this->details['message']}</p>
                </div>
                <div class='footer'>
                    <p>Market Store API</p>
                </div>
            </div>
        </body>
        </html>";

        return $this->subject('Nuevo Mensaje de Contacto')
            ->html($htmlContent);
    }
}