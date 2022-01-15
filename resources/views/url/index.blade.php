@extends('layouts.app')

@section('content')
<div class="container-lg">
        <h1 class="mt-5 mb-3">{{ __('views.urls.title') }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                    <tr>
                        <th>{{ __('views.urls.id') }}</th>
                        <th>{{ __('views.urls.name') }}</th>
                        <th>{{ __('views.urls.last_check') }}</th>
                        <th>{{ __('views.urls.status_code') }}</th>
                    </tr>
                    @foreach ($urls as $url)
                    <tr>
                        <td>{{ $url->id }}</td>
                        <td><a href="{{ route('urls.show', $url->id) }}">{{ $url->name }}</a></td>
                        <td>{{ $lastChecks[$url->id]->created_at ?? '' }}</td>
                        <td>{{ $lastChecks[$url->id]->status_code ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
@endsection
