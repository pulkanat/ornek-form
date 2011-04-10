<?php
/*
 * Created on 27.Kas.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Ornek_form extends Controller {
	
	function Ornek_form () {//php4 constructor
		parent::Controller();
	}
	
	function index($input_str = ''){	
		
		if($this->input->post('pagi') == 'ajax' && $this->input->post('arama_bilgisi')) {
			$input_str = $this->input->post('page').$this->input->post('arama_bilgisi');
		}
		$input = explode('-', $input_str);
		$pagi = isset($input[0]) ? $input[0] : 0;
		$ara_isim = isset($input[1]) ? $input[1] : '';
		$ara_soyad = isset($input[2]) ? $input[2] : '';
		$ara_eposta = isset($input[3]) ? $input[3] : '';
		$ara_eposta2 = isset($input[4]) ? $input[4] : '';
		$ara_tel = isset($input[5]) ? $input[5] : '';
		
		$this->load->model('ornek_form_model');
		
		$row_count = 5; //simdilik sabit
		
		if($this->input->post('valid_isim') && $this->input->post('valid_soyad')) {
			
			//kendi kendimize trim yapalim, alpha bakalim...
			/*$raw_isim = $this->input->post('valid_isim');
			$raw_soyad = $this->input->post('valid_soyad');
			
			$tr_isim = trim($raw_isim);
			$tr_soyad = trim($raw_soyad);
			
			$v_isim = eregi_replace('[^(a-z _)]+','',$tr_isim);
			$v_soyad = eregi_replace('[^(a-z _)]+','',$tr_soyad);*/
			
			$v_isim = $this->input->post('valid_isim');
			$v_soyad = $this->input->post('valid_soyad');
			
			$ids = $this->ornek_form_model->var_mi($v_isim, $v_soyad);
			header('Content-type: application/txt');
			header('Content-Disposition: attachment; filename="valid.json"');
			if($ids) echo "{id:'".$ids[0]->id."'}";
			else echo "{id:'0'}";
			echo "\r\n";		
			return;
		}
		if($this->input->post('valid_id')) {
			
			//kendi kendimize trim yapalim, alpha bakalim...
			/*$raw_isim = $this->input->post('valid_isim');
			$raw_soyad = $this->input->post('valid_soyad');
			
			$tr_isim = trim($raw_isim);
			$tr_soyad = trim($raw_soyad);
			
			$v_isim = eregi_replace('[^(a-z _)]+','',$tr_isim);
			$v_soyad = eregi_replace('[^(a-z _)]+','',$tr_soyad);*/
			
			$v_id = $this->input->post('valid_id');
			
			$ids = $this->ornek_form_model->id_var_mi($v_id);
			header('Content-type: application/txt');
			header('Content-Disposition: attachment; filename="valid.json"');
			if($ids) echo "{id:'".$ids[0]->id."'}";
			else echo "{id:'0'}";
			echo "\r\n";		
			return;
		}
		if(!$this->input->post('arama')) $num_row = $this->ornek_form_model->kayit_say(); //say ki form bossa bile pagi yapabilelim, arama durumunda baska bir kumeyi sayacagiz
		$islem = '';				
		$ajax = false;
		if($this->input->post('yeni') == 'ajax'
		|| $this->input->post('degistir') == 'ajax'
		|| $this->input->post('sil') == 'ajax'
		|| $this->input->post('arama') == 'ajax'
		|| $this->input->post('test') == 'ajax'
		|| $this->input->post('pagi') == 'ajax'
		) $ajax = true;
		if($ajax) {
			if($this->input->post('yeni')) $islem = 'yeni';
			elseif($this->input->post('degistir')) $islem = 'degistir';
			elseif($this->input->post('sil')) $islem = 'sil';
			elseif($this->input->post('ara')) $islem = 'ara';
			elseif($this->input->post('pagi') && is_int($this->input->post('page'))) $islem = 'pagi'; $pagi = $this->input->post('page');
		}
				
		//$this->load->library('form_validation');
		
		if($this->input->post('arama') || isset($_POST['arama'])){ //arama icin gerekli sartlar
			$this->form_validation->set_rules('isim', 'İsim', 'trim|alpha');
			$this->form_validation->set_rules('soyad', 'Soyad', 'trim|alpha');
			$this->form_validation->set_rules('eposta', 'E-Posta', 'trim|alpha');
			$this->form_validation->set_rules('eposta2', 'Şirket İçi E-Posta', 'trim|alpha');
			$this->form_validation->set_rules('tel', 'Telefon', 'trim|integer');
		}
		elseif($this->input->post('sil')) { //silme icin yalnizca id inputu gerekli
			$this->form_validation->set_rules('isim', 'İsim', '');
			$this->form_validation->set_rules('soyad', 'Soyad', '');
			$this->form_validation->set_rules('eposta', 'E-Posta', '');
			$this->form_validation->set_rules('eposta2', 'Şirket İçi E-Posta', '');
			$this->form_validation->set_rules('tel', 'Telefon', ''); 
			$this->form_validation->set_rules('id', 'No', 'trim|required|integer|callback_id_yok'); //bir callback ile silinecek verinin varligini sorgulayalim
		}
		else { //diger her sey, bunlara XSS'leri fln ekle
			$this->form_validation->set_rules('isim', 'İsim', 'trim|callback_isim_var|required|min_length[2]|max_length[20]|alpha');
			$this->form_validation->set_rules('soyad', 'Soyad', 'trim|callback_soyad_var|required|min_length[2]|max_length[20]|alpha');
			$this->form_validation->set_rules('eposta', 'E-Posta', 'trim|required|callback_eposta_valid');
			$this->form_validation->set_rules('eposta2', 'Şirket İçi E-Posta', 'trim|required|callback_eposta2_valid');
			$this->form_validation->set_rules('tel', 'Telefon', 'trim|required|integer|callback_tel_valid'); // buna callback atip ilk sayinin 0 olmamasini saglayacagiz fln
			if($this->input->post('degistir')) $this->form_validation->set_rules('id', 'No', 'trim|required|integer|callback_id_yok'); // modify icin bu required
			else $this->form_validation->set_rules('id', 'No', 'trim|integer');
		}
		
		//turkce hata mesajlari
		$this->form_validation->set_message('required', "%s alanının doldurulması zorunludur.");
		$this->form_validation->set_message('alpha', "%s alanı harflerden oluşmak zorundadır.");
		$this->form_validation->set_message('integer', "%s alanı rakamlardan oluşmak zorundadır.");
		$this->form_validation->set_message('min_length', "%s alanı en az 2 harf uzunluğunda olmalıdır.");
		$this->form_validation->set_message('max_length', "%s alanı en fazla 20 harf uzunluğunda olmalıdır.");
		
		$son = '';
			
		if ($this->form_validation->run() == FALSE) { //eger form yeni acilmissa veya hatali giris olmussa veya hala arama sonuclari gosteriliyorsa veya pagi yapiyosak
			
			//bu verilerin hepsini de kontrol etmek lazim ama nasil????? uzunluk ve tipini kontrol etsek yetebilir. bir de xss_clean cekilebilir...
			if($ara_isim || $ara_soyad || $ara_eposta || $ara_eposta2 || $ara_tel) {
				$data = array('isim' => $input[1], 'soyad' => $input[2], 'eposta' => $input[3], 'eposta2' => $input[4], 'tel' => $input[5]);
				$num_row = $this->ornek_form_model->kayit_say($data);
			}
			elseif($this->input->post('arama')) {$data = '';	$num_row = $this->ornek_form_model->kayit_say();}
			else $data = '';	
			
			$config['base_url'] = site_url("ornek_form/index");
			$config['total_rows'] = $num_row;
			$config['per_page'] = $row_count;
			$config['full_tag_open'] = '<div class="pagi">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = '&laquo; İlk';
			$config['last_link'] = 'Son &raquo;';
		
			$this->pagination->initialize($config);
		
			
			if($data) $rows = $this->ornek_form_model->arama_yap($data, $row_count, $pagi);
			else $rows = $this->ornek_form_model->bilgi_goster($row_count, $pagi);
			
			if($ajax) {
				if($this->input->post('pagi'))  $this->json_yolla($islem, $rows, 0, '', $pagi); 
				else $this->json_yolla($islem, 'error', 0, '', 0); //form yeni acilmissa ajax ile veri gonderilemez sanirim...
			}
			else $this->load->view('ornek_form_view', array('bilgi'=>$rows, 'sonid'=>0, 'arama'=>$data));
		
		}
		
		else {
			$data = array('isim'=>set_value('isim'), 'soyad'=>set_value('soyad'), 'eposta'=>set_value('eposta'), 'eposta2'=>set_value('eposta2'), 'tel'=>set_value('tel'));
			$arama = '';
			
			if($this->input->post('yeni')) { //yeni kayit al, son ekleneni isaretlemek icin son siradaki kayitin idsini al
				$this->ornek_form_model->kayit_al($data);
				$son = $num_row;
				$sonid = $this->ornek_form_model->id_bul($son);
				
			}
			elseif ($this->input->post('degistir')) { //update sonrasi degistirilen kaydi isaretlemek icin id kutusunu al
				if($this->input->post('id')) {
					$this->ornek_form_model->kayit_degistir($data, set_value('id'));
					$son = $this->ornek_form_model->sira_bul(set_value('id'));
					$sonid = set_value('id');
				}
				else $sonuc = "Lutfen No girin"; //bu ne lan?
			}
			elseif ($this->input->post('sil')) { //kayit sil ve hicbir seyi isaretleme
				if($this->input->post('id')) {
					$son = $this->ornek_form_model->kayit_sil(set_value('id'));
					$sonid = 0;
				}
				else $sonuc = "Lutfen No girin"; //bu ne lan?
			}
			elseif ($this->input->post('arama') || isset($_POST['arama'])) { //arama yaparken de bir sey isaretleme
				$sonid=0;
				$num_row = $this->ornek_form_model->kayit_say($data);
				$arama = $data;
			}
			
			//isaretlenen kaydi gostermek icin sayfasini bulalim...
			if($son) $pagi = $son - ($son%$row_count);
			
			if ($this->input->post('arama')) $rows = $this->ornek_form_model->arama_yap($data, $row_count, $pagi);
			else $rows = $this->ornek_form_model->bilgi_goster($row_count, $pagi);
			
			/*if($this->input->post('arama')) $num_row = $this->ornek_form_model->kayit_say($data);
			else $num_row = $this->ornek_form_model->kayit_say();*/
			
			//$this->load->library('pagination');
	
			$config['base_url'] = site_url("ornek_form/index");
			$config['total_rows'] = $num_row;
			$config['per_page'] = $row_count;
			$config['full_tag_open'] = '<div class="pagi">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'İlk &laquo;';
			$config['last_link'] = 'Son &raquo;';
		
			$this->pagination->initialize($config);
			
			if($ajax) $this->json_yolla($islem, $rows, $sonid, $arama, $pagi);
			else $this->load->view('ornek_form_view', array('bilgi'=>$rows, 'sonid'=>$sonid, 'arama'=>$arama, 'pagi'=>$pagi));
			
		}
		
	}
	
	function isim_var($isim) {
		
		$isimvar = $this->ornek_form_model->var_mi($isim, $this->input->post('soyad'));
		
		if($isimvar) {
			$string = '';
			foreach($isimvar as $row) {
				$string .= $row->id.', '; 
			}
			$string = substr($string, 0, -2);
			$this->form_validation->set_message('isim_var',"Bu isim ".$string." nolu kayitta mevcut");
			return false;
		}
		else return true;
		
	}
	
	function soyad_var($soyad) {
		
		$soyadvar = $this->ornek_form_model->var_mi($this->input->post('isim'), $soyad);
		if($soyadvar) {
			$string = '';
			foreach($soyadvar as $row) {
				$string .= $row->id.', '; 
			} 
			$string = substr($string, 0, -2);
			$this->form_validation->set_message('soyad_var',"Bu soyad ".$string." nolu kayitta mevcut");
			return false;
		}
		else return true;
		
	}
	
	function id_yok($id) {
		$ids = $this->ornek_form_model->id_var_mi($id);
		
		if($ids) return true;
		else {
			$this->form_validation->set_message('id_yok', $id." numaralı kayıt bulunamadı.");
			return false;						
		}
			
	}
	
	function eposta_valid($eposta) {// for PHP 4
		
		//regexp ile epostayi siyir, @ ile .com arasindaki seyi al bak, sonra da bunu callback_ diye kurallara yaz
		if(eregi('^[a-z0-9_\.]+@[a-z0-9_]+\.[a-z]{2,4}$', $eposta)) return true;
		else {
			$this->form_validation->set_message('eposta_valid', $eposta." adresi geçerli bir e-posta adresi değil.");
			return false;	
		}
		
	}
	
	function eposta2_valid($eposta2) { //for PHP 4
		
		//regexp ile eposta2 @'ten sonrasini incele
		if(eregi('^[a-z0-9_\.]+@(sirket1\.com|sirket2\.com|sirket3\.org)$', $eposta2)) return true;
		else {
			$this->form_validation->set_message('eposta2_valid', "Şirket içi e-posta sirket1.com, sirket2.com, sirket3.org sunucularından birinden olmalıdır.");
			return false;	
		}
		
		//gecerli mailler, sirket1.com, sirket2.com, sirket3.org
	}
	
	/*function eposta_valid($eposta) {// for PHP 5.3> bunlarda PCRE kullanacaz
		
		//regexp ile epostayi siyir, @ ile .com arasindaki seyi al bak, sonra da bunu callback_ diye kurallara yaz
		if(ereg('^\s@\s*\.[a-zA-Z]{2,4}^', $eposta)) return true;
		else {
			$this->form_validation->set_message('eposta_valid', "E-posta yanlis yazilmis.");
			return false;	
		}
		
	}
	
	function eposta2_valid($eposta2) { //for PHP 5.3> bunlarda PCRE kullanacaz
		
		//regexp ile eposta2 @'ten sonrasini incele
		if(eregi('^\s@\s*\.[a-z]{2,4}^', $eposta2)) return true;
		else {
			$this->form_validation->set_message('eposta_valid', "E-posta yanlis yazilmis.");
			return false;	
		}
		
	}*/
	
	
	function tel_valid($tel) {
		
		$ilkrakam = substr($tel, 0, 1);
		
		if($ilkrakam != 0) return true;
		else {
			$this->form_validation->set_message('tel_valid', "Telefon numarasi 0 ile baslayamaz");
			return false;
		}
		
	}
	
	function json_yolla($islem, $bilgi, $sonid, $arama, $pagi) {
		
		$output = '';
		
		if($bilgi == 'error') {//error gonder
			
			$form_errors = array();
			if(form_error('isim')) $form_errors['isim'] = form_error('isim');
			if(form_error('soyad')) $form_errors['soyad'] = form_error('soyad');
			if(form_error('eposta')) $form_errors['eposta'] = form_error('eposta');
			if(form_error('eposta2')) $form_errors['eposta2'] = form_error('eposta2');
			if(form_error('tel')) $form_errors['tel'] = form_error('tel');
			if($form_errors) {
				$output = '{error: {';
				$ilk = 1;
				foreach($form_errors as $key=>$value) {
					if($ilk) {$output .= $key.': \''.$value.'\''; $ilk=0;}
					else $output .= ', '.$key.': \''.$value.'\'';
				}
				$output .= '}';	
			}
			
		}
		
		else {//tablo gonder
			$output .= '{data: [';
			$ilk = 1;
			foreach ($bilgi as $row) {
				if($ilk) {$output .= '{';$ilk = 0;}
				else $output .= ',{';
				$ilkilk = 1;
				foreach ($row as $key => $value) {
					if($ilkilk) {$output .= $key.': \''.$value.'\'';$ilkilk=0;}
					else $output .= ', '.$key.': \''.$value.'\'';
				}
				$output .= '}';
			}
			$output .= '], sonid: '.$sonid;			
		}
		
		if($islem != 'pagi') $output .= ', pagi: '.$this->pagination->create_links('', $pagi, true);
		else $output .= ', pagi: '.$this->pagination->create_links($arama, $pagi, true);
		$output .= '}';
		header('Content-type: application/txt');
		header('Content-Disposition: attachment; filename="data.json"');
		echo $output;
		echo "\r\n";
	}
	
}