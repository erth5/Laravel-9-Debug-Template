@extends('image.layout')
@section('image_views')
    @if (isset($image))
        <form action="{{ route('image.rename', [$image]) }}" 
        method="POST" enctype='multipart/form-data'>
            @csrf
            <input type="text" name="edit" id="edit">
            <input type="submit" value="submit">
        </form>
    @else
        <p>Kein Bild vorhanden</p>
    @endif
@endsection
