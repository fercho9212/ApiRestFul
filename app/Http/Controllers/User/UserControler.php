<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        return response()->json(['data'=>$usuarios],200);
        //return $usuarios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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
        $usuario    = User::create($campos);
        return response()->json(['data'=>$usuario],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario=User::findOrFail($id);
        return response()->json(['data'=>$usuario],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user=User::findOrFail($id);
        if($request->has('name')){
            $user->name=$request->name;
        }
        if($request->has('email') && $user->mail != $request->email){
            $user->verified             =User::USUARIO_NO_VERIFICADO;
            $user->verification_token   =User::generarVerificacionToken();
            $user->email=$request->email;
        }
        if($request->has('password')){
            $user->password=bcrypt($request->password);
        }
        if($request->has('admin')){
           if(!$user->esVerificado()){
               return response()->json(['error'=>'Unicamente los usuarios
                                                 verificados pueden cambiar el valor',
                                                  'code'=>409],409);
           }
           $user->admin=$request->admin;
        }
        if(!$user->isDirty()){// Dirty se se realizaron cambios
            return response()->json(['error'=>'Se debe Espicificar una valor 
                                                diferente','code'=>422],422);

        }
        $user->save();
        return response()->json(['data'=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();
        return response()->json(['data'=>$user],200);
    }
}
