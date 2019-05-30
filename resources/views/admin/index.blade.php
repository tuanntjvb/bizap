@extends('layouts.admin.master')
{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render($resourceRoutesAlias) !!}
@endsection
@section('content')
    <h2>Welcome!</h2>
@endsection
