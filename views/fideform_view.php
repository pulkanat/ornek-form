<?php
/*
 * Created on 15.Kas.2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<html>
<head>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js" ></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#ekle').click(function () {
				$('#bilgi_div').load(
					//'<?php echo site_url('fideform/bas_cek'); ?>',
					'<?php echo "http://78.180.72.132/codeign/index.php/fideform" ?>'
					{ 'isim': $('#isim').text, 'soyad': $('#soyad').text, 'adres': $('#adres').text, 'tel': $('#tel').text }
					);
				return false;
			})
		})
	</script>
</head>
<body>
	<div id="form_div" class="kutu">
		<?php echo form_open('fideform'); ?>
			<table>
				<tr><td>Isim: </td><td><input type="text" class="text" name="isim" id="isim" value="" size="20" maxlength="20" /></td></tr>
				<tr><td>Soyad: </td><td><input type="text" class="text" name="soyad" id="soyad" value="" size="20" maxlength="20" /></td></tr>
				<tr><td>Adres: </td><td><textarea id="adres" name="adres" rows="3" cols="25" wrap="off"></textarea></td></tr>
				<tr><td>Tel: </td><td><input type="text" class="text" name="tel" id="tel" value="" size="11" maxlength="11" /></td></tr>
			</table>
			<input id="ekle" type="submit" class="submit button" name="sub" value="ekle" />
		</form>
	</div>
	<div id="bilgi_div" class="kutu">
		<table>
		<?php 
			echo "<tr><td>id</td><td>isim</td><td>soyad</td><td>adres</td><td>telefon</td></tr>";
			foreach($rows as $row) {
				echo "<tr><td>".$row->id."</td><td>".$row->isim."</td><td>".$row->soyad."</td><td>".$row->adres."</td><td>".$row->telefon."</td></tr>";
			}
		?>
		</table>
	</div>
</body>
</html>