<strong>
<?php
	if(sizeof($arrResult) == 0){
		echo 'nenhum resultado encontrado <a onclick="window.location.href = window.location.href;">tente novamete</a>';
		return;
	}

echo sizeof($arrResult);

?>
 </strong> Paginas encontradas para seu termo: 
<br><br>

<?php
	
	foreach ($arrResult as $key => $objResult)
	{
?>
		<p>
			<a href="<?php echo $strUrl.'/'.$objResult['dsc_lnk_page']; ?>"><?php echo $objResult['dsc_nome_pagina']; ?></a>
		</p>
<?php
	}
?>
