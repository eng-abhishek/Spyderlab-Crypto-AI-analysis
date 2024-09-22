                         <table class="table table-bordered table-list">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Sender</th>
                                    <th>Recipient</th>
                                    <th>Amount</th>
                                    <th>Time</th>
                                    <th>Txn. ID</th>
                                </tr>
                            </thead>
                            <tbody>

                             @foreach($blockcypher_txn_data as $key => $value)
                             @php
                             $amount = $value->amount;
                             if($currency == 'btc'){
                             $or_amount = round($value->amount/config('constants.blockcypher.amount.btc'), 4).' BTC';
                         }elseif($currency == 'eth'){
                         $or_amount = round($value->amount/config('constants.blockcypher.amount.eth'), 4).' ETH';
                     }

                     @endphp
                     <tr>
                        <td>{{$key+1}}</td>
                        <td><p class="mb-0 text-break txn-address">{{$sender}}</p></td>
                        <td><p class="mb-0 text-break txn-address">{{$receiver}}</p></td>
                        <td>{{$or_amount}}</td>
                        <td>{{date('d-M,Y h:i A',strtotime($value->transaction->confirmed_at))}}</td>
                        <td>{{$value->txn_id}}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            @if(count($blockcypher_txn_data))
            <div class="custom-pagination">
             {{-- <nav>
                <ul class="pagination float-end">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true"><i class="fa-light fa-chevrons-left"></i></span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true"><i class="fa-light fa-chevrons-right"></i></span>
                        </a>
                    </li>
                </ul>
            </nav>--}}
            {{$blockcypher_txn_data->links()}}
        </div>
        @endif