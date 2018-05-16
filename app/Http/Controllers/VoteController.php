<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;

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

        $vote = new Vote([
            'id_idea' => $request->id_idea,
            'id_user' => auth()->user()->id,
            'value' => $request->value,
        ]);
        $vote->save();
        return redirect('/projects/'.$request->id_project);
    }
    
}
