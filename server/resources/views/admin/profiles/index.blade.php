@extends('admin.layouts.master')
@section('title', 'Profiles')
@section('content')
    <div class="container bootstrap snippet">
        <div class="row">
            <div class="col-sm-10"><h1>AAAA</h1></div>
            <div class="col-sm-2"><a href="{{route('admin.menu')}}" class="pull-right"><img title="profile image"
                                                                                            class="img-circle img-responsive"
                                                                                            src="http://www.gravatar.com/avatar/28fd20ccec6865e2d5f0e1f4446eb7bf?s=100"></a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3"><!--left col-->
                <div class="text-center p-avatarup__item">
                    <div class="img_preview">
                        @if (old('avatar_tmp') && file_exists(\App\Enums\Property\Upload::TmpPath.old('avatar_tmp')))
                            <img src="/tmp/{{ old('avatar_tmp') }}"/>
                        @elseif(!empty($shop->avatar) && file_exists(\App\Enums\Property\Upload::UploadPath.$shop->avatar))
                            <img src="/upload/{{ $shop->avatar }}"/>
                        @endif
                    </div>
                    <h6>Upload a different photo...</h6>
                    <input type="file" class="avatar_select" name="avatar" class="text-center center-block file-upload">
                    <input class="avt_tmp" type="hidden" name="avatar_tmp" value="{{ old('avatar_tmp') }}">
                </div>
                </hr><br>
            </div><!--/col-3-->
            <div class="col-sm-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="home">
                        <hr>
                        <form class="form" action="{{route('admin.update_profiles')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @if(count($profiles) > 0)
                                @foreach($profiles as $key => $val)
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="full_name"><h4>Full name</h4></label>
                                            <input type="text" class="form-control" name="full_name"
                                                   placeholder="Full name"
                                                   value="{{ old('full_name', $val->full_name) }}">
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="full_name"><h4>Full name</h4></label>
                                        <input type="text" class="form-control" name="full_name"
                                               placeholder="Full name"
                                               value="">
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-lg btn-success" type="submit"><i
                                            class="glyphicon glyphicon-ok-sign"></i>Update
                                    </button>
                                    <button class="btn btn-lg btn-warning" type="reset"><i
                                            class="glyphicon glyphicon-repeat"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
