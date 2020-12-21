@extends('admin.layout.base')

@section('title', 'Payment History ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h5 class="mb-1"><i class="ti-files"></i>&nbsp;Zahlungshistorie<hr></h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
                            <th>Anfrage ID</th>
                            <th>Transaktions-ID</th>
                            <th>Benutzer</th>
                            <th>Treiber</th>
                            <th>Gesamtmenge</th>
                            <th>Zahlungsart</th>
                            <th>Zahlungsstatus</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $index => $payment)
                        <tr>
                            <td>{{$payment->id}}</td>
                            <td>{{$payment->payment->payment_id}}</td>
                            <td>{{$payment->user->first_name}}</td>
                            <td>{{$payment->provider->first_name}}</td>
                            <td>{{currency($payment->payment->total)}}</td>
                            <td>{{$payment->payment_mode}}</td>
                            <td>
                                @if($payment->paid)
                                    Paid
                                @else
                                    Not Paid
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Anfrage ID</th>
                            <th>Transaktions-ID</th>
                            <th>Benutzer</th>
                            <th>Treiber</th>
                            <th>Gesamtmenge</th>
                            <th>Zahlungsart</th>
                            <th>Zahlungsstatus</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
@endsection