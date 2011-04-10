<?php
/*
 * Created on 17.Kas.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Fide_model extends Model {
 	
 	function index() {
 	}
 	
 	function yuk() {

 		if($_POST) {
	 		$data = array( 
				'isim' => $_POST['isim'], 
				'soyad' => $_POST['soyad'],
				'adres' => $_POST['adres'], 
				'telefon' => $_POST['tel'] 
				);
	 		$q = $this->db->insert('deneme', $data);
	 		echo 'yazildi';
	 	}
 		
 	}
 	
 	function cek() {
	 
 		$q = $this->db->get('deneme');
 		
 		if ($q->num_rows > 0) {
 		
	 		foreach ($q->result() as $row) {
	 			$rows[] = $row;
	 		}
	 		$data['rows'] = $rows;
	 		return $data;
 		}
 		
 		else echo 'kayit yok';
 	}
 	
 }
