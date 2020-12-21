@extends('admin.layout.base')

@section('title', 'Promocodes ')

@section('content')
    <style>
        .form-group {
            overflow: hidden;
            margin-bottom: 15px;
        }
    </style>
    <!-- Content area -->
    <div class="content">
        <!-- Page header -->
        <div class="page-header page-header-transparent">
            <div class="page-header-content">
                <div class="page-title">
                    <h1><span class="text-semibold">Gutschein bearbeiten</span></h1>
                </div>
            </div>
        </div>
        <!-- /page header -->
        <form action="{{ route('admin.coupons.update',['id'=> $content->id]) }}" method="post" class="form-horizontal">
            <div class="alert alert-danger empty-form" style="display: none;">empty-form-alert</div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Aktivieren Sie den Gutschein</label>
                            <div class="col-sm-9">
                                <label class="adminswitch">
                                    <input name="statue" type="checkbox" value="active"
                                           @if($content->statue == 'active')  checked @endif />
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Gutscheincode</label>
                            <div class="col-sm-9">
                                <input type="text" name="code" value="{{ $content->code }}" placeholder="Coupon code"
                                       class="form-control rf">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Art</label>
                            <div class="col-sm-9">
                                <select name="discount_type" id="input-type" class="form-control">
                                    <option value="percent" @if( $content->type == 'percent' ) selected @endif>
                                        Prozentuale Reduzierung
                                    </option>
                                    <option value="fixed" @if( $content->type == 'fixed' ) selected @endif>
                                        Fest
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Wert reduzieren</label>
                            <div class="col-sm-9">
                                <input type="text" name="discount" value="{{  $content->discount }}"
                                       placeholder="Reducing value" class="form-control rf">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Beschreibung</label>
                            <div class="col-sm-9">
                                <textarea name="description" class="form-control" id="" cols="30"
                                          rows="10">{{$content->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Anfangsdatum</label>
                            <div class="col-sm-9">
                                <div class="input-group date">
                                    <input type="date" name="valid_from" placeholder="The start date "
                                           id="input-date-start" class="form-control rf"
                                           value="{{$content->valid_from}}"/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default">
                                            <i class="icon-calendar3"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Haltbarkeitsdatum</label>
                            <div class="col-sm-9">
                                <div class="input-group date">
                                    <input type="date" name="valid_to" placeholder="Expiration date"
                                           class="form-control rf" value="{{$content->valid_to}}"/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default">
                                            <i class="icon-calendar3"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Maximale Nutzung</label>
                            <div class="col-sm-9">
                                <input type="number" name="maxUsage" placeholder="The number of times a coupon is used "
                                       class="form-control rf" value="{{$content->maxUsage}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Maximaler Rabatt</label>
                            <div class="col-sm-9">
                                <input type="number" name="maxDiscount"
                                       placeholder="The number of times a coupon is used " class="form-control rf"
                                       value="{{$content->maxDiscount}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Verwendungsart</label>
                            <div class="col-sm-9">
                                <select name="usage_type" class='form-control'>
                                    <option value="single" @if($content->usage_type == 'single') selected @endif >
                                        single
                                    </option>
                                    <option value="multiple" @if($content->usage_type == 'multiple') selected @endif>
                                        mehrere
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nutzer</label>
                            <div class="col-sm-9">
                                <select name="user" class='form-control'>
                                    @foreach($users as $user)
                                        <option value="{{ $user['id'] }}"
                                            @if($content->user == $user['id'] ) selected @endif>
                                            {{ $user['first_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-primary">Gutschein veröffentlichen
                            <i class="icon-arrow-left13 position-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </form>
    </div>
    <!-- /content area -->
@endsection