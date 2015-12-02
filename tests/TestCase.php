<?php
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Item;
use Tymon\JWTAuth\JWTAuth;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
    
    /**
     * 
     * 
     */
    public function fake()
    {
        return Faker\Factory::create();
    }
    
    /**
     * create fractal's collection
     * 
     * @param Collection $collection
     * @param TransformerAbstract $transformer
     */
    public function createPaginated($paginator, $transformer, $include = [])
    {
        $fractal = app(League\Fractal\Manager::class);
        
        $fractal->parseIncludes($include);
        
        $collection = $paginator->getCollection();
        
        $resource = new Collection($collection, $transformer);
        
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        
        return $fractal->createData($resource);
        
    }
    
     /**
     * create fractal's item
     * 
     * @param Collection $collection
     * @param TransformerAbstract $transformer
     */
    public function createItem($item, $transformer)
    {
        $fractal = app(League\Fractal\Manager::class);
        
        $resource = new Item($item, $transformer);
        
        return $fractal->createData($resource);
        
    }
    
    /**
     * login and return token jwt
     * 
     * @return string
     */
    public function login()
    {
        $credentials = ['email' => 'owner@sikasir.com', 'password' => 'owner'];
        
        $auth = app(JWTAuth::class);
        
        return $auth->attempt($credentials);        
    }
    
    public function getOwner()
    {
        return Sikasir\V1\User\User::whereEmail('owner@sikasir.com')->firstOrFail()->userable;
    }
}
