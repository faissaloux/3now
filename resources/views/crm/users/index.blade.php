@extends('crm.layout.base')
@section('title', 'Users ')
@section('content')
   <div class="content-area py-1">
      <div class="container-fluid">
         <div class="row row-md">
            <div class="col-lg-4 col-md-6 col-xs-12">
               <div class="box box-block bg-success mb-2">
                  <div class="t-content">
                     <h5 class="text-uppercase mb-1">Gesamtnutzer</h5>
                     <h5 class="text-uppercase mb-1">{{ $totaluser }}</h5>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
               <div class="box box-block bg-primary mb-2">
                  <div class="t-content">
                     <h5 class="text-uppercase mb-1">Gesamtfahrt</h5>
                     <h5 class="text-uppercase mb-1">{{ $totaltrip }}</h5>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
               <div class="box box-block bg-warning mb-2">
                  <div class="t-content">
                     <h5 class="text-uppercase mb-1">Abgebrochene Fahrt</h5>
                     <h5 class="text-uppercase mb-1">{{ $totalcanceltrip }}</h5>
                  </div>
               </div>
            </div>
         </div>
         <div class="box box-block bg-white">
            <h5 class="mb-1"> <i class="ti-user"></i>&nbsp;
               Users
            </h5>
            <hr>
            <a href="{{ route('crm.user.create') }}" style="margin-left: 1em;" class="btn btn-success pull-right btn-rounded shadow-box"><i class="fa fa-plus"></i> Neue hinzufügen</a>
            <table class="table table-striped table-bordered dataTable" id="table-2"style="width:100%;">
               <thead>
               <tr>
                  <th>ID</th>
                  <th>Bild</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobiltelefon</th>
                  <th>Bewertung</th>
                  <th>Fahrten</th>
                  <th>Brieftaschenbetrag</th>
                  <th>Aktion</th>
               </tr>
               </thead>
               <tbody>
               @foreach($users as $index => $user)
                  <tr>
                     <td>{{ $index + 1 }}</td>
                     <td>picture</td>
                     <td>{{ $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>+919876543210</td>
                        <td>{{ $user->mobile }}</td>
                     <td>{{ $user->rating }}</td>
                     <td>Fahrten</td>
                     <td>{{ currency().$user->wallet_balance }}</td>
                     <td>
                        <form action="{{ route('crm.user.destroy', $user->id) }}" method="POST">
                           {{ csrf_field() }}
                           <input type="hidden" name="_method" value="DELETE"/>
                           <a href="{{ route('crm.user.request', $user->id) }}" class="btn btn-black shadow-box"><i class="fa fa-search"></i> </a>
                           <a href="{{ route('crm.user.edit', $user->id) }}" class="btn btn-success shadow-box"><i class="fa fa-pencil"></i> </a>
                           <button class="btn btn-danger shadow-box" onclick="return confirm('Bist du sicher?')"><i class="fa fa-trash"></i> </button>
                        </form>
                     </td>
                  </tr>
               @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection