<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $cart_content;
    public $cartTotal;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $cart_content, $cartTotal)
    {
        $this->order = $order;
        $this->cart_content = $cart_content;
        $this->cartTotal = $cartTotal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from(env('MAIL_FROM_ADDRESS'), 'Chi tiết đơn hàng #'.$this->order->id.'- Paimonshop- Hệ thống nạp game chiết khấu')
            ->subject('Paimonshop - Chi tiết đơn hàng')
            ->view('public.template.email.order-detail');
    }
}
