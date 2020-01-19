<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;


class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identificador'     =>  (int)$user->id,
            'nombre'            =>  (string)$user->name,
            'correo'            =>  (string)$user->email,
            'esVerificado'      =>  (int)$user->verified,
            'esAdministrador'   =>  ($user->admin === 'true'),
            'fechaCracion'      =>  (string)$user->created_at,
            'fechaActualización'=>  (string)$user->update_at,
            'fechaEliminación'  =>  isset($user->deleted_at) ? (string)$user->delete_at:null,
            'links' =>  [
                [
                    'rel'   =>  'self',
                    'href'  =>  route('users.show',$user->id),
                ]
            ]
        ];
    }

    public static function originalAttribute($index){
        $attributes = [
            'identificador'     =>  'id',
            'nombre'            =>  'name',
            'correo'            =>  'email',
            'esVerificado'      =>  'verified',
            'esAdministrador'   =>  'admin',
            'fechaCracion'      =>  'created_at',
            'fechaActualización'=>  'update_at',
            'fechaEliminación'  =>  'delete_at'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    //Se transforma para los mensajes de validacion
    public static function transformedAttribute($index){

        $attributes = [
            'id'         => 'identificador',
            'name'       => 'nombre',
            'email'      => 'correo',
            'verified'   => 'esVerificado',
            'admin'      => 'esAdministrador',
            'created_at' => 'fechaCracion',
            'update_at'  => 'fechaActualización',
            'delete_at'  => 'fechaEliminación',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
