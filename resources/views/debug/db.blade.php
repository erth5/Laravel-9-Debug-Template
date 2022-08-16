@extends('debug.layout')
@section('c')
    @forelse ($connections as $connection)
        <p>{{ $connection }}</p>
    @empty
    @endforelse
    @if (DB::connection()->getPdo())
        {{ __('debug.db_test_msg') }}
        {{ DB::connection()->getDatabaseName() }}
    @endif
@endsection
