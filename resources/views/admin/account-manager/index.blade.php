@extends('admin.layout.base')

@section('title', 'Account Manager ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                <i class="ti-layout-grid2-thumb"></i>&nbsp;Buchhalter
            </h5><hr>
            <a href="{{ route('admin.account-manager.create') }}" style="margin-left: 1em;" class="btn shadow-box btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Neuen Account Manager hinzufügen</a>
            <table class="table table-striped table-bordered dataTable" id="table-2" width="100%">
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
                    @foreach($accounts as $index => $account)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->email }}</td>
                        <td>{{ $account->mobile }}</td>
                        <td>
                            <form action="{{ route('admin.account-manager.destroy', $account->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="{{ route('admin.account-manager.edit', $account->id) }}" class="btn btn-success shadow-box"><i class="fa fa-pencil"></i></a>
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