<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
  use Queueable, SerializesModels;

  protected $details;

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
    return $this->from(env('MAIL_FROM_ADDRESS'))
      ->view(
        'email.name',
        [
          'name' => $this->details['name'],
          'email' => $this->details['email'],
          'title'  => $this->details['title'],
          'start'  => $this->details['start'],
        ]
      );
  }
}
