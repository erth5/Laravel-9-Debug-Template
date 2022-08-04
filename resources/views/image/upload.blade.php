@extends('image.layout')
@section('image_views')

    <h2>Laravel 9 Image Upload</h2>

    @if ($message = Session::get('success'))
        <div>
            <button type="button">×WOBINICH</button>
            <strong style="text-align: center">{{ $message }}</strong>
        </div>
        <img src="image/{{ Session::get('image') }}">
    @endif

    <form action="{{ route('store image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="inputImage">Image:</label>
        <input type="file" name="image" id="inputImage" @error('image') is-invalid @enderror">

        @error('image')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <button type="submit">upload</button>
    </form>

    <form action="{{ route('debug image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="inputImage">Debug:</label>
        <input type="file" name="debug">
        <button type="submit">Debug</button>
    </form>

    <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>
    <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>
    <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>

    @php
    $image = session::get('image');
    @endphp
@endsection
