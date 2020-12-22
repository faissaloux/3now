@extends('admin.layout.base')

@section('title', 'Dispatcher ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                <i class="ti-headphone"></i>&nbsp;Dispatcher<hr>
            </h5>
            <a href="{{ route('admin.dispatch-manager.create') }}" style="margin-left: 1em;" class="btn shadow-box btn-success btn-rounded pull-right"><i class="fa fa-plus"></i> Neuen Dispatcher hinzufügen</a>
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
                    @foreach($dispatchers as $index => $dispatcher)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dispatcher->name }}</td>
                        <td>{{ $dispatcher->email }}</td>
                        <td>{{ $dispatcher->mobile }}</td>
                        <td>
                            <form action="{{ route('admin.dispatch-manager.destroy', $dispatcher->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="{{ route('admin.dispatch-manager.edit', $dispatcher->id) }}" class="btn shadow-box btn-success"><i class="fa fa-pencil"></i></a>
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