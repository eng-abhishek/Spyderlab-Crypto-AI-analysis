@extends('frontend.layouts.account_app')
@section('content')

<div id="content" class="collapsed">
    <div class="main-content">
        <div class="container">
            <div class="osint-section py-4">
                <div class="col-md-12">
                    <div class="card heading-osint">
                      <div class="heading3 d-flex">
                        <h3><i class="fa fa-search fa-1x"></i> Search</h3>
                    </div>
                </div>
            </div>
            <!-- case variations universal Ai -->
            <div class="ai-details-card">
              <div class="container">
                <div class="ai-information-card">
                  <div class="row">
                    <div class="col-md-6">
                      <h6><b>CASE VARIATIONS</b></h6>
                      <div class="card">
                        <div class="case-variations py-4 px-2">
                           <div class="row">
                            <div class="col-md-6">
                              <div class="osint-graph">
                                <img src="{{asset('assets/account/images/osint/pie-chart-demo.svg')}}" height="150">
                            </div>

                        </div>

                        <div class="col-md-6">
                          <ul class="py-3">
                            <li>Extortion </li>
                            <li>Fake profile  </li>
                            <li> AI generated  </li>
                            <li>Scam </li>
                            <li>Crypto Fraud</li>
                        </ul>
                    </div>

                </div>
                
            </div>

        </div>
    </div>
    <div class="col-md-6">
      <h6><b>UNIVERSAL AI</b></h6>
      <div class="card universa">
        <div class="universal-ai py-4 px-4">
          <div class="row">
            <div class="col-md-4">
              <div class="logo">
                <img src="{{asset('assets/frontend/images/logo.png')}}">
            </div>

        </div>

        <div class="col-md-8">
          <form>
            <div class="mb-3 universal-ai-form">
              <label for="example" class="form-label"></label>
              <input type="text" class="form-control" id="example" aria-describedby="">
          </div>
          <button type="submit" class="btn btn-primary">Search</button>
          
      </form>
      
  </div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-md-12">
  <div class="card available-credits">
    <div class="credit d-flex tex-center justify-content-center">
      <h4>Available credits:<span>{{available_credits()}}</span></h4>
      <a href="{{route('pricing')}}"><button class="btn btn-credits mx-3" type="buttton">Buy Credits</button></a>
  </div>
</div>
</div>

<div class="search-osint">
   
    <div class="search-information">
      <div class="row">
        <div class="col-md-3">
          <div class="card email" onclick="toggleEmailInfo()">
              <img src="{{asset('assets/account/images/osint/message-osint.svg')}}" alt="Email">
              <h6>Email Lookup</h6>
          </div>
      </div>
      <div class="col-md-3">
          <div class="card phone-number" onclick="togglePhoneNumberInfo()">
              <img src="{{asset('assets/account/images/osint/phone-osint.svg')}}" alt="Phone Number">
              <h6>Phone Number Lookup</h6>
          </div>
      </div>
      <div class="col-md-3">
        <div class="card social-network-search-engine" onclick="togglesocialnetworkInfo()">
            <img src="{{asset('assets/account/images/osint/social-network-osint.svg')}}" alt="Phone Number">
            <h6>Social Network Lookup</h6>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card username-osint" onclick="toggleusernameInfo()">
            <img src="{{asset('assets/account/images/osint/username-osint.svg')}}" alt="Phone Number">
            <h6>Username OSINT</h6>
        </div>
    </div>  
</div>

<!-- Phone Number Information -->
<div class="phone-number-information">
    <div class="row">

        <form action="{{route('search.submit')}}" method="post" class="mt-3 search-by-phone">
            @csrf
            <input type="hidden" name="search_by" value="phone">

            <div class="col-md-3">
                <div class="number">
                    <select name="country_code" id="country_code" class="form-select py-3" aria-label="Default select example">

                        @foreach($countries as $code => $phone_code)
                        <option value="{{$code}}" {{($country_code == $code)?'selected="selected"':''}}>{{$code}} ({{$phone_code}})</option>
                        @endforeach

                    </select>
                </div>
            </div>

            <div class="col-md-9">
                <div class="number-search">
                    <div class="input-group mb-3">
                        <input type="hidden" name="search_by" value="phone">
                        <input type="text" id="search" class="form-control py-3" placeholder="Search Phone Number" aria-label="Search Phone Number" aria-describedby="basic-addon2" name="phone_number" value="{{$phone_number}}">
                        @error('phone_number')
                        <span class="invalid-feedback d-block">{{$message}}</span>
                        @enderror
                        <button type="submit" class="btn input-group-text" id="basic-addon2"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- Email Information -->
<div class="email-information">
  <div class="row">
      <div class="col-md-9">

          <form action="{{route('search.submit')}}" method="post" class="mt-3 search-by-email">
              @csrf
              <input type="hidden" name="search_by" value="email">

              <div class="email-search">
                  <div class="input-group mb-3">

                      <input type="search" id="search" class="form-control py-3" placeholder="Search Email" name="email" aria-label="Search Email" aria-describedby="basic-addon2" value="{{$email ?? ''}}">

                      <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
                  </div>
              </div>
          </form>

      </div>
  </div>
</div>
</div>
</div> 

@if(!is_null($email))
<section class="email-details-osint py-4">
    <div class="container">
        <div class="col-md-12">
            <div class="card connected-accounts">
                <h5 class="card-header text-center">Connected Accounts</h5>
                <div class="card-body">
                    <h5 class="card-title">{{$email}}</h5>

                    @if(!is_null($connected_accounts))
                    <ul>
                        @foreach($connected_accounts as $domain)
                        <li>{{$domain}}</li>
                        @endforeach
                    </ul>
                    @else
                    No Data Found.
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
@endif


</div>
</div>
</div>
</div>
</div>

@endsection