<?php
/*
 * Created on 27.Kas.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 //head kismina gerekli seyleri yazalim bi ara
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="tr_TR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="tr" />
	<meta name="GENERATOR" content="PHPEclipse 1.2.0" />
	<link href="<?php echo base_url(); ?>application/views/style.css" type="text/css" rel="stylesheet" media="screen" />
	<title>Ornek Form</title>
	<script type="text/javascript" src="<?php echo base_url(); ?>application/views/jquery-1.3.2.min.js"></script>
	<script type="text/javascript">
	
	var page = 0; //pagination icin, su an bulundugumuz sayfanin ilk eleman sayisi
	var loadimg = $('<img src="<?php echo base_url(); ?>application/views/halkaload.gif" alt="Loading via AJAX" />'); //ajax donergeci
		
	$(document).ready(function () {
		
		jQuery.fn.valid_abc = function () {
			
			var class = this.attr('name');
			var name = $('label.form.'+class).text(); 
			name = name.replace(/:$/,'');
			if(!/^[a-z _]+$/i.test(this.val()) && this.val() != '') $('span.form.hata.'+class).text(name+' alanı harflerden oluşmak zorundadır.').show();
			//else $('span.form.hata.isim').hide().text('');
			return this;

		}
		
		jQuery.fn.valid_mail = function () {

			var class = this.attr('name');
			var mail = this.val(); 
			if(!/^[a-z0-9_\.]+@[a-z0-9_]+\.[a-z]{2,4}$/i.test(this.val()) && this.val() != '') $('span.form.hata.'+class).text(mail+' geçerli bir e-posta adresi değil.').show();
			//else $('span.form.hata.'+class).hide().text(''); //onblur testi olmadigi icin buradan kaldir
			return this;

		}
		
		jQuery.fn.valid_inside_mail = function () {
			
			var class = this.attr('name');
			if(!/^[a-z0-9_\.]+@(sirket1\.com|sirket2\.com|sirket3\.org)$/.test(this.val()) && this.val() != '') $('span.form.hata.'+class).text('Şirket içi e-posta sirket1.com, sirket2.com, sirket3.org sunucularından birinden olmalıdır.').show();
			//else $('span.form.hata.'+class).hide().text(''); //onblur testi olmadigi icin burdan kaldir
			return this;
			
			
		}

		jQuery.fn.valid_123 = function () {

			var class = this.attr('name');
			var name = $('label.form.'+class).text();
			name = name.replace(/:$/,'');
			if(!/^[0-9]+$/.test(this.val()) && this.val() != '') $('span.form.hata.'+class).text(name+' alanı rakamlardan oluşmak zorundadır.').show();
			else if(/^0/.test(this.val()) && this.val() != '') $('span.form.hata.'+class).text(name+' alanı sıfırla başlayamaz.').show();
			//else $('span.form.hata.isim').hide().text('');
			return this;

		}
		
		jQuery.fn.required = function () {
			
			var class = this.attr('name');
			var name = $('label.form.'+class).text();
			name = name.replace(/:$/,'');
			if(this.val() == '') $('span.form.hata.'+class).text(name+' alanının doldurulması zorunludur.').show();
			//else $('span.form.hata.isim').hide().text('');
			return this;
			
			
		}
		
		jQuery.fn.valid_id = function () {
			
			//yalnizca id icin kullanilacak, trim, required, number deneyecek, id mevcut mu diye ajax ustunden kontrol edecek...
			
			var untrimmed_id = this.val();
			var halftrimmed_id = untrimmed_id.replace(/^\s+/,'');
			var trimmed_id = halftrimmed_id.replace(/\s+$/,'');
			this.val(trimmed_id);
			
			if(trimmed_id == '') $('p.form.hata.id').text('id alani zorunlu...').show();
			
			else if((!/^[0-9]+$/.test(trimmed_id))) $('p.form.hata.id').text('id alani sayi olcek...').show();
			else if(/^0/.test(trimmed_id)) $('p.form.hata.id').text('id alani sifirla baslamayacek...').show();
			
			else {
				
				ajax_donergeci();
				
				$.post('<?php echo site_url('ornek_form'); ?>', "valid_id="+trimmed_id, function (gelen) {
					
					loadimg.remove();
					$('.bilgi.baslik.id').text('No');
					if(gelen.id==0) $('p.form.hata.id').text('bole bi id yok!').show();
					else $('p.form.hata.id').hide().text('');
					
				}, 'json');
				
			}
			
			return this;
			
		}
		

		jQuery.fn.trim_input = function () {

			var untrimmed = this.val();
			var halftrimmed = untrimmed.replace(/^\s+/,'');
			var trimmed = halftrimmed.replace(/\s+$/,'');
			this.val(trimmed);
			return this;

		}
		
		jQuery.fn.extremum_length = function (min, max) {
			
			var class = this.attr('name');
			var name = $('label.form.'+class).text();
			name = name.replace(/:$/,'');
			var str = this.val(); 
			if(str.length < min) $('span.form.hata.'+class).text(name+' alanı en az '+min+' harf uzunluğunda olmalıdır.').show(); //>
			else if(str.length > max) $('span.form.hata.'+class).text(name+' alanı en fazla '+max+' harf uzunluğunda olmalıdır.').show();
			//else $('span.form.hata.isim').hide().text('');
			return this;			
			
		}
		
		jQuery.fn.hide_error = function () { //baslangicta eski hatalari saklayalim ki tekrar cikmasinlar
			
			var class = this.attr('name');
			$('span.form.hata.'+class).hide().text('');
			return this;
			
		}
		
		function isim_sor() {
			var sonuc = '';
			var isim = $('.form.text.isim').val();
			var soyad = $('.form.text.soyad').val();
			
			ajax_donergeci();

			$.post('<?php echo site_url('ornek_form'); ?>', "valid_isim="+isim+"&valid_soyad="+soyad, function (gelen) {
				
				sonuc = gelen.id;
				loadimg.remove();
				$('.bilgi.baslik.id').text('No');
				if(gelen.id!=0) $('.form.hata.genel').text('Bu isim ve soyad '+gelen.id+' nolu kayıtta mevcut').show();
				else $('.form.hata.genel').hide().text('');
				
			}, 'json');
			return sonuc;
		}
		
		$('.form.text.isim').blur(function () {
			if($(this).val() != '') {
				$(this).trim_input().hide_error().extremum_length(2,20).valid_abc();

				//chek for isim,soyad via ajax, arada da yukleme gostert

				if($('.form.text.soyad').val() != '') isim_sor();
				
			}
			if(hatasiz_form()) $('div.form.kutu').width(400); // arama da hata olsa da olur nasil yapacagiz? hatasiz form islevini degistirmeliyiz
			else $('div.form.kutu').width(500);
		});
		$('.form.text.soyad').blur(function () {
			if($(this).val() != '') {
				$(this).trim_input().hide_error().extremum_length(2,20).valid_abc();

				//chek for isim,soyad via ajax, arada da yukleme gostert

				if($('.form.text.isim').val() != '') isim_sor();

			}
			if(hatasiz_form()) $('div.form.kutu').width(400);
			else $('div.form.kutu').width(500);
		});
		$('.form.text.eposta').blur(function () {
			if($(this).val() != '') $(this).trim_input().hide_error().valid_mail();
			if(hatasiz_form()) $('div.form.kutu').width(400);
			else $('div.form.kutu').width(500);
		});
		$('.form.text.eposta2').blur(function () {
			if($(this).val() != '') $(this).trim_input().hide_error().valid_inside_mail();
			if(hatasiz_form()) $('div.form.kutu').width(400);
			else $('div.form.kutu').width(500);
		});
		$('.form.text.tel').blur(function () {
			if($(this).val() != '') $(this).trim_input().hide_error().valid_123();
			if(hatasiz_form()) $('div.form.kutu').width(400);
			else $('div.form.kutu').width(500);
		});
		$('.form.submit.id').blur(function () {
			if($(this).val() != '')	$(this).valid_id();
		})
		
		function hatasiz_form() {
			var hata = false;
			$('span.form.hata').each(function () {
				if($(this).text() != '') hata = true;
			})
			//if($('p.form.hata.genel').text() != '' || $('p.form.hata.id').text() != '') hata = true;
			return !hata;
		}
		
		function ajax_donergeci() {
			$('.bilgi.baslik.id').empty()
			loadimg.appendTo('.bilgi.baslik.id')
		}
		
		function arama_str() { //arama bilgisi stringi olustur -a-b-c-d-e-
				
			var aktar = '';
			aktar += '-' + $('.form.text.isim').val();
			aktar += '-' + $('.form.text.soyad').val();
			aktar += '-' + $('.form.text.eposta').val();
			aktar += '-' + $('.form.text.eposta2').val();
			aktar += '-' + $('.form.text.tel').val();
			
			if(aktar == "-----") return '';
			else return aktar;
			
		}

		function giden_hazirla(islem, aktar) { //aslinda burada da validation yapmak lazim, ajax ile amp ile cakma bilgi yollanabiliyor
			var cikti = islem+'=ajax';
			if(islem == 'yeni' || islem == 'degistir' || islem == 'arama') cikti += '&isim='+$('.form.text.isim').val();
			if(islem == 'yeni' || islem == 'degistir' || islem == 'arama') cikti += '&soyad='+$('.form.text.soyad').val();
			if(islem == 'yeni' || islem == 'degistir' || islem == 'arama') cikti += '&eposta='+$('.form.text.eposta').val();
			if(islem == 'yeni' || islem == 'degistir' || islem == 'arama') cikti += '&eposta2='+$('.form.text.eposta2').val();
			if(islem == 'yeni' || islem == 'degistir' || islem == 'arama') cikti += '&tel='+$('.form.text.tel').val();
			if(islem == 'degistir' || islem == 'sil') cikti += '&id='+$('.form.submit.id').val();
			if(islem == 'pagi') cikti = islem+'=ajax&page='+page;
			if(islem == 'pagi' && aktar) cikti = islem+'=ajax&page='+page+'&arama_bilgisi='+aktar;
			return cikti;

		}

		function tablo_hazirla(data, sonid) {

			var row_count = data.length;
			
			$('tr.bilgi.yazi').hide()
			$('td.bilgi.yazi').removeClass('son');

			$('td.yazi.bilgi.id').each(function (index) {
				if(index < row_count) $(this).text(data[index].id).parent().fadeIn()
				if($(this).text() == sonid) $(this).siblings().andSelf().addClass('son')
			})
			$('td.yazi.bilgi.isim').each(function (index) {
				if(index < row_count) $(this).text(data[index].isim).fadeIn() //>
			})
			$('td.yazi.bilgi.soyad').each(function (index) {
				if(index < row_count) $(this).text(data[index].soyad).fadeIn() //>
			})
			$('td.yazi.bilgi.eposta').each(function (index) {
				if(index < row_count) $(this).text(data[index].eposta).fadeIn() //>
			})
			$('td.yazi.bilgi.eposta2').each(function (index) {
				if(index < row_count) $(this).text(data[index].eposta2).fadeIn() //>
			})
			$('td.yazi.bilgi.tel').each(function (index) {
				if(index < row_count) $(this).text(data[index].tel).fadeIn() //>
			})

		}

		function edit_ekle() {
			
			$('<td>Edit</td>').addClass('bilgi baslik edit').appendTo('tr.bilgi.baslik');
			
			$('tr.bilgi.yazi').each(function() {
				
				var edit_box = $('<td class="bilgi yazi edit">ed_img</td>').css('cursor','pointer').click(function () {
					
					var ed_isim = $(this).siblings('.isim').text();
					$('.form.isim.text').val(ed_isim);
					var ed_soyad = $(this).siblings('.soyad').text();
					$('.form.soyad.text').val(ed_soyad);
					var ed_eposta = $(this).siblings('.eposta').text();
					$('.form.eposta.text').val(ed_eposta);
					var ed_eposta2 = $(this).siblings('.eposta2').text();
					$('.form.eposta2.text').val(ed_eposta2);
					var ed_tel = $(this).siblings('.tel').text();
					$('.form.tel.text').val(ed_tel);
					var ed_id = $(this).siblings('.id').text();
					$('.form.submit.id').val(ed_id);
					
				})
				
				$(this).append(edit_box);
				
			})
			
		}
		
		function hata_hazirla(error) {
			
			$('div.form.kutu').width(500);
			if(error.isim) $('span.form.hata.isim').text(error.isim).show();
			else $('span.form.hata.isim').hide().text('');
			if(error.soyad) $('span.form.hata.soyad').text(error.soyad).show();
			else $('span.form.hata.soyad').hide().text('');
			if(error.eposta) $('span.form.hata.eposta').text(error.eposta).show();
			else $('span.form.hata.eposta').hide().text('');
			if(error.eposta2) $('span.form.hata.eposta2').text(error.eposta2).show();
			else $('span.form.hata.eposta2').hide().text('');
			if(error.tel) $('span.form.hata.tel').text(error.tel).show();
			else $('span.form.hata.tel').hide().text('');
			if(error.id) $('p.form.hata.id').text(error.id).show();
			else $('p.form.hata.id').hide().text('');
		
		}
		
		function pagi_yap(orta, son, arama_str) {
			
			if(son == 0) { //eger gelen tablo tek sayfa ise
				
				$('a.pagi').hide();
				$('.pagi.n').hide();
				
			}
			else {
				orta = Number(orta);
				var link = "<?php echo site_url('ornek_form')."/index/";?>";
				if(!arama_str) arama_str='';
				orta = orta-orta%5; //saat sabahin 6si ve sacmaladigimin farkindayim
				var ortasayfa = orta/5+1;
				var nums = new Array(orta-10,orta-5,orta,orta+5,orta+10);
				if(orta >= 15) $('a.pagi.first').attr('href', link+arama_str).show(); //first
				else $('a.pagi.first').hide();
				if(orta >= 5) $('a.pagi.pre').attr('href', link+nums[1]+arama_str).show(); //pre
				else $('a.pagi.pre').hide();
				if(orta >= 10) $('a.pagi.n-2').attr('href', link+nums[0]+arama_str).text(ortasayfa-2).show(); //n-2 
				else $('a.pagi.n-2').hide();
				if(orta >= 5) $('a.pagi.n-1').attr('href', link+nums[1]+arama_str).text(ortasayfa-1).show(); //n-1
				else $('a.pagi.n-1').hide();
				$('.pagi.n').text(ortasayfa).show(); //n
				if(orta <= son-5) $('a.pagi.n--1').attr('href', link+nums[3]+arama_str).text(ortasayfa+1).show(); //n+1>
				else $('a.pagi.n--1').hide();
				if(orta <= son-10) $('a.pagi.n--2').attr('href', link+nums[4]+arama_str).text(ortasayfa+2).show(); //n+2>
				else $('a.pagi.n--2').hide();
				if(orta <= son-5) $('a.pagi.next').attr('href', link+nums[3]+arama_str).show(); //next>
				else $('a.pagi.next').hide();
				if(orta <= son-15) $('a.pagi.last').attr('href', link+(son)+arama_str).show(); //last>
				else $('a.pagi.last').hide();
				
			}
			
			//ulan bunlara pagi.click fonksiyonunu direkt eklesem ne loop cikar be hehehe...
		}
		
		//hijack pagi linkz... bastan yapip hide-show-text cekecez...
		
		function pagi_hijack() {
			
			
			var link = "<?php echo site_url('ornek_form')."/index/";?>";
			var lastlink = $('div.pagi.kutu a:last').attr('href');
			var at = lastlink.indexOf('/index/'); 
			var last = lastlink.slice(at+7);
			//alert('son sayfa '+last); //sonuncuyu al da pagi uzunlugunu bilelim
			
			var pagi_div = $('div.pagi.kutu').empty();
			$('<a>İlk &laquo;</a>').attr('href', link).appendTo(pagi_div).addClass('pagi first js'); //first
			$('<a>&lt;</a>').attr('href', link).appendTo(pagi_div).addClass('pagi pre js'); //pre
			$('<a>n-2</a>').attr('href', link).appendTo(pagi_div).addClass('pagi n-2 js'); //n-2
			$('<a>n-1</a>').attr('href', link).appendTo(pagi_div).addClass('pagi n-1 js'); //n-1
			$('<b>n</b>').appendTo(pagi_div).addClass('pagi n js'); //n
			$('<a>n--1</a>').attr('href', link).appendTo(pagi_div).addClass('pagi n--1 js'); //n+1>
			$('<a>n--2</a>').attr('href', link).appendTo(pagi_div).addClass('pagi n--2 js'); //n+2>
			$('<a>&gt;</a>').attr('href', link).appendTo(pagi_div).addClass('pagi next js'); //next>
			$('<a>Son &raquo;</a>').attr('href', link).appendTo(pagi_div).addClass('pagi last js'); //last>
			
			return last;
		}
		
		var sonpagi = pagi_hijack();
		pagi_yap(0, sonpagi);
		edit_ekle();
		
		$('#yeni').click(function () {
			
			//client-side validation yap
			$('.form.text.isim').trim_input().hide_error().required().extremum_length(2,20).valid_abc();
			$('.form.text.soyad').trim_input().hide_error().required().extremum_length(2,20).valid_abc();
			$('.form.text.eposta').trim_input().hide_error().valid_mail().required();
			$('.form.text.eposta2').trim_input().hide_error().valid_inside_mail().required();
			$('.form.text.tel').trim_input().hide_error().required().valid_123();
			if(hatasiz_form() === false) {alert('formda hatalar tespit edildi'); return false;}
			
			//loading resmi koy
			ajax_donergeci();
			
			//inputlari al
			var giden = giden_hazirla('yeni', '');
			
			//inputlari yolla, gelen veriyi isle, tablonun bi yerinde ajax donder
			$.post('<?php echo site_url('ornek_form'); ?>', giden, function (gelen) {
				//hata varsa inputlari isle
				if(gelen.error) hata_hazirla(gelen.error);
				//formu tazele, tabloyu yap, pagination yenile
				else {
					$('.form.text').val('');
					$('.form.hata').hide().text('');
					$('div.form.kutu').width(400);
					tablo_hazirla(gelen.data, gelen.sonid);
					pagi_yap(gelen.pagi.orta, gelen.pagi.son, '');
				}
				loadimg.remove();
				$('.bilgi.baslik.id').text('No');
			}, 'json');
			return false;
		
		})
		
		$('#degistir').click(function () {
			
			//client-side validation yap
			$('.form.text.isim').trim_input().hide_error().required().extremum_length(2,20).valid_abc();
			$('.form.text.soyad').trim_input().hide_error().required().extremum_length(2,20).valid_abc();
			$('.form.text.eposta').trim_input().hide_error().valid_mail().required();
			$('.form.text.eposta2').trim_input().hide_error().valid_inside_mail().required();
			$('.form.text.tel').trim_input().hide_error().required().valid_123();
			$('.form.submit.id').valid_id(true);
			if(hatasiz_form() === false) {alert('formda hatalar tespit edildi'); return false;}
			
			//loading resmi koy
			ajax_donergeci();
			
			//inputlari al
			var giden = giden_hazirla('degistir', '');
			
			//inputlari yolla, gelen veriyi isle, tablonun bi yerinde ajax donder
			$.post('<?php echo site_url('ornek_form'); ?>', giden, function (gelen) {
				//hata varsa inputlari isle
				if(gelen.error) hata_hazirla(gelen.error);
				//formu tazele, tabloyu yap, pagination yenile
				else {
					//$('.form.text').val('');
					$('.form.hata').hide().text('');
					$('div.form.kutu').width(400);
					tablo_hazirla(gelen.data, gelen.sonid);
					alert('gelen pagination: '+gelen.pagi.orta+' ve '+gelen.pagi.son)
					pagi_yap(gelen.pagi.orta, gelen.pagi.son, '');
				}
				loadimg.remove();
				$('.bilgi.baslik.id').text('No');
			}, 'json');
			return false;
		
		})
		
		$('#sil').click(function () {
			
			//client-side validation yap
			$('.form.submit.id').valid_id(true);
			if(hatasiz_form() === false) {alert('formda hatalar tespit edildi'); return false;}
			
			//loading resmi koy
			ajax_donergeci();
			
			//inputlari al
			var giden = giden_hazirla('sil', '');
			
			//inputlari yolla, gelen veriyi isle, tablonun bi yerinde ajax donder
			$.post('<?php echo site_url('ornek_form'); ?>', giden, function (gelen) {
				//hata varsa inputlari isle
				if(gelen.error) hata_hazirla(gelen.error);
				//formu tazele, tabloyu yap, pagination yenile
				else {
					$('.form.text').val('');
					$('.form.hata').hide().text('');
					$('div.form.kutu').width(400);
					tablo_hazirla(gelen.data, gelen.sonid);
					alert('gelen pagination: '+gelen.pagi.orta+' ve '+gelen.pagi.son)
					pagi_yap(gelen.pagi.orta, gelen.pagi.son, '');
				}
				loadimg.remove();
				$('.bilgi.baslik.id').text('No');
			}, 'json');
			return false;
		
		})
		
		$('#arama').click(function () {
			
			//client-side validation yap
			$('.form.text.isim').trim_input().hide_error().valid_abc();
			$('.form.text.soyad').trim_input().hide_error().valid_abc();
			$('.form.text.eposta').trim_input().hide_error();
			$('.form.text.eposta2').trim_input().hide_error();
			$('.form.text.tel').trim_input().hide_error().valid_123();
			//if(hatasiz_form() === false) {alert('formda hatalar tespit edildi'); return false;}
			
			//loading resmi koy
			ajax_donergeci();
			
			//inputlari al
			var giden = giden_hazirla('arama', '');
			
			//inputlari yolla, gelen veriyi isle
			$.post('<?php echo site_url('ornek_form'); ?>', giden, function (gelen) {
				//hata varsa inputlari isle
				if(gelen.error) alert('aramadan hata geldi');//hata_hazirla(gelen.error);
				//formu tazele, tabloyu yap, pagination yenile
				else {
					//$('.form.text').val('');
					$('.form.hata').hide().text('');
					$('div.form.kutu').width(400);
					page = 0; //yeni bir sayfa acalim
					tablo_hazirla(gelen.data, gelen.sonid);
					//alert('gelen pagination: '+gelen.pagi.orta+' ve '+gelen.pagi.son)
					var arama_bilgisi = arama_str();
					pagi_yap(gelen.pagi.orta, gelen.pagi.son, arama_bilgisi);
				}
				loadimg.remove(); //ajax donergecini kaldir...
				$('.bilgi.baslik.id').text('No');
			}, 'json');
			return false;
		
		})
		
		
		$('div.pagi.kutu a').click(function () { //pagination onclick
			
			ajax_donergeci();
			
			var current_link = $(this).attr('href');
			var at = current_link.indexOf('/index/'); 
			var last = current_link.slice(at+7);
			var aktar = '';
			if(last.indexOf('-') != -1) {
				aktar = last.slice(last.indexOf('-'))
				page = last.slice(0, last.indexOf('-'))
			}
			else page = last;
			if(page == '') page = 0;
						
			//inputlari al
			var giden = giden_hazirla('pagi', aktar);
			
			//inputlari yolla, gelen veriyi isle, tablonun bi yerinde ajax donder
			$.post('<?php echo site_url('ornek_form'); ?>', giden, function (gelen) {
				//tabloyu yap, pagination yenile
				//alert('gelen sayfa='+gelen.pagi.orta+' son='+gelen.pagi.son);
				//alert('gelen.data = '+gelen.data);
				tablo_hazirla(gelen.data, gelen.sonid);
				pagi_yap(gelen.pagi.orta, gelen.pagi.son, aktar);
				//yeni pagilere de bu onclick'ten ekleme, hide-show-text ile hallet!
					
				loadimg.remove();
				$('.bilgi.baslik.id').text('No');
			}, 'json');
			return false;
		})
		
	})

	</script>
</head>
<body>
	<div class="wrapper">
		<div class="form kutu" style="width:<?php
			if(form_error('isim') || form_error('soyad') || form_error('eposta') || form_error('eposta2') || form_error('tel')) echo "500px";
			else echo "400px";
		 	?>;">
			<?php echo form_open('ornek_form'); ?>
				<?php //data hazirlik
					$isim = isset($arama['isim']) ? $arama['isim'] : set_value('isim');
					$soyad = isset($arama['soyad']) ? $arama['soyad'] : set_value('soyad');
					$eposta = isset($arama['eposta']) ? $arama['eposta'] : set_value('eposta');
					$eposta2 = isset($arama['eposta2']) ? $arama['eposta2'] : set_value('eposta2');
					$tel = isset($arama['tel']) ? $arama['tel'] : set_value('tel');
				?>
				<fieldset>
				<legend>Ornek Form</legend>
				<table class="form table">
					<tr>
						<td><label for="isim" class="form etiket isim">İsim:</label></td>
						<td><input type="text" class="form text isim" name="isim" value="<?php echo $isim; ?>" size="20" maxlength="20" /></td>
						<td><span class="form hata isim"><?php echo form_error('isim'); ?></span></td>
					</tr>
					<tr>
						<td><label for="soyad" class="form etiket soyad">Soyad:</label></td>
						<td><input type="text" class="form text soyad" name="soyad" value="<?php echo $soyad; ?>" size="20" maxlength="20" /></td>
						<td><span class="form hata soyad"><?php echo form_error('soyad'); ?></span></td>
					</tr>
					<tr>
						<td><label for="eposta" class="form etiket eposta">E-Posta:</label></td>
						<td><input type="text" class="form text eposta" name="eposta" value="<?php echo $eposta; ?>" size="20" maxlength="20" /></td>
						<td><span class="form hata eposta"><?php echo form_error('eposta'); ?></span></td>
					</tr>
					<tr>
						<td><label for="eposta2" class="form etiket eposta2">Şirket İçi E-posta:</label></td>
						<td><input type="text" class="form text eposta2" name="eposta2" value="<?php echo $eposta2; ?>" size="20" maxlength="20" /></td>
						<td><span class="form hata eposta2"><?php echo form_error('eposta2'); ?></span></td>
					</tr>
					<tr>
						<td><label for="tel" class="form etiket tel">Telefon: (+90)</label></td>
						<td><input type="text" class="form text tel" name="tel" value="<?php echo $tel; ?>" size="20" maxlength="20" /></td>
						<td><span class="form hata tel"><?php echo form_error('tel'); ?></span></td>
					</tr>
				<!-- buraya bir de textarea'li html kabul eden imza bolumu koyacagiz -->
				</table>
				</fieldset>
				<input type="submit" class="form submit button" id="yeni" name="yeni" value="Yeni Kayıt" />
				<label for="id" class="submit etiket id">No:</label>
				<input type="text" class="form submit id" name="id" value="" size="3" maxlength="5"/>
				<input type="submit" class="form submit button" id="degistir" name="degistir" value="Değiştir" />
				<input type="submit" class="form submit button" id="sil" name="sil" value="Sil" />
				<input type="submit" class="form submit button" id="arama" name="arama" value="Ara" />
				<p class="form hata genel" style="display: none;"></p>
				<?php if(form_error('id')): ?>
				<p class="form hata id"><?php echo form_error('id'); ?></p>
				<?php endif; ?>
			<?php echo form_close(); ?>
		</div>
		<div class="bilgi kutu">
			<table class='bilgi'>
			<tr class="bilgi baslik">
	 			<td class="bilgi baslik id">No</td>
	 			<td class="bilgi baslik isim">İsim</td>
	 			<td class="bilgi baslik soyad">Soyad</td>
	 			<td class="bilgi baslik eposta">E-Posta</td>
	 			<td class="bilgi baslik eposta2">Ş.İ. E-Posta</td>
	 			<td class="bilgi baslik tel">Telefon</td>
	 		</tr>
	 		<?php if($bilgi): ?>	
	 		<?php foreach ($bilgi as $row): ?>
	 		<tr class="bilgi yazi">
	 			<td class="bilgi <?php if($sonid == $row->id) echo 'son'; ?> yazi id"><?php echo $row->id; ?></td>
	 			<td class="bilgi <?php if($sonid == $row->id) echo 'son'; ?> yazi isim"><?php echo $row->isim; ?></td>
	 			<td class="bilgi <?php if($sonid == $row->id) echo 'son'; ?> yazi soyad"><?php echo $row->soyad; ?></td>
	 			<td class="bilgi <?php if($sonid == $row->id) echo 'son'; ?> yazi eposta"><?php echo $row->eposta; ?></td>
	 			<td class="bilgi <?php if($sonid == $row->id) echo 'son'; ?> yazi eposta2"><?php echo $row->eposta2; ?></td>
	 			<td class="bilgi <?php if($sonid == $row->id) echo 'son'; ?> yazi tel"><?php echo $row->tel; ?></td>
	 		</tr>
	 		<?php endforeach; ?>
	 		</table>
	 		<?php else: ?>
	 		<p class="bilgi bos">Gösterilecek herhangi bir bilgi bulunamadı</p>
	 		<? endif; ?>
	 		<?php 
	 			//buraya
	 			//1 arama modu gelecek, aktari ona gore aktaracaz!
	 			//2 maildeki @'leri ayiran birsey gelecek, daha sonra _ karakterini uriden gelen inputu kontrol ederken duzeltecegiz!
	 			if(isset($arama) && $arama != '') $aktar = "-".$isim."-".$soyad."-".$eposta."-".$eposta2."-".$tel;
	 			else $aktar = '';
	 			if(!isset($pagi)) $pagi = 0;
	 		?>
			<div class="pagi kutu"><?php echo $this->pagination->create_links($aktar, $pagi); ?></div>
		</div>
	</div>
</body>
</html>