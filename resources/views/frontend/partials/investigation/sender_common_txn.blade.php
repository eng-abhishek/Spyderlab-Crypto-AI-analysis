<div class="table-responsive">
	<table class="table align-middle txn-table">
		<thead>
			<tr>
				<th>Recipient</th>
				<th>Txn</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			@forelse($blockcypher_txn_sender as $txn)

			<tr>
				<td>
					<p class="d-inline-block text-truncate or_txn_address{{$txn->id}}" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$txn->from ?? ''}}">{{$txn->from ?? ''}}</p>
					<p>
						<a href="javascript:void(0)"><i class="text-black fa-solid fa-copy px-0" onclick="copyToClipboard('.or_txn_address','{{$txn->id}}')"></i></a>
						<a href="{{route('blockchain-search').'?keyword='.$txn->from}}" target="_blank"><i class="text-black fa-solid fa-arrow-up-right-from-square px-0"></i></a>
					</p>
				</td>
				<td>
					<a href="#" class="custom-link text-decoration-underline" data-bs-toggle="modal" data-bs-target="#transactionModal">{{$txn->txn}}</a>
				</td>
				<td>
					{{round($txn->amount/config('constants.blockcypher.amount.'.$currency), 4).' '.strtoupper($currency)}}
				</td>
			</tr>
			@empty
			<tr><td colspan="3">No data found.</td></tr>
			@endforelse

		</tbody>
	</table>
</div>
<div class="custom-pagination mt-2">
	{{$blockcypher_txn_sender->links()}}
</div>