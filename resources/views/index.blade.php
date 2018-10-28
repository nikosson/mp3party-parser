@extends('layout.app')

@section('title')
    Artists
@endsection

@section('content')
    <div class="col-6 artist">

        <div class="jumbotron">
            <h1 class="display-4">Артисты</h1>
            <p class="lead">Hа этой странице вы можете увидеть всех доступных артистов. Нажмите на ссылку чтобы увидеть их треки</p>

            <ul class="list-group">
                @foreach ($artists as $key => $artist)
                    <li class="list-group-item artist-item">
                        <a href="{{ route('artist', ['artist' => $artist->id]) }}">
                            {{ $key + 1}} {{ $artist->name }}
                        </a>
                        @if (!$artist->downloadedTracks->count())
                            <span class="badge badge-warning">У этого артиста нету загруженых треков</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
@endsection
