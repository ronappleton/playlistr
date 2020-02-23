<li class="{{ Request::is('playlists*') ? 'active' : '' }}">
    <a href="{{ route('playlists.index') }}"><i class="fa fa-edit"></i><span>Playlists</span></a>
</li>

<li class="{{ Request::is('playlistItems*') ? 'active' : '' }}">
    <a href="{{ route('playlistItems.index') }}"><i class="fa fa-edit"></i><span>Playlist Items</span></a>
</li>

<li class="{{ Request::is('apiRoutes*') ? 'active' : '' }}">
    <a href="{{ route('apiRoutes.index') }}"><i class="fa fa-edit"></i><span>Api Routes</span></a>
</li>

