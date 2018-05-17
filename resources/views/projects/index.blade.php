@extends('layouts.app', ['title' => 'Tous les projets', 'route' => 'projects'])

@section('content')
  <div class="row">
      @foreach($projects as $project)
        <div class="col-xs-12 col-md-4 col-lg-3 d-flex align-items-stretch">     
          <div class="card text-center">
            
              @if(substr( $project->image_link, 0, 4 ) === "http")
                <img class="card-img" src="{{ $project->image_link }}" alt="{{ $project->name}}">
              @else
                <img class="card-img" src="http://localhost:8000/storage/images/{{ $project->image_link }}" alt="{{ $project->name}}" title="{{ $project->name}}">
              @endif
              @if(Auth::check() && auth()->user()->id == $project->id_creator)
                <div class="card-img-overlay-custom">
                  <div class="d-flex justify-content-end">
                    <a href="/projects/{{$project->id}}/edit" class="btn btn-primary mr-1"><i class="fa fa-edit"></i></a>
                    {!!Form::open(['action' => ['ProjectController@destroy', $project->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                      {{Form::hidden('_method', 'DELETE')}}
                      {{Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit','class' => 'btn btn-danger'])}}
                    {!!Form::close()!!}
                  </div>
                </div>
              @endif
               
            <div class="card-body">
              <h5 class="card-title">{{ $project->name}}</h5>
              <a href="/projects/{{$project->id}}" class="btn btn-primary">Voir les idées proposées</a>
            </div>
          </div>
        </div> 
      @endforeach
  </div>
@endsection