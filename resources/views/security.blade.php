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
            <i class='subheader-icon fal fa-lock'></i> Безопасность
        </h1>

    </div>
    <form action="/editUserSecurInfo" method="post">
        {{csrf_field()}}
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Обновление эл. адреса и пароля</h2>
                        </div>
                        <div class="panel-content">
                            <!-- email -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Email</label>
                                <input type="text" name="id" placeholder="id" value="{{$user['id']}}" style="display: none">
                                <input type="email" id="simpleinput" class="form-control" name="email" value="{{$user['email']}}">
                            </div>

                            <!-- password -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Пароль</label>
                                <input  type="password" id="simpleinput" class="form-control" name="oldPassword">
                            </div>

                            <!-- password confirmation-->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Подтверждение пароля</label>
                                <input type="password" id="simpleinput" class="form-control" name="newPassword">
                            </div>


                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Изменить</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</main>
@endsection
