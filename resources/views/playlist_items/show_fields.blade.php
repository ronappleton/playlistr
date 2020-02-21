<!-- Playlist Id Field -->
<div class="form-group">
    {!! Form::label('playlist_id', 'Playlist Id:') !!}
    <p>{{ $playlistItem->playlist_id }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $playlistItem->name }}</p>
</div>

<!-- Url Field -->
<div class="form-group">
    {!! Form::label('url', 'Url:') !!}
    <p>{{ $playlistItem->url }}</p>
</div>

