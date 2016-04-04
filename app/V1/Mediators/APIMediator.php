<?php

namespace Sikasir\V1\Mediators;

use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Repositories\Interfaces\RepositoryInterface;
use Sikasir\V1\User\Authorizer;
use Illuminate\Http\Request;
use Sikasir\V1\Util\Obfuscater;
use League\Fractal\TransformerAbstract;
use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Commands\UpdateCommand;
use Illuminate\Http\JsonResponse;
use Sikasir\V1\Reports\Report;

class APIMediator 
{
	private $response;
	private $authorizer;
	private $permission;
	private $request;
	private $with;
	private $perPage;
	private $orderBy;
	
	public function __construct(Authorizer $authorizer, ApiRespond $response)
	{
		$this->authorizer = $authorizer;
		$this->response = $response;
	}
	
	/**
	 * check permission
	 * 
	 * @param string $permission
	 * @return $this
	 */
	public function checkPermission($permission)
	{
		$this->authorizer->checkAccess($permission);
		
		return $this;
	}
	
	/**
	 * 
	 * @param Request $request
	 */
	public function setRequest(Request $request)
	{
		$this->request = $request;
		
		return $this;
	}
	
	/**
	 * 
	 * return $this
	 */
	public function setWith()
	{
		$include = $this->request->input('include');
		
		$this->with = $this->filterIncludeParams($include);
		
		return $this;
		
	}
	
	/**
	 * 
	 * return $this
	 */
	public function setPerPage()
	{
		$this->perPage = $this->request->input('per_page') % 101;
		
		return $this;
	}
	
	public function orderBy()
	{
		$this->orderBy = $this->request->input('order_by');
		
		return $this;
	}
	
	/**
	 * 
	 * @param integer $id
	 * @param RepositoryInterface $repo
	 * @param Request $request
	 * @param TransformerAbstract $transformer
	 * 
	 * @return JsonResponse
	 */
	public function show($id, RepositoryInterface $repo, TransformerAbstract $transformer)
	{
				
		$item = $repo->findWith(Obfuscater::decode($id), $this->with);
		
		return $this->response
					->resource()
					->including($this->with)
					->withItem($item, $transformer);
		
	}
	
	/**
	 * 
	 * @param RepositoryInterface $repo
	 * @param Request $request
	 * @param TransformerAbstract $transformer
	 * 
	 * @return JsonResponse
	 */
	public function index(RepositoryInterface $repo, TransformerAbstract $transformer)
	{
		
		$collection = $repo->orderBy($this->orderBy)->getPaginated($this->with, $this->perPage);
			
		return $this->response
					->resource()
					->including($this->with)
					->withPaginated($collection, $transformer);
		
	}
	
	/**
	 * 
	 * @param CreateCommand $command
	 * @param Request $request
	 * 
	 * @return JsonResponse
	 */
	public function store(CreateCommand $command)
	{
		$data = Obfuscater::decodeArray($this->request->all(), 'id');
		
		$command->setData($data);
		
		$command->execute();
		
		return $this->response->created();
	}
	
	/**
	 * 
	 * @param UpdateCommand $command
	 * @param Request $request
	 * 
	 * @return JsonResponse
	 */
	public function update($id, UpdateCommand $command)
	{
		$data = Obfuscater::decodeArray($this->request->all(), 'id');
		
		$command->setData($data);
		
		$command->setId(Obfuscater::decode($id));
		
		$command->execute();
		
		return $this->response->updated();
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param RepositoryInterface $repo
	 * 
	 * @return JsonResponse
	 */
	public function destroy($id, RepositoryInterface $repo)
	{
		
		$deletedId = $this->filterIncludeParams($id);
		
		$repo->destroy(Obfuscater::decode($deletedId));
		
		return $this->response->deleted();
	}
	
	/**
	 * 
	 * @param string $dateRange
	 * @param Report $report
	 * @param TransformerAbstract $transformer
	 * e
	 * @return JsonResponse
	 */
	public function report($dateRange, Report $report, TransformerAbstract $transformer)
	{
		
		$result = $report->whenDate($dateRange)
							->getResult()
							->paginate($this->perPage);
		
		return $this->response
					->resource()
					->including($this->with)
					->withPaginated($result, $transformer);
		
	}
	
	/**
	 * 
	 * @param integer $id
	 * @param string $dateRange yyy-mm-dd
	 * @param Report $report
	 * @param Request $request
	 * @param TransformerAbstract $transformer
	 * 
	 * @return  JsonResponse
	 */
	public function reportFor($id, $dateRange, Report $report, TransformerAbstract $transformer)
	{
		
		$result = $report->whenDate($dateRange)
						->getResultFor( Obfuscater::decode($id) )
						->paginate($this->perPage);
	
		return $this->response
					->resource()
					->including($this->with)
					->withPaginated($result, $transformer);
	}

	/**
	 * search resource in $field where like $param
	 * 
	 * @param RepositoryInterface $repo
	 * @param string $field
	 * @param string $param
	 * @param TransformerAbstract $transformer
	 * 
	 * @return  JsonResponse
	 */
	public function search(RepositoryInterface $repo, $field, $param, TransformerAbstract $transformer)
	{
		$result = $repo->orderBy($this->orderBy)->search($field, $param, $this->with, $this->perPage);

		return $this->response
					->resource()
					->including($this->with)
					->withPaginated($result, $transformer);
	}
	
	/**
	 * 
	 * @param string $param
	 */
	private function filterIncludeParams($param)
	{
		$paramsinclude  = [];
	
	
		if (! is_null($param)) {
			//remove the whitespace
			$param = str_replace(' ', '', $param);
	
			foreach (explode(',', $param) as $data) {
				$paramsinclude[]  = $data;
			}
		}
	
		return $paramsinclude;
	}
}