<?php

namespace Sikasir\Http\Controllers\Employees;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\Controller;
use Sikasir\Employees\UserRepository;
use \Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Transformer\EmployeeTransformer;
use Sikasir\User\OwnerRepository;
use Sikasir\Traits\ApiRespond;

class EmployeesController extends ApiController
{

    protected $repo;

     public function __construct(ApiRespond $respond, OwnerRepository $repo) {
         parent::__construct($respond);

         $this->repo = $repo;
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JWTAuth $auth)
    {
        $user = $auth->toUser();
        
        $owner = $user->isOwner() ? $user->userable : abort(401);
        
        $employees = $owner->employees()->paginate();
        
        return $this->response->withPaginated($employees, new EmployeeTransformer);
        
       
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
