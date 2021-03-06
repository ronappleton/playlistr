<div class="table-responsive">
    <table class="table" id="playlistItems-table">
        <thead>
            <tr>
              <th>Item Id</th>
              <th style="width: 8em;">Active (click)</th>
                <th>Playlist</th>
        <th>Name</th>
        <th>Url</th>
                <th style="width: 8em;">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($playlistItems as $playlistItem)
            <tr>
                <td>{{ $playlistItem->id }}</td>
                <td>
                  @activator(['active' => $playlistItem->active, 'id' => $playlistItem->id])@endactivator
                </td>
                <td>{{ $playlistItem->playlist->name }}</td>
            <td>{{ $playlistItem->name }}</td>
            <td>{{ $playlistItem->url }}</td>
                <td>
                    {!! Form::open(['route' => ['playlistItems.destroy', $playlistItem->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('playlistItems.edit', [$playlistItem->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
      <tfoot>{{ $playlistItems->links() }}</tfoot>
    </table>
</div>
@activatorScript(['url' => 'playlistItems/toggle', 'idName' => 'itemId'])
@endactivatorScript
