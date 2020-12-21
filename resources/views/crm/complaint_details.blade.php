@extends('crm.layout.base')

@section('title', 'Complaint Details')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
    	    <a href="{{ route('crm.complaint') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Zurück</a>

			<h5 style="margin-bottom: 2em;"><i class="ti-receipt"></i>&nbsp;Details zur Beschwerde</h5><hr>

            <form class="form-horizontal" action="{{route('crm.transfer', $data->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				
				<div class="form-group row">
					<label for="name" class="col-xs-3 col-form-label">Name</label>
					<div class="col-xs-8">
						<span>{{ $data->name }}</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="email" class="col-xs-3 col-form-label">Email</label>
					<div class="col-xs-8">
						<span>{{ $data->email }}</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="mobile" class="col-xs-3 col-form-label">Gegenstand</label>
					<div class="col-xs-8">
						<span>{{ $data->subject }}</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="mobile" class="col-xs-3 col-form-label">Botschaft</label>
					<div class="col-xs-8">
                     <span>{{ $data->message }}</span>
					</div>
				</div>

                <div class="form-group row">
					<label for="mobile" class="col-xs-3 col-form-label">Übergabe an eine andere Abteilung</label>
					<div class="col-xs-8">
						<select class="form-control" name="transfer" id="transfer" required>
							<option value=""> Bitte auswählen  </option>
							<option value="1" {{($data->transfer == 1)?'selected':''}}>Kundenbeziehung</option>
							<option value="2" {{($data->transfer == 2)?'selected':''}}>Dispatcher-Abteilung</option>
							<option value="3" {{($data->transfer == 3)?'selected':''}}>Buchhaltung</option>
						</select>
					</div>
				</div>

                <div class="form-group row">
					<label for="mobile" class="col-xs-3 col-form-label">Status</label>
					<div class="col-xs-8">
					<select class="form-control" name="status" required id="status">
						<option value=""> Please Select </option>
						<option value="1" {{($data->status == 1)?'selected':''}}>Aktiv</option>
                        <option value="0" {{($data->status == 0)?'selected':''}}>Schließen</option>
                    </select>
					</div>
				</div>
				<div class="form-group row">
					<label for="mobile" class="col-xs-3 col-form-label">Antworten</label>
					<div class="col-xs-8">
						<input class="form-control" type="text" value="{{$data->reply}}" name="reply" required id="reply" placeholder="Antworten">
					</div>
				</div> 
				<div class="form-group row">
					<label for="zipcode" class="col-xs-3 col-form-label"></label>
					<div class="col-xs-8">
						<button type="submit" class="btn btn-success btn-rounded shadow-box">Antworten</button>
						<a href="{{route('crm.complaint')}}" class="btn btn-default">stornieren</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
