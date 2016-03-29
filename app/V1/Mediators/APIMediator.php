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
	 * @param integer $id
	 * @param RepositoryInterface $repo
	 * @param Request $request
	 * @param TransformerAbstract $transformer
	 * 
	 * @return JsonResponse
	 */
	public function show($id, RepositoryInterface $repo, Request $request, TransformerAbstract $transformer)
	{
		
		$include = $request->input('include');
		
		$with = $this->filterIncludeParams($include);
		
		$item = $repo->findWith(Obfuscater::decode($id), $with);
		
		return $this->response
					->resource()
					->including($with)
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
	public function index(RepositoryInterface $repo, Request $request, TransformerAbstract $transformer)
	{
		
		$include = $request->input('include');
		
		$with = $this->filterIncludeParams($include);
		
		$collection = $repo->getPaginated($with);
		
		return $this->response
					->resource()
					->including($with)
					->withPaginated($collection, $transformer);
		
	}
	
	/**
	 * 
	 * @param CreateCommand $command
	 * @param Request $request
	 * 
	 * @return JsonResponse
	 */
	public function store(CreateCommand $command, Request $request)
	{
		$data = Obfuscater::decodeArray($request->all(), 'id');
		
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
	public function update($id, UpdateCommand $command, Request $request)
	{
		$data = Obfuscater::decodeArray($request->all(), 'id');
		
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
		$repo->destroy(Obfuscater::decode($id));
		
		return $this->response->deleted();
	}
	
	/**
	 * 
	 * @param string $dateRange
	 * @param Report $report
	 * @param Request $request
	 * @param TransformerAbstract $transformer
	 * 
	 * @return JsonResponse
	 */
	public function report($dateRange, Report $report, Request $request, TransformerAbstract $transformer)
	{

		$include = $request->input('include');
		
		$with = $this->filterIncludeParams($include);
		
		$result = $report->whenDate($dateRange)
							->getResult()
							->paginate();
		
		return $this->response
					->resource()
					->including($with)
					->withPaginated($result, $transformer);
		
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $dateRange
	 * @param Report $report
	 * @param Request $request
	 * @param TransformerAbstract $transformer
	 * 
	 * @return  JsonResponse
	 */
	public function reportFor($id, $dateRange, Report $report, Request $request, TransformerAbstract $transformer)
	{
		
		$include = $request->input('include');
	
		$with = $this->filterIncludeParams($include);
	
		$result = $report->whenDate($dateRange)
						->forInstanceWithId( Obfuscater::decode($id) )
						->getResult()
						->paginate();
	
		return $this->response
					->resource()
					->including($with)
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