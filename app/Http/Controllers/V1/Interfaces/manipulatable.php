<?php

namespace Sikasir\Http\Controllers\V1\Interfaces;

interface manipulatable 
{
	/**
	 * command to create
	 *
	 * @param array $data
	 *
	 * @return void
	 */
	public function createJob(array $data);
	

	/**
	 * command update
	 *
	 * @param integer $id
	 * @param array $data
	 *
	 * @return void
	 */
	public function updateJob($id, array $data);
	
	/**
	 * get the request
	 *
	 * @return Request
	 */
	public function getRequest();
}