<?php
/*
 * Created on 15.Kas.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Fideform extends Controller {
	
	function Fideform () {

		parent::Controller();

	}
	
	function index() {

		$this->load->model('fide_model');
		$this->fide_model->yuk();
		$data = $this->fide_model->cek();
		$this->load->view('fideform_view', $data);

	}
	
	function bas_cek () {
		
		echo "ehuehue";
		
	}

}