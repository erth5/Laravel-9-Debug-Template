@extends('image.layout')
@section('image_views')
    @isset($images)
        <form action="/images/clear">
            <button>clear</button>
        </form>
        @forelse ($images as $image)
            <div style="display: inline-block">
                <x-image.show :image=$image />
            </div>
        @empty
            <p>No Images Saved</p>
        @endforelse
    @else
        <p>No Images object Saved</p>
    @endisset
@endsection
