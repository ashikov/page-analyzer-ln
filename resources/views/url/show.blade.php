@extends('layouts.app')

@section('content')
<div class="container-lg">
    <h1 class="mt-5 mb-3">Site: {{ $url->name }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <td>{{ __('views.urls.id') }}</td>
                    <td>{{ $url->id }}</td>
                </tr>
                <tr>
                    <td>{{ __('views.urls.name') }}</td>
                    <td>{{ $url->name }}</td>
                </tr>
                <tr>
                    <td>{{ __('views.urls.created_at') }}</td>
                    <td>{{ $url->created_at }}</td>
                </tr>
        </table>
        <h2 class="mt-5 mb-3">{{ __('views.checks.title') }}</h2>
        {{ Form::open(['url' => route('urls.checks.store', $url->id), 'method' => 'POST', 'class' => 'mb-3']) }}
            {{ Form::submit('Run check', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <th>{{ __('views.checks.id') }}</th>
                        <th>{{ __('views.checks.status_code') }}</th>
                        <th>{{ __('views.checks.h1') }}</th>
                        <th>{{ __('views.checks.title') }}</th>
                        <th>{{ __('views.checks.description') }}</th>
                        <th>{{ __('views.checks.created_at') }}</th>
                    </tr>
                    @foreach ($checks as $check)
                        <tr>
                            <td>{{ $check->id }}</td>
                            <td>{{ $check->status_code }}</td>
                            <td>{{ $check->h1 }}</td>
                            <td>{{ $check->title }}</td>
                            <td>{{ $check->description }}</td>
                            <td>{{ $check->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
@endsection
