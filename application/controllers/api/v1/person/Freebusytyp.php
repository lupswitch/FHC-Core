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

class Freebusytyp extends APIv1_Controller
{
	/**
	 * Freebusytyp API constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		// Load model FreebusytypModel
		$this->load->model('person/freebusytyp_model', 'FreebusytypModel');
		// Load set the uid of the model to let to check the permissions
		$this->FreebusytypModel->setUID($this->_getUID());
	}

	/**
	 * @return void
	 */
	public function getFreebusytyp()
	{
		$freebusytyp_kurzbz = $this->get('freebusytyp_kurzbz');
		
		if(isset($freebusytyp_kurzbz))
		{
			$result = $this->FreebusytypModel->load($freebusytyp_kurzbz);
			
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
	public function postFreebusytyp()
	{
		if($this->_validate($this->post()))
		{
			if(isset($this->post()['freebusytyp_kurzbz']))
			{
				$result = $this->FreebusytypModel->update($this->post()['freebusytyp_kurzbz'], $this->post());
			}
			else
			{
				$result = $this->FreebusytypModel->insert($this->post());
			}
			
			$this->response($result, REST_Controller::HTTP_OK);
		}
		else
		{
			$this->response();
		}
	}
	
	private function _validate($freebusytyp = NULL)
	{
		return true;
	}
}