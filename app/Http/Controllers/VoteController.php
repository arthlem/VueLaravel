<?php

namespace App\Http\Controllers;

use App\Vote;
use App\Idea;
use Illuminate\Http\Request;
use Auth;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/projects/'.$request->id_project)->with('error', 'Vous n\'êtes pas connecté');
        }
        $idea = Idea::find($request->id_idea);
        if (auth()->user()->id == $idea->id_creator) {
            return redirect('/projects/'.$request->id_project)->with('error', 'Vous ne pouvez pas voter pour vos idées');
        }
        $vote = new Vote([
            'id_idea' => $request->id_idea,
            'id_user' => auth()->user()->id,
            'value' => $request->value,
        ]);
        $vote->save();
        return redirect('/projects/'.$request->id_project);
    }
    
}
