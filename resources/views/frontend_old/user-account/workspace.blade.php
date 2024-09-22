@extends('frontend.layouts.account_app')
@section('content')
  <div id="content" class="collapsed">
    <div class="main-content">
        <div class="container">
            <div class="heading1">
                <div class="col-md-12">
                    <h3>WORKSPACE</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="credit">
                        <div class="card">
                            <div class="d-flex user-credit-section">
                                <i class="fa fa-money-check"></i>
                                <h3>User Credits</h3>
                            </div>
                            <div class="deposit">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Total Credit(s)</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>{{available_credits()}}<a href="{{route('pricing')}}" class="btn btn-success btn-sm">Buy Credits</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="system">
                        <div class="card">
                            <div class="system">
                                <div class="heading">
                                <h4>SYSTEM STATUS</h4>
                                </div>
                                <div class="list">
                                <ol>
                                    <li>Crypto Node<button type="button" class="btn btn-success btn-sm">online</button></li>
                                    <li>OSINT node<button type="button" class="btn btn-success btn-sm">online</button></li>
                                    <li>Darknet Tor Node<button type="button" class="btn btn-success btn-sm">online</button></li>
                                </ol>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
