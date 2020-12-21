@extends('support.layout.base')
@section('title', 'Open Ticket')
@section('content')
<div class="content-area py-1">
   <div class="container-fluid">
      <div class="box box-block bg-white">
      	<h5 class="mb-1">
            Open Tickets Data
         </h5>
         <table class="table table-striped table-bordered dataTable" id="table-2"style="width:100%;">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach($data as $index => $user)
               <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->subject }}</td>
                  <td>{{ $user->message }}</td>
                  <td>
                  <a href="{{ route('support.openTicketDetails', $user->id) }}" class="btn btn-success shadow-box"><i class="fa fa-eye"></i></a>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection