<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Repositories\Interfaces\RepositoryInterface;

abstract  class UpdateCommand
{
	protected $repo;
	
	public function __construct(RepositoryInterface $repo)
	{
		$this->repo = $repo;
	}
	
	abstract public  function execute();
}