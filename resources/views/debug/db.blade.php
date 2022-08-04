@extends('debug.layout')
@section('c')
    @if (DB::connection()->getPdo())
        {{ __('debug.db_test_msg') }}
        {{ DB::connection()->getDatabaseName() }}
    @endif
@endsection