 <?php

/**
* Texte
*/
class Texte{
	
	public static function limit($texte,$nbr){

		return (strlen($texte) > $nbr ? substr(substr($texte,0,$nbr),0,strrpos(substr($texte,0,$nbr)," "))." ..." : $texte);
	}

	public static function french_date($d){

		$mois = array('Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Juil', 'Aout', 'Sep', 'Oct', 'Nov', 'Dec');

		$blocs = explode(' ',$d);
		$date = explode('-',$blocs[0]);

		$french = $date[2].' '.$mois[$date[1]-1].' '.$date[0];

		return $french;
	}
}


?>