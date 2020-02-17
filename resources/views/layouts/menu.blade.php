<li class="{!! request()->is('category*') ? ' active' : '' !!}">
    <a href="{!! route('category.index') !!}">Categories</a>
</li>

<li class="{!! request()->is('playlist*') ? ' active' : '' !!}">
    <a href="{!! route('playlist.index') !!}">Playlists</a>
</li>

<li class="{!! request()->is('item*') ? ' active' : '' !!}">
    <a href="{!! route('item.index') !!}">Playlist Items</a>
</li>
