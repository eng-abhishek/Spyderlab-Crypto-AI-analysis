<div class="table-responsive">
	<table class="table" id="m_table_1">
		<thead>
			<tr>
				<th>Token</th>
				<th>Time(UTC)</th>
				<th>Txn Has</th>
				<th>Sender - Recipient</th>
				<th>Amount</th>
				<th>Txn ID</th>
			</tr>
		</thead>
		<tbody>
			@forelse($result as $value)
			<tr>
				<td>
					<div class="d-flex align-items-center">
						<img src="{{asset('assets/frontend/images/coins/'.strtolower($value->token).'.png')}}" alt="{{$value->token}}" class="me-1 coin-sm coin-icon-h-40">
						<span class="lh-1">{{$value->token}}</span>
					</div>
				</td>
				<td>{{$value->txn_time}}</td>
				<td><p class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$value->txn_has}}">{{\Illuminate\Support\Str::limit($value->txn_has ?? '', 15, $end='...') }}</p></td>
				
				<td><p class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$value->address}}">{{\Illuminate\Support\Str::limit($value->address ?? '', 15, $end='...') }}</p></td>
				<td>{{$value->txn_amount}}</td>
				<td><p class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$value->txn_id}}">{{\Illuminate\Support\Str::limit($value->txn_id ?? '', 15, $end='...') }}</p></td>
			</tr>
			@empty
			<tr><td colspan="6">No data found.</td></tr>
			@endforelse

		</tbody>
	</table>
</div>
<div class="custom-pagination mt-3">
	{{$result->onEachSide(0)->links()}}
</div>