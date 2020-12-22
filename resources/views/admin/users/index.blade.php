@extends('admin.layout.base')

@section('title', 'Users ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"></h5><span class="s-icon"><i class="ti-user"></i></span>&nbsp;Benutzer info</h5>
            <hr/>
            <a href="{{ route('admin.user.create') }}" style="margin-left: 1em;" class="btn shadow-box btn-rounded btn-success pull-right"><i class="fa fa-plus"></i> Neuen Benutzer hinzufügen</a>
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Handy, Mobiltelefon</th>
                        <th>Bewertung</th>
                        <th>Brieftaschenbetrag</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->rating }}</td>
                        <td>{{ currency($user->wallet_balance) }}</td>
                        <td>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="{{ route('admin.user.request', $user->id) }}" class="btn shadow-box btn-black"><i class="fa fa-search"></i></a>
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn shadow-box btn-success"><i class="fa fa-pencil"></i></a>
                                <button class="btn shadow-box btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Handy, Mobiltelefon</th>
                        <th>Bewertung</th>
                        <th>Brieftaschenbetrag</th>
                        <th>Aktion</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection