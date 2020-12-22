@extends('admin.layout.base')
@section('title', 'Crm ')
@section('content')
<div class="content-area py-1">
   <div class="container-fluid">
      <div class="box box-block bg-white">
         <h5 class="mb-1">
            <i class="ti-layout-media-right"></i>&nbsp;CRM User
         </h5>
         <hr>
         <a href="{{ route('admin.crm-manager.create') }}" style="margin-left: 1em;" class="btn shadow-box btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Neue hinzufügen</a>
         <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Vollständiger Name</th>
                  <th>Email</th>
                  <th>Handy, Mobiltelefon</th>
                  <th>Aktion</th>
               </tr>
            </thead>
            <tbody>
               @foreach($crms as $index => $crm)
               <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $crm->name }}</td>
                  <td>{{ $crm->email }}</td>
                  <td>{{ $crm->mobile }}</td>
                  <td>
                     <form action="{{ route('admin.crm-manager.destroy', $crm->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <a href="{{ route('admin.crm-manager.edit', $crm->id) }}" class="btn shadow-box btn-success"><i class="fa fa-pencil"></i></a>
                        <button class="btn btn-danger shadow-box" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                     </form>
                  </td>
               </tr>
               @endforeach
            </tbody>
            <tfoot>
               <tr>
                  <th>ID</th>
                  <th>Vollständiger Name</th>
                  <th>Email</th>
                  <th>Handy, Mobiltelefon</th>
                  <th>Aktion</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>
@endsection