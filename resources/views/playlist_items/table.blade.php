<div class="table-responsive">
    <table class="table" id="playlistItems-table">
        <thead>
            <tr>
                <th>Playlist Id</th>
        <th>Name</th>
        <th>Url</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($playlistItems as $playlistItem)
            <tr>
                <td>{{ $playlistItem->playlist_id }}</td>
            <td>{{ $playlistItem->name }}</td>
            <td>{{ $playlistItem->url }}</td>
                <td>
                    {!! Form::open(['route' => ['playlistItems.destroy', $playlistItem->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('playlistItems.show', [$playlistItem->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('playlistItems.edit', [$playlistItem->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
