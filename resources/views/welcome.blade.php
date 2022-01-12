@extends('layouts.app')

@section('content')
    <div class="container-lg mt-5">
        <div class="row">
            <div class="col-12 col-md-10 col-lg-8 mx-auto">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <h1>{{ __('views.welcome.title') }}</h1>
                    <p>{{ __('views.welcome.subtitle') }}</p>
                    {{ Form::open(['url' => route('domains.index'), 'method' => 'POST', 'class' => 'd-flex justify-content-center']) }}
                        {{ Form::text('domain[name]', null, ['class' => 'form-control form-control-lg', 'placeholder' => 'https://www.example.com']) }}
                        {{ Form::submit('Check', ['class' => 'btn btn-lg btn-outline-secondary mx-3 px-5 text-uppercase']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
