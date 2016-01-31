<?php
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Item;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\User\Company;
use Sikasir\V1\User\User;
use Sikasir\V1\User\Employee;
use Sikasir\V1\User\Cashier;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Outlets\Outlet;

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
     * login as owner and return token jwt
     * 
     * @return string
     */
    public function getTokenAsOwner()
    {
        
        $credentials = ['email' => 'owner@sikasir.com', 'password' => 'owner'];
        
        $auth = app(JWTAuth::class);
        
        $token  = $auth->attempt($credentials);
        
        return ['HTTP_Authorization' => 'Bearer' . $token];
    }
    
    /**
     * login as admin and return token jwt
     * 
     * @return string
     */
    public function loginAsAdmin()
    {
        
        $credentials = ['email' => 'admin@sikasir.com', 'password' => 'admin'];
        
        $auth = app(JWTAuth::class);
        
        $token  = $auth->attempt($credentials);
        
        return ['HTTP_Authorization' => 'Bearer' . $token];
    }
    
    public function owner()
    {
        return Company::findOrFail(1);
    }
    
    public function createOwner()
    {
        $owner = factory(Company::class)->create();
        
        $user = factory(User::class)->make([
            'name' => $owner->name,
        ]);
        
        $owner->user()->save($user);
        
        return $owner;
    }
    
    public function createEmployee($ownerId)
    {
        $employee = factory(Employee::class)->create([
            'owner_id' => $ownerId,
        ]);
        
        $user = factory(User::class)->make([
            'name' => $employee->name,
        ]);
        
        $employee->user()->save($user);
        
        return $employee;
    }
    
    public function createCashier()
    {
        $outlet = factory(Outlet::class)->create([
            'owner_id' => $this->owner()->id,
            'business_field_id' => factory(BusinessField::class)->create()->id,
        ]);
        
        $cashier = factory(Cashier::class)->create([
            'owner_id' => $this->owner()->id,
            'outlet_id' => $outlet->id,
        ]);
        
        $user = factory(User::class)->make([
            'name' => $cashier->name,
        ]);
        
        $cashier->user()->save($user);
        
        return $cashier;
    }
    
    public function admin()
    {
        $admin = User::whereName('admin')->get();
        
        return $admin[0];
    }
    
    
    public function getOwner()
    {
        return Sikasir\V1\User\User::whereEmail('owner@sikasir.com')->firstOrFail()->userable;
    }
}
