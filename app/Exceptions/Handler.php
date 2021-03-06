<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Asm89\Stack\CorsService;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */

    public function render($request, Exception $exception)
    {
        $response = $this->handleException($request,$exception);
        app(CorsService::class)->addActualRequestHeaders($response,$request);
        return $response;
    }

    public function handleException($request,Exception $exception){
        if ($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }

        if ($exception instanceof ModelNotFoundException){
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id expecificado",404);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse('No posee permisos para ejecutar esta accion',403);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('No se encontro la URL especificada',404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('El método especificado en la petición no es valido',405);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        }

        if ($exception instanceof QueryException) {
            $codigo=$exception->errorInfo[1];
            if($codigo == 1451){
               return $this->errorResponse('No se puede eliminar porque se encuentra relacionado');
            }
            if($codigo == 547){
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso 
                       porque está relacionado con algún otro',409);
            }
        }

/*        if(config('app.debug')){
            return $this->errorResponse('Falla Inesperada. Intente más adelante',500);
        } */

        if($exception instanceof TokenMismatchException){
            return redirect()->back()->withInput($request->input());
        }
        return parent::render($request, $exception);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        if($this->isFronted($request)){
            return $request->ajax() ? response()->json($errors,422) : redirect()
                                                                    ->back()
                                                                    ->withInput($request->input())
                                                                    ->withErrors($errors);
        }
        return $this->errorResponse($errors,422);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($this->isFronted($request)){
            return redirect()->guest('login');
        }
        return $this->errorResponse('No autenticado.',401);
    }
    //Funcion que permite saber si la peticion es realizada desde el modo fronted
    private function isFronted($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }

}
