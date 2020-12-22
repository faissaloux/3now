@extends('admin.layout.base')
@section('title', 'Support ')
@section('content')
<div class="content-area py-1">
   <div class="container-fluid">
      <div class="box box-block bg-white">
         <h5 class="mb-1">
            Support User
         </h5>
         <a href="{{ route('admin.support-manager.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New</a>
         <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach($supports as $index => $support)
               <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $support->name }}</td>
                  <td>{{ $support->email }}</td>
                  <td>+919876543210</td>
                  <td>{{ $support->mobile }}</td>
                  <td>
                     <form action="{{ route('admin.support-manager.destroy', $support->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <a href="{{ route('admin.support-manager.edit', $support->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</button>
                     </form>
                  </td>
               </tr>
               @endforeach
            </tbody>
            <tfoot>
               <tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Action</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>
@endsection