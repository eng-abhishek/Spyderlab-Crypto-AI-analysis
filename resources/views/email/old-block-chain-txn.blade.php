@foreach($transactions as $value)

<p><b>Transaction Id</b>: {{$value['txn_id']}} </p>
<p><b>Amount</b>: {{$value['amount']}} </p>
<p><b>Transaction Date</b>: {{$value['confirmed_at']}}  </p>
<hr>
@endforeach

<h3>You Have Total Transaction: {{$total_txn}}</h3>
<p>For More: <a href="{{$url}}">Click Here..</a></p>
OR
<p>Visit : <a href="{{$url}}">{{$url}}</a></p>
