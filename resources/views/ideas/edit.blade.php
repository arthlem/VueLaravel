@extends('layouts.app', ['title' => 'Modifier '.$idea->text])

@section('content')
    <h1>Modifier une idée</h1>
    {!! Form::open(['action' => ['IdeaController@update', $idea->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('text', 'Texte de l\'idée')}}
            {{Form::text('text', $idea->text, ['class' => 'form-control', 'placeholder' => 'Texte de l\'idée'])}}
        </div>
        {{Form::hidden('_method','PUT')}}
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Modifier l'idée</button>
            <a class="btn btn-secondary" href="/projects/{{$idea->id_project}}">Annuler</a>
        </div>
    {!! Form::close() !!}
@endsection