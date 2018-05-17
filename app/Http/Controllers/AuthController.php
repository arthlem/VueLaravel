<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterFormRequest;
use App\User;
use Auth;
use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends Controller
{
    /**
     * @SWG\Post(
     *   path="/auth/register",
     *   tags={"auth"},
     *   summary="Inscription",
     *   @SWG\Parameter(name="name",required=true,in="body",description="Le nom de l'utilisateur",type="string",@SWG\Schema(@SWG\Property(property="name",type="string",default="Test"))),
     *   @SWG\Parameter(name="email",required=true,in="body",description="L'email de l'utilisateur",type="string",@SWG\Schema(@SWG\Property(property="email",type="string",default="Test"))),
     *   @SWG\Parameter(name="password",required=true,in="body",description="Le mot de passe de l'utilisateur",type="string",@SWG\Schema(@SWG\Property(property="password",type="string",default="Test"))),
     *   @SWG\Response(response=200, description="Retourne les données de l'utilisateur",@SWG\Schema (
     *                  @SWG\Property(
     *                      property="status",
     *                      type="string",
     *                      default="success"
     *                  ),
     *                  @SWG\Property(
     *                      property="data",
     *                      ref="#/definitions/User"
     *                  ),
     *              ))
     * )
     *
     * Inscription
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterFormRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return response([
            'status' => 'success',
            'data' => $user,
        ], 200);
    }

    /**
     * @SWG\Post(
     *   path="/auth/login",
     *   tags={"auth"},
     *   summary="Connexion",
     *   @SWG\Parameter(name="email",required=true,in="body",description="L'email de l'utilisateur",type="string",@SWG\Schema(@SWG\Property(property="email",type="string",default="Test"))),
     *   @SWG\Parameter(name="password",required=true,in="body",description="Le mot de passe de l'utilisateur",type="string",@SWG\Schema(@SWG\Property(property="password",type="string",default="Test"))),
     *   @SWG\Response(response=200, description="Success",@SWG\Schema (
     *                  @SWG\Property(
     *                      property="status",
     *                      type="string",
     *                      default="success"
     *                  )
     *              ))
     * ),
     *   @SWG\Response(response=400, description="En cas d'erreur",@SWG\Schema (
     *                  @SWG\Property(
     *                      property="status",
     *                      type="string",
     *                      default="success"
     *                  ),
     *                  @SWG\Property(
     *                      property="error",
     *                      type="string",
     *                      default="invalid.credential"
     *                  ),
     *                  @SWG\Property(
     *                      property="msg",
     *                      type="string",
     *                      default="Invalid Credentials."
     *                  )
     *              ))
     * )
     *
     * Inscription
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.',
            ], 400);
        }
        return response([
            'status' => 'success',
        ])
            ->header('Authorization', $token);
    }

    /**
     * @SWG\Get(
     *   path="/auth/user",
     *   tags={"auth"},
     *   summary="Récupérer les données de l'utilisateur",
     *   @SWG\Parameter(name="Authorization",required=true,in="header",description="JWT token",type="string",@SWG\Schema(@SWG\Property(property="bearer",type="string",default="Test"))),
     *   @SWG\Response(response=200, description="Retourne les données de l'utilisateur",@SWG\Schema (
     *                  @SWG\Property(
     *                      property="status",
     *                      type="string",
     *                      default="success"
     *                  ),
     *                  @SWG\Property(
     *                      property="data",
     *                      ref="#/definitions/User"
     *                  ),
     *              ))
     * )
     *
     * Inscription
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user,
        ]);
    }
    public function refresh()
    {
        return response([
            'status' => 'success',
        ]);
    }

    /**
     * @SWG\Post(
     *   path="/auth/logout",
     *   tags={"auth"},
     *   summary="Logout",
     *   @SWG\Response(response=200, description="Retourne les données de l'utilisateur",@SWG\Schema (
     *                  @SWG\Property(
     *                      property="status",
     *                      type="string",
     *                      default="success"
     *                  ),
     *                  @SWG\Property(
     *                      property="msg",
     *                      type="string",
     *                      default="Logged out successfully"
     *                  ),
     *              ))
     * )
     *
     * Logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.',
        ], 200);
    }
}
