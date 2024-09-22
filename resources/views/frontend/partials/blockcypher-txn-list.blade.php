<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th scope="col">{{($list_type == 'senders') ? 'Sender' : 'Recipient'}}</th>
				<th scope="col">Txn</th>
				<th scope="col">Amount</th>
			</tr>
		</thead>
		<tbody>

			@forelse($blockcypher_txn_data as $value)
			<tr>
				<td>
					@php
					$address = ($list_type == 'senders') ? $value->from : $value->to;
					@endphp

					<p class="d-inline-block text-truncate or_txn_address{{$value->id}}" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$address ?? ''}}">{{$address ?? ''}}</p>

					<p>
						<a href="javascript:void(0)"><i class="text-black fa-solid fa-copy px-0" onclick="copyToClipboard('.or_txn_address','{{$value->id}}')"></i></a>
						<a href="{{route('blockchain-search').'?keyword='.$address}}" target="_blank"><i class="text-black fa-solid fa-arrow-up-right-from-square px-2"></i></a>
					</p>
				</td>

				<td><a href="javascript:void(0)" class="custom-link text-decoration-underline transactionModal" onclick="getTxnDetails('{{$list_type}}','{{$address}}')">{{$value->txn}}</a></td>

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