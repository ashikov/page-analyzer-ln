@extends('layouts.app')

@section('content')
<div class="container-lg">
        <h1 class="mt-5 mb-3">{{ __('views.domains.title') }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                    <tr>
                        <th>{{ __('views.domains.id') }}</th>
                        <th>{{ __('views.domains.name') }}</th>
                        <th>{{ __('views.domains.last_check') }}</th>
                        <th>{{ __('views.domains.status_code') }}</th>
                    </tr>
                    @foreach ($domains as $domain)
                    <tr>
                        <td>{{ $domain->id }}</td>
                        <td><a href="{{ route('domains.show', $domain->id) }}">{{ $domain->name }}</a></td>
                        <td>{{ $lastChecks[$domain->id]->created_at ?? '' }}</td>
                        <td>{{ $lastChecks[$domain->id]->status_code ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
@endsection
