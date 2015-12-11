<?php

namespace Sikasir\V1\Http\Controllers\Products;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;


class ProductsController extends ApiController
{
   public function __construct(ApiRespond $respond, JWTAuth $auth,  $repo) {
       parent::__construct($respond, $auth, $repo);
   }
}
