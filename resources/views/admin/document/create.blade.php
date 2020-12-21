@extends('admin.layout.base')

@section('title', 'Add Document ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <!-- <a href="{{ route('admin.document.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> -->

            <h5 style="margin-bottom: 2em;"><i class="ti-layout-tab"></i>&nbsp;Dokument hinzufügen</h5><hr>

            <form class="form-horizontal" action="{{route('admin.document.store')}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <div class="form-group row">
                    <label for="name" class="col-xs-12 col-form-label">Dokumentname</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Document Name">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-xs-12 col-form-label">Dokumententyp</label>
                    <div class="col-xs-10">
                        <select name="type">
                            <option value="DRIVER">Treiber</option>
                            <option value="VEHICLE">Fahrzeug</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name" class="col-xs-12 col-form-label">Dokument läuft in Tag (en) ab</label>
                    <div class="col-xs-10">
                        <select name="expire">
                            @for($i=1;$i<=30;$i++)
                            <option value="{{$i}}">{{$i}} </option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="zipcode" class="col-xs-12 col-form-label"></label>
                    <div class="col-xs-10">
                        <button type="submit" class="btn btn-primary">Dokument hinzufügen</button>
                        <a href="{{route('admin.document.index')}}" class="btn btn-default">Stornieren</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
