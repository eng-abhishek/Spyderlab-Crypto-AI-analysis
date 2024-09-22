                @extends('frontend.layouts.app')
                @section('styles')
                <style type="text/css">
                    .highcharts-figure,
                    .highcharts-data-table table {
                        min-width: 320px;
                        max-width: 800px;
                        margin: 1em auto;
                    }

                    .highcharts-data-table table {
                        font-family: Verdana, sans-serif;
                        border-collapse: collapse;
                        border: 1px solid #ebebeb;
                        margin: 10px auto;
                        text-align: center;
                        width: 100%;
                        max-width: 500px;
                    }

                    .highcharts-data-table caption {
                        padding: 1em 0;
                        font-size: 1.2em;
                        color: #555;
                    }

                    .highcharts-data-table th {
                        font-weight: 600;
                        padding: 0.5em;
                    }

                    .highcharts-data-table td,
                    .highcharts-data-table th,
                    .highcharts-data-table caption {
                        padding: 0.5em;
                    }

                    .highcharts-data-table thead tr,
                    .highcharts-data-table tr:nth-child(even) {
                        background: #f8f8f8;
                    }

                    .highcharts-data-table tr:hover {
                        background: #f1f7ff;
                    }
                    .highcharts-credits{
                        display:none;
                    }
                </style>
                @endsection

                @section('content')
                <main>
                    <section class="section-home py-5">
                        <div class="container-xl container-fluid">
                            <div class="row justify-content-center text-center">
                                <div class="col-lg-12">
                                    <nav>
                                        <ol class="breadcrumb justify-content-center mb-3 text-light">
                                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                            <li class="breadcrumb-item active"><a href="{{route('blockchain-analysis')}}">Blockchain Analysis</a></li>
                                            <li class="breadcrumb-item active">Details</li>
                                        </ol>
                                    </nav>
                                    <h1 class="fs-2 mb-0">Details</h1>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="bg-custom-light py-5">
                        <div class="container-xl container-fluid">
                            <div class="row">
                                <div class="col-lg-8 col-md-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="coin-item">
                                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                                    @if(!empty($result->chain))
                                                    <img src="{{asset('assets/frontend/images/coins/'.$blockcypher_response['coin'].'.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3 coin-symbol">
                                                    @endif
                                                    <div class="flex-grow-1 text-md-start text-center">
                                                        <h2 class="">{{strtoupper($blockcypher_response['coin'])}}</h2> 
                                                        <h3 class="text-break key_address">
                                                            @if(!empty($result->address))
                                                            {{$result->address}}
                                                            @endif
                                                            <a href="javascript:void(0)" class="copy_address"><i class="fa-regular fa-copy mx-1"></i></a>
                                                            <!--<i class="fa-solid fa-flag-alt mx-1 text-danger"></i>-->
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#flagModal"><i class="fa-solid fa-flag-alt mx-1 text-danger"></i></a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-12 my-3">
                                            <div class="coin-item text-center">
                                                <h3 class="fs-4">AML Risk Score <i class="fa-regular fa-info-circle"></i></h3>
                                                @if($result->anti_fraud->credit == 1)
                                                <img src="{{asset('assets/frontend/images/icons/aml-safe.jpg')}}" alt="" class="mb-2">
                                                @elseif($result->anti_fraud->credit == 2)
                                                <img src="{{asset('assets/frontend/images/icons/aml-risk.jpg')}}" alt="" class="mb-2">
                                                @elseif($result->anti_fraud->credit == 3)
                                                <img src="{{asset('assets/frontend/images/icons/aml-warning.jpg')}}" alt="" class="mb-2">
                                                @endif
                <!--<h3>Fake_Phishing48035</h3>
                    <p class="mb-0"><small>Malicious Addresss, Phishing</small></p>-->
                </div>
            </div>

            <div class="col-lg-7 col-md-12 my-3">
                <div class="coin-item">
                    <div class="d-flex justify-content-md-between justify-content-center flex-md-row flex-column text-md-start text-center">
                        <div>
                            <h3 class="d-inline-block mb-0">Overview</h3>
                            <div class="btn-group rounded-pill overflow-hidden">
                                <a href="#" class="btn btn-main-3 btn-sm"><i class="fa-regular fa-bitcoin-sign"></i></a>
                                <a href="#" class="btn btn-main-3 btn-sm"><i class="fa-regular fa-dollar-sign"></i></a>
                            </div>
                        </div>                                        
                        <p class="fs-7 mb-0">Data Updated 1 min(s) ago <a href="#" class="custom-link"><i class="fa-regular fa-refresh"></i></a></p>
                    </div>
                    <div class="row mt-3">
                        @if($blockcypher_response['status']==200)
                        <div class="col-md-6">

                            <div class="address-info">
                                <h4>Balance</h4>
                                <h5>{{ ($blockcypher_response['coin']=='btc') ? $blockcypher_response['result']->balance/100000000 : $blockcypher_response['result']->balance}} SATS</h5>
                            </div>

                            <div class="address-info">
                                <h4>First Seen</h4>
                                @if(isset($blockcypher_response['result']->txs[0]->confirmed))
                                <h5>{{date('M d, H:i A',strtotime($blockcypher_response['result']->txs[count($blockcypher_response['result']->txs)-1]->confirmed))}}
                                </h5>
                                @endif
                            </div>             

                            <div class="address-info">
                                <h4>Total Received</h4>
                                <h5>{{ ($blockcypher_response['coin']=='btc') ? $blockcypher_response['result']->total_received/100000000 : $blockcypher_response['result']->total_received}} SATS</h5>
                            </div>

                            <div class="address-info">
                                <h4>Incoming Txn</h4>
                                <h5>{{$credit_count}}</h5>
                            </div>   
                        </div>

                        <div class="col-md-6">
                            <div class="address-info">
                                <h4>TXS Count</h4>
                                <h5>{{$blockcypher_response['result']->n_tx}}</h5>
                            </div>

                            <div class="address-info">
                                <h4>Last Seen</h4>
                                @if(isset($blockcypher_response['result']->txs[0]->confirmed))
                                <h5>{{date('M d, H:i A',strtotime($blockcypher_response['result']->txs[0]->confirmed))}}</h5>
                                @endif
                            </div>

                            <div class="address-info">
                                <h4>Total Sepnt</h4>
                                <h5>{{ ($blockcypher_response['coin']=='btc') ? ($blockcypher_response['result']->total_sent/100000000) : $blockcypher_response['result']->total_sent}} SATS</h5>
                            </div>

                            <div class="address-info">
                                <h4>Outgoing Txn</h4>
                                <h5>{{$debit_count}}</h5>
                            </div>
                        </div>

                        @else
                        <div class="text-center">
                            <img src="{{asset('assets/frontend/images/frown.png')}}" alt="" class="mb-2 coin-symbol">
                            <p class="mb-0"><small>Not Found</small></p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="coin-item">
            <h3 class="fs-5">
                Spyderlab AI detect
                <i class="fa-regular fa-info-circle"></i>
                <!--<i class="fa-brands fa-usb float-end"></i>-->
            </h3>
            @if(count($result->labels)>0)
            <p class="mb-1">This account is related to</p>
            @foreach($result->labels as $key=>$labelsData)
            <span class="badge bg-danger d-inline">{{ $labelsData->id }}</span>
            @endforeach
            @else

            <div class="text-center">
                <img src="{{asset('assets/frontend/images/frown.png')}}" alt="" class="mb-2 coin-symbol">
                <p class="mb-0"><small>Not Found</small></p>
            </div>
            @endif
        </div>

        <div class="coin-item my-3">
            <h3 class="fs-5">
                <i class="fa-solid fa-star"></i>
                Favorites
            </h3>
            <form>
                <label for="" class="form-label">Private Note: </label>
                <textarea name="user_notes" id="user_notes" rows="5" class="form-control" placeholder="Adding Note Here">{!! $user_notes !!}</textarea>
                <div class="form-text">* Only you can see this note</div>
            </form>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="coin-item my-3">
            <h3 class="fs-5">
                Tranaction Action Analysis
                <i class="fa-regular fa-info-circle"></i>
            </h3>
            <div class="row text-center">
                <div class="col-lg-6 my-3">
                    <h4 class="fs-6">Incoming Transaction Actions</h4>
                    <!-- Chart Start -->
                    <div>
                        <img src="https://cdn-icons-png.flaticon.com/512/2272/2272166.png" alt="" style="max-width: 200px;">
                        <p>Chart Here</p>
                    </div>
                    <!-- Chart End -->
                </div>
                <div class="col-lg-6 my-3">
                    <h4 class="fs-6">Outgoing Transaction Actions</h4>
                    <!-- Chart Start -->
                    <div>
                        <img src="https://cdn-icons-png.flaticon.com/512/2272/2272166.png" alt="" style="max-width: 200px;">
                        <p>Chart Here</p>
                    </div>
                    <!-- Chart End -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="coin-item my-3">
            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                <h3 class="fs-5 mb-md-0 mb-3">
                    Address Profile Analysis
                    <i class="fa-regular fa-info-circle"></i>
                </h3>
                <div class="d-flex">
                    <label class="form-check-label" for="txn">All Txs</label>
                    <div class="form-check form-switch ps-0">
                        <input class="form-check-input mx-1" type="checkbox" role="switch" id="txn" checked="">
                    </div>                                    
                    <label class="form-check-label" for="txn">Only Outgoing</label>                                    
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="d-flex flex-column flex-md-row justify-content-start">
                        <div class="me-md-5 d-flex address-analysis">
                            <p class="text-truncate text-nowrap gas-fee mb-0">Gas Fee Source: qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</p>
                            <i class="fa-regular fa-copy mx-1"></i>
                        </div>
                        <div class="address-analysis">Common Use Time: 00 00 00 00 00 (UTC)</div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-4 border-end py-3">
                    <h4 class="fs-6"><i class="fa-regular fa-buildings bg-dark p-2 rounded-circle text-light"></i> Platform Interaction</h4>
                    <div class="row">
                        <div class="col-lg-3 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>Exchange</h6>
                            </div>
                        </div>
                        <div class="col-lg-3 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>DeFi</h6>
                            </div>
                        </div>
                        <div class="col-lg-3 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>Coin Mixer</h6>
                            </div>
                        </div>
                        <div class="col-lg-3 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>NFT</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 border-end py-3">
                    <h4 class="fs-6"><i class="fa-regular fa-user-secret bg-dark p-2 rounded-circle text-light"></i> Related Events</h4>
                    <div class="row">
                        <div class="col-lg-4 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>Exchange</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>Exchange</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>Exchange</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 py-3">
                    <h4 class="fs-6"><i class="fa-regular fa-route bg-dark p-2 rounded-circle text-light"></i> Related Information</h4>
                    <div class="row">
                        <div class="col-lg-4 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>Exchange</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>Exchange</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 my-3">
                            <div class="address-vitals">
                                <h5>0</h5>
                                <h6>Exchange</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="coin-item my-3">
            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                <h3 class="fs-5 mb-md-0 mb-3">
                    Transaction Time Analysis
                    <i class="fa-regular fa-info-circle"></i>
                </h3>
                <div class="btn-group">
                    <a href="#" class="btn btn-main-3 btn-sm">UTC</a>
                    <a href="#" class="btn btn-main-3 btn-sm">UTC + 8</a>
                </div>
            </div>
            <!-- Chart Start -->
            <div class="row text-center">
                <div class="col-lg-12 my-3">
                    <img src="https://img.freepik.com/premium-vector/infographic-vector-design-statistics-investment-analysis-marketing-bar-graph_77986-644.jpg?w=1080" alt="" style="width:100%; max-width: 400px;">
                    <p>Chart Here</p>
                </div>
            </div>
            <!-- Chart End -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="coin-item my-3">
            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                <h3 class="fs-5 mb-md-0 mb-3">
                    Transaction Graph
                    <i class="fa-regular fa-info-circle"></i>
                </h3>
                <a href="#" class="btn btn-outline-dark btn-sm">New Investigation <span class="badge bg-danger">PRO</span></a>
            </div>
            <p class="text-secondary"><small><i class="fa-regular fa-lightbulb me-2"></i> Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, quis.</small></p>
            <!-- Chart Start -->
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 my-3 text-center">
                    <img src="https://img.freepik.com/premium-vector/infographic-vector-design-statistics-investment-analysis-marketing-bar-graph_77986-644.jpg?w=1080" alt="" style="width:100%; max-width: 400px;">
                    <p>Chart Here</p>
                </div>
                <div class="col-lg-6 my-3">
                    <div class="bg-custom-light p-3 rounded-3">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="" class="form-label">Date Range:</label>
                                    <input type="text" name="" id="" class="form-control" placeholder="yyyy-mm-dd">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="" class="form-label">To:</label>
                                    <input type="text" name="" id="" class="form-control" placeholder="yyyy-mm-dd">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="" class="form-label">Filter:</label>
                                    <select name="" id="" class="form-select form-control">
                                        <option value="">All Txs</option>
                                        <option value="">Demo</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="" class="form-label">&nbsp;</label>
                                    <select name="" id="" class="form-select form-control">
                                        <option value="">All Address</option>
                                        <option value="">Demo</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="bg-custom-light p-3 rounded-3 mt-3">
                        <h3 class="fs-5">Analysis</h3>
                        <div class="d-flex">
                            <p class="text-truncate mb-0">qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</p>
                            <i class="fa-regular fa-copy mx-2 lh-26"></i>
                            <span class="text-danger text-nowrap"><i class="fa-light fa-crosshairs text-danger"></i> Monitor</span>
                        </div>                                        
                        <form action="">
                            <div class="row my-3">
                                <div class="col-lg-12 mb-3">
                                    <div class="position-relative">
                                        <i class="fa-thin fa-magnifying-glass position-absolute start-0 top-50 translate-middle-y px-2"></i>
                                        <input type="text" name="" id="" class="form-control ps-4" placeholder="Search by address / label">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle txn-table">
                                        <thead>
                                            <tr>
                                                <th>Show</th>
                                                <th>Sender</th>
                                                <th>Txn</th>
                                                <th>ETH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="" id="" class="form-check-input" checked="">
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0 text-truncate txn-address">qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</p>
                                                    <p>
                                                        <i class="fa-light fa-crosshairs me-1"></i>
                                                        <i class="fa-light fa-copy me-1"></i>
                                                        <i class="fa-light fa-external-link"></i>
                                                        <span class="small-text">( Event Theft)</span>
                                                    </p>
                                                </td>
                                                <td>
                                                    <a href="#" class="custom-link text-decoration-underline">1</a>
                                                </td>
                                                <td>304.9696</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="custom-pagination">
                                    <nav>
                                        <ul class="pagination">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true"><i class="fa-light fa-chevrons-left"></i></span>
                                                </a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true"><i class="fa-light fa-chevrons-right"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle txn-table">
                                        <thead>
                                            <tr>
                                                <th>Show</th>
                                                <th>Recipient</th>
                                                <th>Txn</th>
                                                <th>ETH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="" id="" class="form-check-input" checked="">
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0 text-truncate txn-address">qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</p>
                                                    <p>
                                                        <i class="fa-light fa-crosshairs me-1"></i>
                                                        <i class="fa-light fa-copy me-1"></i>
                                                        <i class="fa-light fa-external-link"></i>
                                                        <span class="small-text">( Event Theft)</span>
                                                    </p>
                                                </td>
                                                <td>
                                                    <a href="#" class="custom-link text-decoration-underline">1</a>
                                                </td>
                                                <td>304.9696</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="custom-pagination">
                                    <nav>
                                        <ul class="pagination">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true"><i class="fa-light fa-chevrons-left"></i></span>
                                                </a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true"><i class="fa-light fa-chevrons-right"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>

