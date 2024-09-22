<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BlockChainTxnEmail extends Mailable
{
   use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $transactions='';
    public $url='';
    public $total_txn='';
    public function __construct($transactions,$url,$total_txn)
    {
     $this->transactions = $transactions;
     $this->url = $url;
     $this->total_txn = $total_txn;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

      return $this->subject('Transaction Details')->view('email.block-chain-txn');
    }
}
