<div class="table-responsive">
	<table class="table align-middle txn-table">
		<thead>
			<tr>
				<th>Sender</th>
				<th>Txn</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			@foreach($blockcypher_txn_receiver as $txn)
			<tr>
				<td>
					<p class="mb-0 text-truncate txn-address or_txn_address{{$txn->id}}">{{$txn->to}}</p>
					<p>
						<a href="javascript:void(0)"><i class="fa-light fa-copy me-1" onclick="copyToClipboard('.or_txn_address','{{$txn->id}}')"></i></a>
						<a href="{{route('blockchain-search').'?keyword='.$txn->to}}" target="_blank"><i class="fa-light fa-external-link"></i></a>
					</p>
				</td>
				<td>
					<a href="#" class="custom-link text-decoration-underline" data-bs-toggle="modal" data-bs-target="#transactionModal">{{$txn->txn}}</a>
				</td>
				<td>
					{{round($txn->amount/config('constants.blockcypher.amount.'.$currency), 4).' '.strtoupper($currency)}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div class="custom-pagination mt-2">
	{{$blockcypher_txn_receiver->links()}}
</div>