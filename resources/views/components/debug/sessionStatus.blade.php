{{-- use with "with" --}}
<div style="text-align: center">
    @if (session('status'))
        <p> {{ session('status') }} </p>
    @endif
    @if (session('success'))
        <p> {{ session('success') }} </p>
    @endif
    @if (session('error'))
        <p> {{ session('error') }} </p>
    @endif

    @if (session('statusInfo'))
        <p> {{ session('statusInfo') }} </p>
    @endif
    @if (session('statusSuccess'))
        <p> {{ session('statusSuccess') }} </p>
    @endif
    @if (session('statusError'))
        <p> {{ session('statusError') }} </p>
    @endif
</div>

{{-- use with "withErrors" --}}
@if ($errors->any())
    {{ $errors->first() }}
@endif
