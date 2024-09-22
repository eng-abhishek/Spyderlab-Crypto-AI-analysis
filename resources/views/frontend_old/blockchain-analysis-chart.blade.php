@extends('frontend.layouts.app')
@section('title', settings('site')->meta_title ?? config('app.name'))
@section('description', settings('site')->meta_description ?? '')
@section('keywords', settings('site')->meta_keywords ?? '')
@section('content')
<main>
    <section class="section-home py-5">
        <div class="container-xl container-fluid">
            <div class="row justify-content-center text-center">
                <div class="col-lg-12">
                    <nav>
                        <ol class="breadcrumb justify-content-center mb-3 text-light">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Page Title</li>
                        </ol>
                    </nav>
                    <h1 class="fs-2 mb-0">Page Title</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-custom-light py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    <div class="sticky-top top-16 mb-3">
                        <ul class="list-unstyled tracking-sidebar tracking-sidebar-height mb-0">
                            <li><a href="favorites.html"><i class="fa-light fa-star tracking-sidebar-icon"></i> Favorites</a></li> 
                            <li><a href="investigations.html"><i class="fa-light fa-radar tracking-sidebar-icon"></i> Investigations</a></li>
                            <li><a href="monitorings.html"><i class="fa-light fa-crosshairs tracking-sidebar-icon"></i> Monitorings</a></li>
                        </ul>                          
                        <p class="sidebar-footer-text text-center mb-0">Lorem ipsum dolor sit amet</p>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="coin-item">
                                        <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                            <img src="assets/images/coins/btc.png" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3 coin-symbol">
                                            <div class="flex-grow-1 text-md-start text-center">
                                                <h2>ETH <span>EOA <i class="fa-regular fa-info-circle"></i></span></h2>
                                                <h3 class="text-break">
                                                    qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy
                                                    <i class="fa-regular fa-copy mx-1"></i>
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
                                        <h3 class="fs-4">AML Risk Score <i class="fa-regular fa-info-circle"></i></span></h3>
                                        <img src="assets/images/aml-warning.jpg" alt="" class="mb-2">
                                        <h3>Fake_Phishing48035</h3>
                                        <p class="mb-0"><small>Malicious Addresss, Phishing</small></p>
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
                                            <div class="col-md-6">
                                                <div class="address-info">
                                                    <h4>Balance</h4>
                                                    <h5>0.002 ETH</h5>
                                                </div>
                                                <div class="address-info">
                                                    <h4>Balance</h4>
                                                    <h5>0.002 ETH</h5>
                                                </div>
                                                <div class="address-info">
                                                    <h4>Balance</h4>
                                                    <h5>0.002 ETH</h5>
                                                </div>
                                                <div class="address-info">
                                                    <h4>Balance</h4>
                                                    <h5>0.002 ETH</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="address-info">
                                                    <h4>Balance</h4>
                                                    <h5>0.002 ETH</h5>
                                                </div>
                                                <div class="address-info">
                                                    <h4>Balance</h4>
                                                    <h5>0.002 ETH</h5>
                                                </div>
                                                <div class="address-info">
                                                    <h4>Balance</h4>
                                                    <h5>0.002 ETH</h5>
                                                </div>
                                                <div class="address-info">
                                                    <h4>Balance</h4>
                                                    <h5>0.002 ETH</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="coin-item">
                                <h3 class="fs-5">
                                    Address Labels
                                    <i class="fa-regular fa-info-circle"></i>
                                    <i class="fa-brands fa-usb float-end"></i>
                                </h3>
                                <div class="text-center">
                                    <img src="assets/images/frown.png" alt="" class="mb-2 coin-symbol">
                                    <p class="mb-0"><small>Not Found</small></p>
                                </div>
                            </div>
                            <div class="coin-item my-3">
                                <h3 class="fs-5">
                                    <i class="fa-solid fa-star"></i>
                                    Favorites
                                </h3>
                                <form action="">
                                    <label for="" class="form-label">Private Note: </label>
                                    <textarea name="" id=""  rows="5" class="form-control" placeholder="Adding Note Here"></textarea>
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
                                            <input class="form-check-input mx-1" type="checkbox" role="switch" id="txn" checked>
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
                                                                            <input type="checkbox" name="" id="" class="form-check-input" checked>
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
                                                                        <a href="#" class="custom-link text-decoration-underline" data-bs-toggle="modal" data-bs-target="#transactionModal">1</a>
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
                                                                            <input type="checkbox" name="" id="" class="form-check-input" checked>
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
                                                                        <a href="#" class="custom-link text-decoration-underline" data-bs-toggle="modal" data-bs-target="#transactionModal">1</a>
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
            </div>
        </div>
    </section>
    @include('frontend.layouts.partials.alert-message')
</main>
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
                        <img src="assets/images/coins/btc.png" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3 coin-symbol">
                        <div class="flex-grow-1 text-md-start text-center">
                            <h3 class="text-break">qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</h3>
                            <p class="mb-0"><small>No Report</small></p>
                        </div>
                    </div>
                </div>
                <div class="form-wrap">                             
                    <form action="">
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="" class="form-label">Report: </label>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                                    <label class="form-check-label" for="inlineRadio1">Phishing</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                    <label class="form-check-label" for="inlineRadio2">Ransom</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                    <label class="form-check-label" for="inlineRadio3">Theft</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="option4">
                                    <label class="form-check-label" for="inlineRadio3">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="" class="form-label">Description: </label>
                            </div>
                            <div class="col-lg-9">
                                <textarea name="" id="" rows="5" class="form-control" placeholder="Please enter the desctiption"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-end">                                    
                                <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-main-2">Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade custom-modal" id="transactionModal">
    <div class="modal-dialog modal-xl modal-fullscreen-xl-down">
        <div class="modal-content">
            <div class="modal-header section-home">
                <h4 class="modal-title fs-6">Transactions</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom-light">
                <div class="table-responsive">
                    <table class="table table-bordered table-list">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Sender</th>
                                <th>Recipient</th>
                                <th>Amount</th>
                                <th>Time</th>
                                <th>Txn. ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><p class="mb-0 text-break txn-address">qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</p></td>
                                <td><p class="mb-0 text-break txn-address">qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</p></td>
                                <td>0.0035 btc</td>
                                <td>01, Jan 23 | 10:00 am</td>
                                <td>TXn123</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><p class="mb-0 text-break txn-address">qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</p></td>
                                <td><p class="mb-0 text-break txn-address">qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</p></td>
                                <td>0.0035 btc</td>
                                <td>01, Jan 23 | 10:00 am</td>
                                <td>TXn123</td>
                            </tr>
                        </tbody>
                    </table>
                </div>                    
                <div class="custom-pagination">
                    <nav>
                        <ul class="pagination float-end">
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
@endsection