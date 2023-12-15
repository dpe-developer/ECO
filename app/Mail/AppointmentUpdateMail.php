<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;    
    public $oldAppointmentDate;    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment, $oldAppointmentDate)
    {
        $this->appointment = $appointment;
        $this->oldAppointmentDate = $oldAppointmentDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Updated')->view('mail_template.appointment_updated');
    }
}
