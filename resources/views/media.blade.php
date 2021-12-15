@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if($errors->all())
    @foreach($errors->all() as $error)
        <div class="alert alert-success">
            <li>{{$error}}</li>
        </div>
    @endforeach
@endif

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-image'></i> Загрузить аватар
        </h1>

    </div>
    <form action="/editUserMediaInfo" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Текущий аватар</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <input type="text" name="id" value="{{$user['id']}}" style="display: none">
                                <input type="text" name="email" value="{{$user['email']}}" style="display: none">
                                <img src="{{'/uploads/'.''.$user['photo']}}" alt="" class="img-responsive" width="200">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                <input type="file" name="photo" id="example-fileinput" class="form-control-file">
                            </div>
                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Загрузить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>
@endsection
