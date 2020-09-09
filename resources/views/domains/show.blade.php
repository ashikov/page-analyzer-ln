@extends('layouts.app')

@section('content')
<div class="container-lg">
    <h1 class="mt-5 mb-3">Site: {{ $domain->name }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <td>{{ __('views.domains.id') }}</td>
                    <td>{{ $domain->id }}</td>
                </tr>
                <tr>
                    <td>{{ __('views.domains.name') }}</td>
                    <td>{{ $domain->name }}</td>
                </tr>
                <tr>
                    <td>{{ __('views.domains.created_at') }}</td>
                    <td>{{ $domain->created_at }}</td>
                </tr>
                <tr>
                    <td>{{ __('views.domains.updated_at') }}</td>
                    <td>{{ $domain->updated_at }}</td>
                </tr>
        </table>
    </div>
</div>
@endsection
