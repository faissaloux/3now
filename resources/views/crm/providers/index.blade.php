@extends('crm.layout.base')

@section('title', 'Providers ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
		<div class="row row-md">
         <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-success mb-2">
               <div class="t-content">
                  <h5 class="text-uppercase mb-1">Gesamtzahl der Treiber</h5>
                  <h5 class="text-uppercase mb-1">{{ $totaldrivers }}</h5>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-primary mb-2">
               <div class="t-content">
                  <h5 class="text-uppercase mb-1">Gesamtfahrten </h5>
                  <h5 class="text-uppercase mb-1">{{ $totaltrips }} </h5>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="box box-block bg-warning mb-2">
               <div class="t-content">
                  <h5 class="text-uppercase mb-1">Fahrten insgesamt abbrechen</h5>
                  <h5 class="text-uppercase mb-1">{{ $totalcanceltrips }}</h5>
               </div>
            </div>
         </div>
      </div>
        <div class="box box-block bg-white">
            <h5 class="mb-1">
               <i class="ti-basketball"></i>&nbsp; Treiber
            </h5><hr>
            <a href="{{ route('crm.provider.create') }}" style="margin-left: 1em;" class="btn btn-success shadow-box btn-rounded pull-right"><i class="fa fa-plus"></i> Neuen Treiber hinzufügen</a>
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobiltelefon</th>
                        <th>Unterlagen</th>
                        <th>Online</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($providers as $index => $provider)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $provider->first_name }} {{ $provider->last_name }}</td>
                        <td>{{ $provider->email }}</td>
                        <td>{{ $provider->mobile }}</td>
                        <td>
                            @if($provider->pending_documents() > 0 || $provider->service == null)
                                <a class="btn btn-danger btn-block label-right shadow-box" href="{{route('crm.provider.document.index', $provider->id )}}">Beachtung! <span class="btn-label">{{ $provider->pending_documents() }}</span></a>
                            @else
                                <a class="btn btn-success btn-block shadow-box" href="{{route('crm.provider.document.index', $provider->id )}}">Alles bereit</a>
                            @endif
                        </td>
                        <td>
                            @if($provider->service)
                                @if($provider->service->status == 'active')
                                    <label class="btn btn-block btn-success shadow-box">Ja</label>
                                @else
                                    <label class="btn btn-block btn-warning shadow-box">Nein</label>
                                @endif
                            @else
                                <label class="btn btn-block btn-danger shadow-box">N/A</label>
                            @endif
                        </td>
                        <td>
                            <div class="input-group-btn">
                                @if($provider->status == 'approved')
                                <a class="btn btn-danger btn-block shadow-box" href="{{ route('crm.provider.disapprove', $provider->id ) }}"><i class="fa fa-ban"></i></a>
                                @else
                                <a class="btn btn-success btn-block shadow-box" href="{{ route('crm.provider.approve', $provider->id ) }}"><i class="fa fa-check"></i></a>
                                @endif
                                <button type="button" 
                                    class="btn btn-block btn-black dropdown-toggle shadow-box"
                                    data-toggle="dropdown">Aktion
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('crm.provider.request', $provider->id) }}" class="btn btn-default"><i class="fa fa-search"></i> Einzelheiten</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('crm.provider.statement', $provider->id) }}" class="btn btn-default"><i class="fa fa-file"></i> Geschichte</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('crm.provider.edit', $provider->id) }}" class="btn btn-default"><i class="fa fa-pencil"></i> Profil bearbeiten</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('crm.provider.destroy', $provider->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-default look-a-like" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Löschen</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobiltelefon</th>
                        <th>Unterlagen</th>
                        <th>Online</th>
                        <th>Aktion</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
