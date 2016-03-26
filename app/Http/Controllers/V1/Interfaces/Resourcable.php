<?php

namespace Sikasir\Http\Controllers\V1\Interfaces;

interface Resourcable 
{
	/**
	 * get repository instance
	 *
	 * @return RepositoryInterface
	 */
	public function getRepo();
	
	/**
	 * set the transformer
	 *
	 * @return TransformerAbstract
	 */
	public function getTransformer();
	
	
}