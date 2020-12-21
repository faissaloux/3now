@extends('crm.layout.base')

@section('title', 'Ride History')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"> <i class="fa fa-recycle"></i> &nbsp;Fahrverlauf</h5>
            <hr/>
            @if(count($requests) != 0)
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nutzer</th>
                        <th>Treiber</th>
                        <th>Datum</th>
                        <th>Status</th>
                        <th>Fahrpreis</th>
                        <th>Zahlung</th>
                        <th>Zahlungsstatus</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody>
               
                @foreach($requests as $index => $request)
                    <tr>
                        <td>{{ $request->booking_id }}</td>
                        <td>
                            @if($request->user)
                                {{ @$request->user->first_name }} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($request->provider)
                                {{ @$request->provider->first_name }} 
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($request->created_at)
                                <span class="text-muted">{{$request->created_at->diffForHumans()}}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $request->status }}</td>
                        <td>
                            @if($request->payment != "")
                                {{ currency($request->payment->total) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $request->payment_mode }}</td>
                        <td>
                            @if($request->paid)
                                Bezahlt
                            @else
                                Nicht bezahlt
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn shadow-box btn-rounded btn-black waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Aktion
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('crm.requests.show', $request->id) }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> Mehr Details
                                    </a>
                                    <form action="{{ route('admin.requests.destroy', $request->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-trash"></i> Löschen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nutzer</th>
                        <th>Treiber</th>
                        <th>Datum</th>
                        <th>Status</th>
                        <th>Fahrpreis</th>
                        <th>Zahlung</th>
                        <th>Zahlungsstatus</th>
                        <th>Aktion</th>
                    </tr>
                </tfoot>
            </table>
            @else
            <h6 class="no-result">keine Ergebnisse gefunden</h6>
            @endif 
        </div>
    </div>
</div>
@endsection
