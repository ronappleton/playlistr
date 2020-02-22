@extends('layouts.app')

@section('content')

  <section class="content-header">
    @include('flash::message')
    <h1 class="pull-left">Playlist Items</h1>
    @if(!empty($playlistId))
    <h1 class="pull-right">
      <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Add Items</a>
    </h1>
    @endif
    <hr>
    @if(!empty($playlistId))
    <div class="collapse" id="collapseExample">
      <div class="box">
        <div class="box-body">
          <div class="row">
            {!! Form::open(['route' => 'playlist.items.store.bulk.url', 'method' => 'post', 'files' => true]) !!}
            {!! Form::hidden('playlist_id', $playlistId) !!}
            <div class="form-group col-sm-8">
              {!! Form::text('m3uUrl', null, ['class' => 'form-control', 'placeholder' => 'Url of m3u file']) !!}
            </div>
            <div class="form-group col-sm-2">
              {!! Form::submit('Upload', ['class' => 'form-control']) !!}
            </div>
            {!! Form::close() !!}
            {!! Form::open(['route' => 'playlist.items.store.bulk.file', 'method' => 'post', 'files' => true]) !!}
            {!! Form::hidden('playlist_id', $playlistId) !!}
            <div class="form-group col-sm-8">
              {!! Form::file('m3uFile', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-sm-2">
              {!! Form::submit('Upload', ['class' => 'form-control']) !!}
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    @endif
  </section>
  <div class="content">
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="box box-primary">
      <div class="box-body">
        @include('playlist_items.table')
      </div>
    </div>
    <div class="text-center">

    </div>
  </div>
@endsection

