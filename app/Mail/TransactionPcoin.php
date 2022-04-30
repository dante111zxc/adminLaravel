<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class TransactionPcoin extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction_pcoin;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction_pcoin, $user)
    {
        $this->user = $user;
        $this->transaction_pcoin = $transaction_pcoin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $type = \App\Models\TransactionPcoin::TYPE[$this->transaction_pcoin->type];
        return $this->from(env('MAIL_FROM_ADDRESS'), 'Nạp Pcoin bằng '. $type.' #'.$this->transaction_pcoin->request_id.'- Paimonshop- Hệ thống nạp game chiết khấu')
            ->subject('Paimonshop - Chi tiết giao dịch')
            ->view('public.template.email.transaction-pcoin');
    }
}
