<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body style="padding: 0; margin: 0;">
        <table style="color:#000000;font-size:medium;padding:50px 0px;margin:0px;min-height:100%;min-width:100%;background-color:#ffffff;font-family:Arial, Helvetica, sans-serif">
            <tbody>
                <tr>
                    <td>
                        <table style="max-width:600px;width:auto;margin:0px auto;padding:0px;    background-color: #17195f;background-image: linear-gradient(65.5deg, #17cdcd -15.1%, #17195f 71.5% );border-spacing:0px;border-width:0;border-style:solid; color: #ffffff; font-weight: 400; border-radius: 12px;">
                            <tbody>
                                <tr>
                                    <td style="border-spacing:0px;border-color:transparent;text-align:center; padding: 20px 20px 0;"><img src="https://www.spyderlab.org/assets/frontend/images/icons/logo.png" style="width: 100px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:20px;text-align:left;font-size:20px">
                                        <h2><img src="https://cygnusgastro.com/wp-content/uploads/2021/09/siren.gif" style="max-width: 36px; margin-right: 12px; display: inline; vertical-align: bottom;">Spyderlab Alert</h2>

                                        <h3>Monitor Description: <span style="font-weight: 400; font-size: 18px;">
                                            {{\Illuminate\Support\Str::limit($transactions[0]['monitoring_des'], 15, $end='...')}}
                                          </span></h3>
                                        <h3>Monitor Address: <span style="font-weight: 400; font-size: 18px; word-wrap: break-word; display: inline-block; max-width: 560px;">{{$transactions[0]['monitoring_address']}}</span></h3>
                                        
                                        <h3>Activity:</h3>
                                        <ul>
                                        @foreach($transactions as $value)
                                        <li class="text-white">
                                        <span style="font-size: 20px; font-weight: 700;">Transaction Id:</span> {{$value['txn_id']}}<br>
                                        <span style="font-size: 20px; font-weight: 700;">Amount:</span> {{$value['amount']}}<br>
                                        <span style="font-size: 20px; font-weight: 700;">Transaction Date:</span> {{$value['confirmed_at']}} <a href="{{$url}}" target="_blank" style="color: #00d9ff;">ViewTx</a><br>
                                        </li>
                                        <hr class="text-white">
                                        @endforeach
                                        </ul>
                                        <h3>You Have Total Transaction: {{$total_txn}}</h3>
                                        <div style="margin-top: 12px; margin-bottom: 40px; text-align: center;">
                                            <a href="{{$url}}" style="padding: 0 24px; height: 40px; line-height: 40px; background: #a43ab2; background: linear-gradient(33deg, #a43ab2, #e13680); color: #ffffff; text-decoration: none; display: inline-block; border-radius: 4px;">Explore</a>
                                        </div>
                                        <p style="color: #e7e7e7; font-size: 16px;">The button is invalid? Please copy and paste the following link to the browser to open the page: <a href="{{$url}}" target="_blank" style="color: #e7e7e7;word-wrap: break-word; display: inline-block; max-width: 560px;">{{$url}}</a></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>