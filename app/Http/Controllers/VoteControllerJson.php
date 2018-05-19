<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteControllerJson extends Controller
{
    /**
     * @SWG\Post(
     *   path="/votes",
     *   tags={"votes"},
     *   summary="Voter",
     *   @SWG\Parameter(name="value",required=true,in="body",description="valeur positive ou valeur négative",type="integer",@SWG\Schema(@SWG\Property(property="value",type="integer",default="Test"))),
     *   @SWG\Parameter(name="id_idea",required=true,in="body",description="L'id de l'idée",type="integer",@SWG\Schema(@SWG\Property(property="id_idea",type="integer",default="Test"))),
     *   @SWG\Parameter(name="id_user",required=true,in="body",description="L'id de l'utilisateur qui vote",type="integer",@SWG\Schema(@SWG\Property(property="id_user",type="integer",default="Test"))),
     *   @SWG\Response(response=200, description="Sucess")
     * )
     *
     * Créer un projet
     *
     * @param  \Illuminate\Http\Request requête contenant toutes les informations pour créer un projet
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $validatedData = $request->validate([
                'value' => 'required',
                'id_user' => 'required',
                'id_idea' => 'required',
            ]);

            if ($validatedData->errors()) {
                return $validatedData->errors()->toJson();
            }

            Vote::create($request->all());
            return response()->json('Successfully added', 200);
        } else {
            return response()->json('Vous n\'êtes pas authorisé à faire ça', 403);
        }

    }

}