<div class="modal fade custom-modal" id="flagModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header section-home">
                <h4 class="modal-title fs-6">Report</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom-light">
                <div class="coin-item mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                        @if(!empty($result->chain))           
                        <img src="{{asset('assets/frontend/images/coins/'.$blockcypher_response['coin'].'.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3 coin-symbol">
                        @endif
                        <div class="flex-grow-1 text-md-start text-center">
                            @if(!empty($result->address))
                            <h3 class="text-break">{{$result->address}}</h3>
                            @endif
                            <p class="mb-0"><small>@if($total_flag > 0) {{$total_flag}} Report @else No Report @endif</small></p>
                        </div>
                    </div>
                </div>

                <div class="form-wrap">                             
                    <form action="{{route('flag')}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="" class="form-label">Report: </label>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="report_type" id="inlineRadio1" value="Phishing" checked>
                                    <label class="form-check-label" for="inlineRadio1">Phishing</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="report_type" id="inlineRadio2" value="Ransom">
                                    <label class="form-check-label" for="inlineRadio2">Ransom</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="report_type" id="inlineRadio3" value="Theft">
                                    <label class="form-check-label" for="inlineRadio3">Theft</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="report_type" id="inlineRadio4" value="Other">
                                    <label class="form-check-label" for="inlineRadio3">Other</label>
                                </div>

                                @error('report_type')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="" class="form-label">Description: </label>
                            </div>
                            <div class="col-lg-9">
                                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Please enter the desctiption"></textarea>
                                @error('description')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                            @if(!empty($result->address))
                            <input type="text" hidden name="address" value="{{$result->address}}">
                            @endif
                            <input type="text" name="address_type" hidden value="{{$blockcypher_response['coin']}}">
                        </div>

                        <div class="row">
                            <div class="col-lg-12 text-end">                                    
                                <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-main-2">Report</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@if(session()->has('status'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-bg-{{session('status')}} border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{session('message')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
