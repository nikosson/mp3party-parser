@extends('layout.app')

@section('title')
    {{ $artist->name }}
@endsection

@section('content')
    <div class="col-6 artist">

        <div class="jumbotron">
            <h1 class="display-4">{{ $artist->name }}</h1>

            <ul class="list-group">
                @if(count($tracks))
                    @foreach($tracks as $track)
                        <li class="list-group-item">
                            <p class="text-left">{{ $track->name }}</p>
                            <audio controls controlsList="nodownload" preload='none'>
                                <source src="{{  $track->storage_path }}" type="audio/mpeg">
                            </audio>
                        </li>
                    @endforeach
                @else
                    <div class="alert alert-primary" role="alert">
                        Похоже, что у этого артиста нету загруженых треков :(
                    </div>
                @endif
            </ul>
        </div>

    </div>
@endsection
