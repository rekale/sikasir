<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Repositories\Interfaces\RepositoryInterface;

abstract  class UpdateCommand
{
	protected $repo;
	protected $data;
	protected $id;
	
	public function __construct(RepositoryInterface $repo)
	{
		$this->repo = $repo;
	}
	
	/**
	 * 
	 * @param array $data
	 * 
	 * @return $this
	 */
	public function setData(array $data)
	{
		$this->data = $data;
		
		return $this;
	}
	/**
	 * 
	 * @param integer $id
	 * 
	 * @return $this
	 */
	public function setId($id)
	{
		$this->id = $id;
		
		return $this;
	}
	
	abstract public  function execute();
}