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
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active"><a href="blockchair.html">Blockchain Analysis</a></li>
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
            <div class="row justify-content-center align-items-start">

                <div class="col-lg-6 col-md-12">
                    <div class="listing-wrap my-3 p-3">
                        <ul class="list-unstyled mb-0">
                            <li>Type: <span>{{$chainsight->type}}</span></li>
                            @if(!empty($chainsight->chain))
                            <li>Chain: <span>{{$chainsight->chain->name}}</span></li>
                            @endif
                            @if(!empty($chainsight->address))
                            <li class="text-break">Address: <span>{{$chainsight->address}}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="listing-wrap my-3 px-md-0 px-3">
                        <div class="d-flex justify-content-between align-items-stretch flex-md-row flex-column">

                            @if($chainsight->anti_fraud->credit == 1)
                            <div class="listing-chainsight me-md-3 my-md-0 my-3 me-auto ms-auto mb-md-0 mb-3 d-flex justify-content-center flex-column">
                                <p class="mb-1">AML Risk Factor</p>
                                <img src="{{asset('assets/frontend/images/icons/aml-safe.jpg')}}">
                            </div>
                            @elseif($chainsight->anti_fraud->credit == 2)
                            <div class="listing-chainsight me-md-3 my-md-0 my-3 me-auto ms-auto mb-md-0 mb-3 d-flex justify-content-center flex-column">
                                <p class="mb-1">AML Risk Factor</p>
                                <img src="{{asset('assets/frontend/images/icons/aml-risk.jpg')}}">
                            </div>
                            @elseif($chainsight->anti_fraud->credit == 3)
                            <div class="listing-chainsight me-md-3 my-md-0 my-3 me-auto ms-auto mb-md-0 mb-3 d-flex justify-content-center flex-column">
                                <p class="mb-1">AML Risk Factor</p>
                                <img src="{{asset('assets/frontend/images/icons/aml-warning.jpg')}}">
                            </div>                                    
                            @endif

                            <div class="flex-grow-1 text-md-start text-center p-2">
                                <ul class="list-unstyled mb-0">
                                    <li>Spyder AI Detect: <span>
                                        @if($chainsight->anti_fraud->credit == 1)
                                        Success
                                        @elseif($chainsight->anti_fraud->credit == 2)
                                        Cautious
                                        @elseif($chainsight->anti_fraud->credit == 3)
                                        Warning
                                        @endif
                                    </span></li>
                                </ul>
                                @if(count($chainsight->labels)>0)
                                <p class="mb-1">This account is related to</p>
                                @foreach($chainsight->labels as $key=>$labelsData)
                                <span class="badge bg-danger d-inline">{{ $labelsData->id }}</span>
                                @endforeach
                                @else
                                <p class="mb-1">This account currently is not related to any known fraud activity.</p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-8 col-md-6">
                            <h2 class="fs-4">Insights</h2>
                        </div>
                        <div class="col-lg-4 col-md-6 text-md-end text-start">
                            <form action="">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <label for="period" class="col-form-label">Period: </label>
                                    </div>
                                    <div class="col-auto flex-grow-1">
                                        <input type="date" name="period" id="period" placeholder="Select Date/Time" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 col-md-12">
                    <div class="p-5">
                        <figure class="highcharts-figure">
                            <div id="highchart_network_graph"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>
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