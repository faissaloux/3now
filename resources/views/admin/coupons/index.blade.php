@extends('admin.layout.base')

@section('title', 'Promocodes ')

@section('content')
    <!-- Main content -->
    <div class="content-area py-1">
        <!-- Page header -->
        <div class="container-fluid ">
            <div class="page-header-content">
                <div class="page-title">
                    <h1>
                        <i class="icon-arrow-right6 position-left"></i>
                        <span class="text-semibold">Gutscheine</span>
                        <a href="{{ route('admin.coupons.create') }}" style='top:-15px;'
                           class="btn shadow-box btn-rounded btn-success pull-right"><b>
                        <i class="icon-plus3"></i></b>Fügen Sie einen neuen Gutschein hinzu</a>
                    </h1>
                </div>
            </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="container-fluid">
            @if ($coupons->isEmpty())
                <div class="empty_state text-center">
                    <i class="icon-bag empty_state_icon"></i>
                    <br/>
                    <br/>
                    <h6>
                    </h6>
                    <br>
                    <a href="{{ route('admin.coupons.create') }}" class="btn bg-blue heading-btn btn-xlg">
                        neuen Gutschein erstellen
                    </a>
                </div>
            @endif
            @if (!$coupons->isEmpty())
                <div class="box box-block bg-white">
                    <table class="table ">
                        <thead>
                        <tr>
                            <th><i class=" icon-circle-code"></i><b>Gutscheincode</b></th>
                            <th><i class=" icon-calendar3"></i><b>Datum erstellt</b></th>
                            <th><i class=" icon-checkmark"></i><b>Statue</b></th>
                            <th><i class=" icon-pencil4"></i><b>Bearbeiten</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->created_at->diffForHumans() }}</td>
                                <td>{{ $coupon->statue }}</td>
                                <td>
                                    <a href="{{ route('admin.coupons.edit',['id' => $coupon->id]) }}"
                                       class="btn shadow-box btn-success">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.coupons.delete',['id' => $coupon->id]) }}"
                                       class="btn shadow-box btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="pagination-wrapper">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
@endsection