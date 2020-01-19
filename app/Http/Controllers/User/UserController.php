<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Mail;
use App\Transformers\UserTransformer;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    public function __construct(){
        $this->middleware('client.credentials')->only(['store','resend']);
        $this->middleware('auth:api')->except(['store','resend','verify']);
        $this->middleware('transform.input'.UserTransformer::class)->only(['store,update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
        //return $usuarios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $campos     =$request->all(); //Obtiene todos los campos
        $campos['password']             = bcrypt($request->password);
        $campos['verified']             = User::USUARIO_NO_VERIFICADO;
        $campos['cerification_token']   = User::USUARIO_REGULAR;
        $campos['verification_token']   = User::generarVerificationToken();
        $campos['admin']                = User::USUARIO_REGULAR;
        $usuario    = User::create($campos);
        return  $this->showOne($usuario,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if($request->has('name')){
            $user->name=$request->name;
        }
        if($request->has('email') && $user->mail != $request->email){
            $user->verified             =User::USUARIO_NO_VERIFICADO;
            $user->verification_token   =User::generarVerificationToken();
            $user->email=$request->email;
        }
        if($request->has('password')){
            $user->password=bcrypt($request->password);
        }
        if($request->has('admin')){
           if(!$user->esVerificado()){
               return  $this->errorResponse('Unicamente los usuarios
               verificados pueden cambiar el valor',409);
           }
           $user->admin=$request->admin;
        }
        if(!$user->isDirty()){// Dirty se se realizaron cambios
            return $this->errorResponse('Se debe Espicificar una valor 
            diferente',422);
        }
        $user->save();
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }

    public function verify($token){
        $user=User::where('verification_token',$token)->firstOrFail();
        $user->verified=User::USUARIO_VERIFICADO;
        $user->save();
        return $this->showMessage('La cuenta ha sido verificada');
    }
    public function resend(User $user){
        if($user->esVerificado()){
            return $this->errorResponse('Este usuario ya se encuentra verificado.',409);
        }
        retry(5,function() use ($user){
            Mail::to($user)->send(new UserCreated($user));
        },100);
        return $this->showMessage('El correo de verificación se ha reenviado');
    }
}
