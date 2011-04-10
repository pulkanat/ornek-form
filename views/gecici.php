<?php
/*
 * Created on 02.Ara.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
			$('#degistir').click(function () {
				var isim = $('.form.text.isim:eq(0)').text;
				var soyad = $('.form.text.soyad:eq(0)').text;
				var eposta = $('.form.text.eposta:eq(0)').text;
				var eposta2 = $('.form.text.eposta2:eq(0)').text;
				var tel = $('.form.text.tel:eq(0)').text;
				var id = $('.form.id:eq(0)').text;
				$('.bilgi.kutu').load('<?php echo siteurl('ornek_form'); ?>', {'isim': isim, 'soyad': soyad, 'eposta': eposta, 'eposta2': eposta2, 'tel': tel, 'id': id, 'degistir': 'ajax'});
				return false;
			})
			$('#sil').click(function () {
				var id = $('.form.id:eq(0)').text;
				$('.bilgi.kutu').load('<?php echo siteurl('ornek_form'); ?>', {'id': id, 'sil': 'ajax'});
				return false;
			})
			$('#arama').click(function () {
				var isim = $('.form.text.isim:eq(0)').text;
				var soyad = $('.form.text.soyad:eq(0)').text;
				var eposta = $('.form.text.eposta:eq(0)').text;
				var eposta2 = $('.form.text.eposta2:eq(0)').text;
				var tel = $('.form.text.tel:eq(0)').text;
				var id = $('.form.id:eq(0)').text;
				$('.bilgi.kutu').load('<?php echo siteurl('ornek_form'); ?>', {'isim': isim, 'soyad': soyad, 'eposta': eposta, 'eposta2': eposta2, 'tel': tel, 'id': id, 'arama': 'ajax'});
				return false;
			})

			
			
			
			
				<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript">
		$('document').ready(function () {
			$('#yeni').click(function () {
				var isim = $('.form.text.isim:eq(0)').text;
				var soyad = $('.form.text.soyad:eq(0)').text;
				var eposta = $('.form.text.eposta:eq(0)').text;
				var eposta2 = $('.form.text.eposta2:eq(0)').text;
				var tel = $('.form.text.tel:eq(0)').text;
				$.post('<?php echo siteurl('ornek_form'); ?>', {'isim': isim, 'soyad': soyad, 'eposta': eposta, 'eposta2': eposta2, 'tel': tel, 'yeni': 'ajax'}, function (data) {
					alert('okey');
				}, 'json');
				return false;
			})
		})
	</script>
	
	
	<a href="http://localhost/codeign/index.php/ornek_form/index/">&laquo; İlk</a>&nbsp;&nbsp;
	<a href="http://localhost/codeign/index.php/ornek_form/index/15">&lt;</a>&nbsp;
	<a href="http://localhost/codeign/index.php/ornek_form/index/10">3</a>&nbsp;
	<a href="http://localhost/codeign/index.php/ornek_form/index/15">4</a>&nbsp;
	<strong>5</strong>&nbsp;
	<a href="http://localhost/codeign/index.php/ornek_form/index/25">6</a>&nbsp;
	<a href="http://localhost/codeign/index.php/ornek_form/index/30">7</a>&nbsp;
	<a href="http://localhost/codeign/index.php/ornek_form/index/25">&gt;</a>&nbsp;&nbsp;
	<a href="http://localhost/codeign/index.php/ornek_form/index/155">Son &raquo;</a>
	
	
	
	
	
					<table class="form table">
					<tr>
						<td><span class="form etiket isim">İsim:</span></td>
						<td><input type="text" class="form text isim" name="isim" value="<?php echo $isim; ?>" size="30" maxlength="20" /></td>
						<td><span class="form hata isim"><?php echo form_error('isim'); ?></span></td>
					</tr>
					<tr>
						<td><span class="form etiket soyad">Soyad:</span></td>
						<td><input type="text" class="form text soyad" name="soyad" value="<?php echo $soyad; ?>" size="30" maxlength="20" /></td>
						<td><span class="form hata soyad"><?php echo form_error('soyad'); ?></span></td>
					</tr>
					<tr>
						<td><span class="form etiket eposta">E-Posta:</span></td>
						<td><input type="text" class="form text eposta" name="eposta" value="<?php echo $eposta; ?>" size="30" maxlength="20" /></td>
						<td><span class="form hata eposta"><?php echo form_error('eposta'); ?></span></td>
					</tr>
					<tr>
						<td><span class="form etiket eposta2">Şirket İçi E-posta:</span></td>
						<td><input type="text" class="form text eposta2" name="eposta2" value="<?php echo $eposta2; ?>" size="30" maxlength="20" /></td>
						<td><span class="form hata eposta2"><?php echo form_error('eposta2'); ?></span></td>
					</tr>
					<tr>
						<td><span class="form etiket tel">Telefon: (+90)</span></td>
						<td><input type="text" class="form text tel" name="tel" value="<?php echo $tel; ?>" size="30" maxlength="20" /></td>
						<td><span class="form hata tel"><?php echo form_error('tel'); ?></span></td>
					</tr>
					<!-- buraya bir de textarea'li html kabul eden imza bolumu koyacagiz -->
				</table>
				<input type="submit" class="form submit button" id="yeni" name="yeni" value="Yeni Kayıt" />
				<span class="submit etiket id">No:</span>
				<input type="text" class="form id " name="id" value="" size="3" maxlength="5"/>
				<input type="submit" class="form submit button" id="degistir" name="degistir" value="Değiştir" />
				<input type="submit" class="form submit button" id="sil" name="sil" value="Sil" />
				<input type="submit" class="form submit button" id="arama" name="arama" value="Ara" />
				<p class="form hata genel"></p>
	
	
	
	
	
	
	
	$('tr.bilgi.id').each(function (index) {
					$(this).text(gelen.data[index].id)
				})
				$('tr.bilgi.isim').each(function (index) {
					$(this).text(gelen.data[index].isim)
				})
				$('tr.bilgi.soyad').each(function (index) {
					$(this).text(gelen.data[index].soyad)
				})
				$('tr.bilgi.eposta').each(function (index) {
					$(this).text(gelen.data[index].eposta)
				})
				$('tr.bilgi.eposta2').each(function (index) {
					$(this).text(gelen.data[index].eposta2)
				})
				$('tr.bilgi.tel').each(function (index) {
					$(this).text(gelen.data[index].tel)
				})
				