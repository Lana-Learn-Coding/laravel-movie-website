@extends('layouts.movie')

@section('content.movie')
    <div class="card d-none d-xl-flex">
        <div class="row no-gutters">
            <div class="col-2">
                <div class="shadow-sm">
                    @include('components.movie.movie-card', ['movie' => $movie])
                </div>
            </div>
            <div class="col-10">
                <div class="card-body justify-content-between py-3">
                    <div>{{ $movie->description }}</div>
                    <button class="btn btn-info btn-sm mt-3">Add to favorite</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body card-font-size-lg">
            <div id="player">
                <video src=""></video>
            </div>
            <div class="mt-5">
                <h6 class="card-title font-weight-bold">Episode</h6>
                <div>
                    @foreach($movie->episode_list as $ep)
                        @if($ep === request()->ep)
                            <a class="btn shadow-sm btn-sm mr-1 btn-info" href="#player">{{ $ep->number }}</a>
                        @else
                            <a class="btn shadow-sm btn-sm mr-1 btn-primary"
                               href="{{ route('movie.watch.ep', ['id' => $movie->id, 'ep' => $ep->number]) }}">{{ $ep->number }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
