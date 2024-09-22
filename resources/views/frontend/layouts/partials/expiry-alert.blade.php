
@if((available_plan() != 1) OR (plan_expire_at() != 1))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	@if(available_plan() == 'Expired Sub')
	<h5> Oop`s Your subscription will expired</h5>
	@elseif(available_plan() == 'No Active Sub')
	<h5> Oop`s Your have not any active plan</h5>
	@elseif(available_plan() == 'No Sub')
	<h5> Oop`s Your have not any subscription</h5>
	@elseif(plan_expire_at() == 'Y')
	<h5>Your subscription will expire within {{get_date_diff()}} please renew/upgrade it.</h5>
	@endif
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif