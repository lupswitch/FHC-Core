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

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lehrtyp extends APIv1_Controller
{
	/**
	 * Lehrtyp API constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		// Load model LehrtypModel
		$this->load->model('education/lehrtyp', 'LehrtypModel');
		// Load set the uid of the model to let to check the permissions
		$this->LehrtypModel->setUID($this->_getUID());
	}

	/**
	 * @return void
	 */
	public function getLehrtyp()
	{
		$lehrtyp_kurzbz = $this->get('lehrtyp_kurzbz');
		
		if (isset($lehrtyp_kurzbz))
		{
			$result = $this->LehrtypModel->load($lehrtyp_kurzbz);
			
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
	public function postLehrtyp()
	{
		if ($this->_validate($this->post()))
		{
			if (isset($this->post()['lehrtyp_kurzbz']))
			{
				$result = $this->LehrtypModel->update($this->post()['lehrtyp_kurzbz'], $this->post());
			}
			else
			{
				$result = $this->LehrtypModel->insert($this->post());
			}
			
			$this->response($result, REST_Controller::HTTP_OK);
		}
		else
		{
			$this->response();
		}
	}
	
	private function _validate($lehrtyp = NULL)
	{
		return true;
	}
}