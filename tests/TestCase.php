<?php
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Item;

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
    public function createPaginated($paginator, $transformer)
    {
        $fractal = app(League\Fractal\Manager::class);
        
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
}
