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
                <i class='subheader-icon fal fa-sun'></i> Установить статус
            </h1>

        </div>
        <form action="/editUserStatusInfo" method="post">
            {{csrf_field()}}
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Установка текущего статуса</h2>
                            </div>
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- status -->
                                        <div class="form-group">
                                            <label class="form-label" for="example-select">Выберите статус</label>
                                            <input type="text" name="id" placeholder="id" value="{{$user['id']}}" style="display: none">
                                            @php($statuses = [1 =>'Онлайн', 2 => 'Отошел',  3 => 'Не беспокоить'])
                                            <select name="status" class="form-control" id="example-select">
                                                @foreach($statuses as $key => $value)
                                                    @if($key == $user['status'])
                                                        <option selected value="{{$user['status']}}">{{$value}}</option>
                                                    @else
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning">Set Status</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </main>

@endsection
