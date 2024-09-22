  <div class="row">

    @forelse($plans as $key => $plansData)
    <div class="col-lg-3 col-md-6 mb-lg-0 mb-5">
        <div class="crypto-pricing">
         @if($type == 'M')
         <div class="crypto-pricing-head crypto-pricing-bg-{{$key+1}} text-center">
            <h4>{{$plansData->name}}</h4>
            @if(($plansData->is_free == 'Y'))
            <p></p>
            @else
            <p><i class="fa-light fa-inr"></i> {{ convertCurrency('INR','USD',round(($plansData->yearly_price),2)) }} per year</p>
            @endif
            <div class="crypto-price-wrap">
                @if(($plansData->is_free == 'Y'))
                <h5 class="crypto-price"><i class="fa-light fa-inr"></i>
                {{convertCurrency('INR','USD',$plansData->monthly_price)}}<span>/{{$plansData->duration}}Days</span></h5>
                @else
                <h5 class="crypto-price"><i class="fa-light fa-inr"></i> {{convertCurrency('INR','USD',$plansData->monthly_price)}} <span>/Month</span></h5>
                @endif
            </div>
        </div>
        @else
        <div class="crypto-pricing-head crypto-pricing-bg-{{$key+1}} text-center">
            <h4>{{$plansData->name}}</h4>
            @if(($plansData->is_free == 'Y'))
            <p></p>
            @else
            <p><i class="fa-light fa-inr"></i> {{convertCurrency('INR','USD',round(($plansData->monthly_price),2))}} per month</p>
            @endif
            <div class="crypto-price-wrap">
                @if(($plansData->is_free == 'Y'))
                <h5 class="crypto-price"><i class="fa-light fa-inr"></i> {{convertCurrency('INR','USD',$plansData->yearly_price)}}<span>/{{$plansData->duration}}Days</span></h5>
                @else
                <h5 class="crypto-price"><i class="fa-light fa-inr"></i> {{convertCurrency('INR','USD',$plansData->yearly_price)}} <span>/Year</span></h5>
                @endif
            </div>
        </div>
        @endif
        <div class="crypto-pricing-content">
            <ul>
                @php 
                $feature = json_decode($plansData->feature);
                @endphp
                
                @foreach($feature as $featureData)
                <li>{{$featureData->feature}}</li>
                @endforeach
            </ul>
            <div class="text-center">
                @if(($plansData->is_free == 'Y') AND (!is_null(auth()->user())) )
                @if($check_free_user < 1)
                <a href="{{route('buy.subscription',$plansData->slug)}}" class="btn btn-pricing btn-sm">Buy Now</a>
                @endif
                @else
                @if(($plansData->is_free == 'Y'))
                <a href="{{route('login')}}" class="btn btn-pricing btn-sm">Buy Now</a>
                @else
                <a href="{{route('contact-us')}}" class="btn btn-pricing btn-sm">Buy Now</a>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@empty

@endforelse

{{--<div class="col-lg-3 col-md-6 mb-lg-0 mb-5">
    <div class="crypto-pricing">
        <div class="crypto-pricing-head crypto-pricing-bg-4 text-center">
            <h4>Enterprise</h4>
            <p>Custom plan</p>
            <div class="crypto-price-wrap">
                <h5 class="crypto-price fs-5">Contact Sales</h5>
            </div>
        </div>
        <div class="crypto-pricing-content">
            <div class="text-center">
                <a href="{{route('contact-us')}}" class="btn btn-pricing btn-sm">Contact Sales</a>
            </div>
        </div>
    </div>
</div>--}}
</div>