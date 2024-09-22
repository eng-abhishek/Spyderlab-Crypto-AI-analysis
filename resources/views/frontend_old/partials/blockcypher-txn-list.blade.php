<div class="table-responsive">
	<table class="table align-middle txn-table">
		<thead>
			<tr>
				<th>{{($list_type == 'senders') ? 'Sender' : 'Recipient'}}</th>
				<th>Txn</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			@forelse($blockcypher_txn_data as $value)
			<tr>
				<td>
					@php
					$address = ($list_type == 'senders') ? $value->from : $value->to;
					@endphp
					<p class="mb-0 text-truncate txn-address or_txn_address{{$value->id}}">{{$address}}</p>
					<p>
						<a href="javascript:void(0)"><i class="fa-light fa-copy me-1" onclick="copy_to_clipboard('.or_txn_address','{{$value->id}}')"></i></a>
						<a href="{{route('blockchain-search').'?keyword='.$address}}" target="_blank"><i class="fa-light fa-external-link"></i></a>
					</p>
				</td>
				<td>
					<a href="#" class="custom-link text-decoration-underline transactionModal" onclick="getTxnDetails('{{$list_type}}','{{$address}}')">{{$value->txn}}</a>
				</td>
				<td>
					@php
					$amount = $value->amount;
					if($currency == 'btc'){
					$amount = round($value->amount/config('constants.blockcypher.amount.btc'), 4).' BTC';
				}elseif($currency == 'eth'){
				$amount = round($value->amount/config('constants.blockcypher.amount.eth'), 4).' ETH';
			}
			echo $amount;
			@endphp
		</td>
	</tr>
	@empty
	<tr><td colspan="3">No data found.</td></tr>
	@endforelse
</tbody>
</table>
<input type="text" id="current_searched_address" class="d-none">
<input type="text" id="current_type" class="d-none">
</div>

@if(count($blockcypher_txn_data))
<div class="custom-pagination mt-3">
	{{$blockcypher_txn_data->onEachSide(0)->links()}}
</div>
@endif