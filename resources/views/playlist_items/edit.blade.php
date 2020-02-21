@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Playlist Item
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($playlistItem, ['route' => ['playlistItems.update', $playlistItem->id], 'method' => 'patch']) !!}

                        @include('playlist_items.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection