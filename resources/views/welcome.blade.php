@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid bg-dark">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto text-white">
                    <h1 class="display-3">{{ __('views.welcome.title') }}</h1>
                    <p class="lead">{{ __('views.welcome.subtitle') }}</p>
                    {{ Form::open(['url' => route('domain.index'), 'method' => 'POST', 'class' => 'd-flex justify-content-center']) }}
                        {{ Form::text('url', 'https://www.example.com', ['class' => 'form-control form-control-lg']) }}
                        {{ Form::submit('Check', ['class' => 'btn btn-lg btn-primary ml-3 px-5 text-uppercase']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
