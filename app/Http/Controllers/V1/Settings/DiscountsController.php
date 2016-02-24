<?php

namespace Sikasir\Http\Controllers\V1\Settings;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\Http\Requests\TaxDiscountRequest;
use Sikasir\V1\Repositories\Settings\DiscountRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\TaxTransformer;

class DiscountsController extends ApiController
{
    
    public function __construct(ApiRespond $respond, DiscountRepository $repo, JWTAuth $auth) 
    {
        parent::__construct($respond, $auth, $repo);
    }
    
    public function show($id)
    {
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $decodedId = $this->decode($id);
        
        $discount = $this->repo()->findForOwner($decodedId, $companyId, $with);

        return $this->response()
                ->resource()
                ->including($include)
                ->withItem($discount, new TaxTransformer);
    }
    
   public function store(TaxDiscountRequest $request)
   {
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $this->repo()->saveForOwner($request->all(), $companyId);
       
       return $this->response()->created();
   }
   
   public function update($id, TaxDiscountRequest $request)
   {
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $this->repo()->updateForOwner($this->decode($id), $request->all(), $companyId);
       
       return $this->response()->updated();
   }
   
    public function destroy($id)
    {
        
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $this->repo()->destroyForOwner($this->decode($id), $companyId);
                
        return $this->response()->deleted();
    }
   
}
