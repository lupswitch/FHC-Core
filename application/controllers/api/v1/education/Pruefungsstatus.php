<?php
/**
 * FH-Complete
 *
 * @package		FHC-API
 * @author		FHC-Team
 * @copyright	Copyright (c) 2016, fhcomplete.org
 * @license		GPLv3
 * @link		http://fhcomplete.org
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Pruefungsstatus extends APIv1_Controller
{
	/**
	 * Pruefungsstatus API constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		// Load model PruefungsstatusModel
		$this->load->model('education/pruefungsstatus', 'PruefungsstatusModel');
		// Load set the uid of the model to let to check the permissions
		$this->PruefungsstatusModel->setUID($this->_getUID());
	}

	/**
	 * @return void
	 */
	public function getPruefungsstatus()
	{
		$status_kurzbz = $this->get('status_kurzbz');
		
		if(isset($status_kurzbz))
		{
			$result = $this->PruefungsstatusModel->load($status_kurzbz);
			
			$this->response($result, REST_Controller::HTTP_OK);
		}
		else
		{
			$this->response();
		}
	}

	/**
	 * @return void
	 */
	public function postPruefungsstatus()
	{
		if($this->_validate($this->post()))
		{
			if(isset($this->post()['status_kurzbz']))
			{
				$result = $this->PruefungsstatusModel->update($this->post()['status_kurzbz'], $this->post());
			}
			else
			{
				$result = $this->PruefungsstatusModel->insert($this->post());
			}
			
			$this->response($result, REST_Controller::HTTP_OK);
		}
		else
		{
			$this->response();
		}
	}
	
	private function _validate($pruefungsstatus = NULL)
	{
		return true;
	}
}