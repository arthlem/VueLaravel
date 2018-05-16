@extends('layouts.app', ['title' => $project->name, 'route' => 'projects_details', 'project_id' => $project->id])

@section('content')
    <table class="table text-center">
        @foreach($ideas as $idea)
            <tr class="border_bottom">
                <td class="noborder align-middle text-center pull-left">
                    {!! Form::open(['action' => 'VoteController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        
                        {{ Form::hidden('id_idea', $idea->id) }}
                        {{ Form::hidden('id_project', $project->id) }}
                        {{ Form::hidden('value', 1) }}
                            
                        <button type="submit" class="btn btn-default"><i class="fa fa-chevron-up"></i></button>
                        
                    {!! Form::close() !!}
                        
                    <span class="text-center">{{ $idea->votes()->sum('value')}}</span>

                    {!! Form::open(['action' => 'VoteController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        
                        {{ Form::hidden('id_idea', $idea->id) }}
                        {{ Form::hidden('id_project', $project->id) }}
                        {{ Form::hidden('value', -1) }}
                        <button type="submit" class="btn btn-default"><i class="fa fa-chevron-down"></i></button>
                        
                    {!! Form::close() !!}
                </td>
                <td class="noborder align-middle">
                    <a class="ml-3 mr-3">{{ $idea->text }}</a>
                </td>
                @if(auth()->user()->id == $idea->id_creator)
                    <td class="noborder align-middle">
                        {!!Form::open(['action' => ['IdeaController@destroy', $idea->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit','class' => 'btn btn-danger'])}}
                        {!!Form::close()!!}
                        <a class="btn btn-primary pull-right mr-1" href="/ideas/{{$idea->id}}/edit"><i class="fa fa-edit"></i></a>
                    </td>
                @endif
            </tr>
        @endforeach
    </table>
@endsection