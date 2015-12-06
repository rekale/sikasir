<?php

namespace Sikasir\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Sikasir\V1\Traits\ApiRespond;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        
        $response = app(ApiRespond::class);
        
        if ($this->isHttpException($e))
        {
            if ($e->getStatusCode() === 403) {
                return $response->notAuthorized();
            }
        }
        
        if (config('app.debug'))
        {
            return $this->renderExceptionWithWhoops($e, $request);
        }
        
        return parent::render($request, $e);
    }
    
     /**
     * Render an exception using Whoops.
     * 
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    protected function renderExceptionWithWhoops(Exception $e, $request)
    {
        $whoops = new \Whoops\Run;
        
        $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
        
        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }
}
