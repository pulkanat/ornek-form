<?php
/*
 * Created on 27.Kas.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Ornek_form_model extends Model {
 	
 	function Ornek_form_model () {
 		
 		parent::Model();
 		
 	}
 	
 	function kayit_say($data = false) {
 		$this->db->select("COUNT(*) AS count");
 		if($data) { //arama durumu
 			if($data['isim']) $this->db->where('isim LIKE', "%".$data['isim']."%");
	 		if($data['soyad']) $this->db->where('soyad LIKE', "%".$data['soyad']."%");
	 		if($data['eposta']) $this->db->where('eposta LIKE', "%".$data['eposta']."%");
	 		if($data['eposta2']) $this->db->where('eposta2 LIKE', "%".$data['eposta2']."%");
	 		if($data['tel']) $this->db->where('tel LIKE', "%".$data['tel']."%");
 		}
 		$q = $this->db->get('ornek');
 		
 		$res = $q->result();
 		$sayi = $res[0]->count;
 		
 		if(isset($sayi)) return $sayi;
 		else return false; 
 		
 	}
 	
 	function bilgi_goster($count=0, $start=0) {
 		
 		if($count) $q = $this->db->get('ornek', $count, $start);
 		else $q = $this->db->get('ornek');
 		
 		if ($q->num_rows > 0) {	
 	 		
 	 		foreach ($q->result() as $row) {
	 			$rows[] = $row;
	 		}
	 		
	 		return $rows;
	 		
 		}
 		
 		else return false;
 		
 	}
 	
 	function arama_yap($data, $count=0, $start=0) {
 		 		
		if($data['isim']) $this->db->where('isim LIKE', "%".$data['isim']."%");
 		if($data['soyad']) $this->db->where('soyad LIKE', "%".$data['soyad']."%");
 		if($data['eposta']) $this->db->where('eposta LIKE', "%".$data['eposta']."%");
 		if($data['eposta2']) $this->db->where('eposta2 LIKE', "%".$data['eposta2']."%");
 		if($data['tel']) $this->db->where('tel LIKE', "%".$data['tel']."%");
 		
 		if($count) $q = $this->db->get('ornek', $count, $start);
 		else $q = $this->db->get('ornek');
 		
 		if ($q->num_rows > 0) {	
 	 		
 	 		foreach ($q->result() as $row) {
	 			$rows[] = $row;
	 		}
	 		
	 		return $rows;
	 		
 		}
 		
 		else return false;
 		
 		
 	}
 	
 	function kayit_al($data) {
 		
  		$q = $this->db->insert('ornek', $data);
  		
 	}
 	
 	function id_bul($num_row) {//veritabanindaki siradan id bulma
 		$this->db->select('id');
 		$q = $this->db->get('ornek', 1, $num_row);
 		
 		$res = $q->result(); //php4 icin boyle
 		return $res[0]->id;
 	}
 	
 	function sira_bul($id) {
 		$this->db->select('COUNT(*) AS sira');
 		$this->db->where('id <=', $id);
 		
 		$q = $this->db->get('ornek');
 		
 		$res = $q->result();
 		if(isset($res[0]->sira)) return $res[0]->sira-1;
 		else return false;
 	}
 	
 	function kayit_degistir($data, $id) {
 		
 		$q = $this->db->update('ornek', $data, array('id' => $id));
 		
 	}
 	
 	function kayit_sil($id) {
 		
 		$sira = $this->sira_bul($id);
 		$q = $this->db->delete('ornek', array('id' => $id));
 		return $sira+2;
 		
 	}
 	
 	function var_mi($isim, $soyad) {
 		$this->db->select('id');
 		$this->db->where('isim', $isim);
 		$this->db->where('soyad', $soyad);
 		$q = $this->db->get('ornek');
 		
 		$res = $q->result();
 		
 		if(isset($res[0]->id)) return $res;
 		else return false;
 	}
 	
 	function id_var_mi($id) { //ah ah aslinda tek var_mi fonsiyonu yapmayi dusunmustum
 		$this->db->select('id');
 		$this->db->where('id', $id);
 		$q = $this->db->get('ornek');
 		
 		$res = $q->result();
 		
 		if(isset($res[0]->id)) return $res;
 		else return false;
 	}
 	
 	
 }