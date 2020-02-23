<div class="table-responsive">
    <table class="table" id="playlists-table">
        <thead>
            <tr>
                <th style="width: 8em;">Active (click)</th>
                <th>Name</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($playlists as $playlist)
            <tr>
              <td>
                @activator(['active' => $playlist->active, 'id' => $playlist->id])@endactivator
              </td>
                <td>{{ $playlist->name }}</td>
            <td>{{ $playlist->description }}</td>
                <td>
                    {!! Form::open(['route' => ['playlists.destroy', $playlist->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('playlist.items', [$playlist->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-film"></i></a>
                        <a href="{{ route('playlists.edit', [$playlist->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
      <tfoot>{{ $playlists->links() }}</tfoot>
    </table>
</div>
@activatorScript(['url' => 'playlists/toggle', 'idName' => 'playlistId'])
@endactivatorScript
