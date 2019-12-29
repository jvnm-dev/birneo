<?php 	
	if(isset($index)){

	}else{
		echo "<footer style='background-color: #FFF;padding:5px;padding-top:0;'>";
		echo "<hr />";
	} 
?>

    <p style="font-size: 11px;"><img style="margin-bottom:3px;" src="http://birneo.com/assets/img/copy.png" width="20" height="20" title="&copy; Birneo 2013"/> 
    	<a href='http://www.copyright.be/depot_copyright/certificat_depot_copyright.html?numdepot=DEP635160846956093750' target='_blank'>&copy Birneo, tous droits réservés</a> 
    	
   	 - <?php echo '<a class="colorBirneo" href="http://birneo.com/confidentialite">Politique de confidentialité</a>'; ?>
     - <a href="<?php echo 'http://birneo.com/conditions'; ?> " class="colorBirneo">Conditions d’utilisation</a> 
     <span class="colorBirneo pull-right">
     	<!-- <a href="<?php /* echo 'http://birneo.com/support'; */?> " class="colorBirneo">Support</a> <span style="color:black">-</span> !--> <a target="_blank" href="<?php echo 'http://birneo.wordpress.com/'; ?> " class="colorBirneo">Devblog</a> <span style="color:black">-</span> <?php echo $version; ?>
 	 </span>
 	 
 	</p>
<?php 	
	if(isset($index)){

	}else{
		echo "</footer>";
	} 
?>