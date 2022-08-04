<p>{{ $image->name }}</p>
@if ($image->remove_time != null)
    <p>deleted at: {{ $image->remove_time }}</p>
    <form action="{{ url('image/' . $image->id . '/restore') }}" method="GET">
        @csrf
        <button type="submit">restore</button>
    </form>
@else
    @isset($image->person->username)
        person: {{ $image->person->username }}
    @endisset
    @isset($image->user->name)
        user: {{ $image->user->name }}
    @endisset
    <p>online</p>
    <p>{{ asset('storage/' . $image->path) }}</p>

    <img src="{{ asset('storage/' . $image->path . $image->name) }}" width='250' />

    <form action="/image/{{ $image->id }}/destroy">
        @csrf
        <button type="submit" value="submit">remove</button>
    </form>
    <form action="/image/{{ $image->id }}/update" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" @error('image') is-invalid @enderror>
        @error('image')
            <span style="color:red;">{{ $message }}</span>
        @enderror
        <button type="submit" value="image">update</button>
    </form>
@endif
