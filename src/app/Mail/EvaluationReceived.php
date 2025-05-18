<?php

namespace App\Mail;

use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EvaluationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $evaluation;

    public function __construct(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
    }

    public function build()
    {
        return $this->subject('新しい評価を受け取りました')
                    ->view('emails.evaluation_received');
    }
}