<div class="toast-container position-fixed bottom-0 end-0 p-3 ajax-alert-box d-none">
    <div class="toast align-items-center toster-bg border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body toster-ajax-message">

            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
</main>
@endsection
@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/networkgraph.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>

<script type="text/javascript">

    var network_graph_url = @json(route('blockchain-search.network-graph'));
    var keyword = @json($keyword);

    $(document).ready(function(){
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            },
            type: "get",
            url: network_graph_url+"?keyword="+keyword,
            success: function (result) {
                if(result.status == 'success'){
                    draw_network_graph(result.network_graph_data);
                }else{
                    draw_network_graph([]);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                draw_network_graph([]);
            }
        });

        $('#user_notes').on('focusout',function(){
            var user_notes = $('#user_notes').val();
            var address = $('.key_address').text();
            $.ajax({
                headers:{
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                },
                url:"{{route('notes')}}",
                type:"POST",
                data:{user_notes:user_notes,address:address},
                success:function(result){
                    console.log(result.message);
                    console.log(result.status);
                    $('.ajax-alert-box').removeClass('d-none');
                //$('.toster-bg').addClass('show');      
                $('.toster-bg').addClass('text-bg-'+result.status);
                $('.toster-ajax-message').html(result.message);
            }
        })
        })
    });

    function draw_network_graph(network_graph_data){
        Highcharts.addEvent(
            Highcharts.Series,
            'afterSetOptions',
            function (e) {
                var colors = Highcharts.getOptions().colors,
                i = 0,
                nodes = {};

                if (
                    this instanceof Highcharts.Series.types.networkgraph &&
                    e.options.id === 'lang-tree'
                    ) {
                    e.options.data.forEach(function (link) {

                        if (link[0] === 'Account') {
                            nodes['Account'] = {
                                id: 'Account',
                                marker: {
                                    radius: 20
                                }
                            };
                            nodes[link[1]] = {
                                id: link[1],
                                marker: {
                                    radius: 10
                                },
                                color: colors[i++]
                            };
                        } else if (nodes[link[0]] && nodes[link[0]].color) {
                            nodes[link[1]] = {
                                id: link[1],
                                color: nodes[link[0]].color
                            };
                        }
                    });

                e.options.nodes = Object.keys(nodes).map(function (id) {
                    return nodes[id];
                });
            }
        }
        );

        Highcharts.chart('highchart_network_graph', {
            chart: {
                type: 'networkgraph',
                height: '100%',
                // events: {
                //     load: function() {
                //         // this.renderer.image('http://localhost/osint-laravel/public/assets/frontend/images/logo-wm.png').add();
                //         this.renderer.image('http://194.59.165.2/assets/frontend/images/logo-wm.png', 80, 40, 650, 800).add();
                //     }
                // }
                plotBackgroundImage: '{{asset('assets/frontend/images/logo-wm.png')}}',
            },
            credits: {
                text: 'Spyderlab',
                href: 'http://194.59.165.2/'
            },
            lang: {
                noData: "<i class='fa-light fa-ban'></i> No data to display"
            },
            title: {
                text: 'Blockchain Trace Graph',
                align: 'left'
            },
            subtitle: {
                text: keyword,
                align: 'left'
            },
            plotOptions: {
                networkgraph: {
                    keys: ['from', 'to'],
                    layoutAlgorithm: {
                        enableSimulation: true,
                        friction: -0.9
                    }
                }
            },
            series: [{
                accessibility: {
                    enabled: false
                },
                dataLabels: {
                    enabled: true,
                    linkFormat: '',
                    style: {
                        fontSize: '0.8em',
                        fontWeight: 'normal'
                    }
                },
                id: 'lang-tree',
                data: network_graph_data
            }],
            exporting: {
                chartOptions: {
                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true
                            }
                        },
                        networkgraph: {
                            layoutAlgorithm: {
                                enableSimulation: false,
                            }
                        }
                    }
                }
            }
        });
    }
</script>

@endsection