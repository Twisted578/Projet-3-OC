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

	public static function french_date_time($d){

		$mois = array('Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Juil', 'Aout', 'Sep', 'Oct', 'Nov', 'Dec');

		$blocs = explode(' ',$d);
		$date = explode('-',$blocs[0]);

		$time = explode(':',$blocs[1]);

		$french = $date[2].' '.$mois[$date[1]-1].' '.$date[0].' à '.$time[0].':'.$time[1];

		return $french;
	}

	public static function generer($nbr){
		$string = '';
		$chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		srand((double)microtime()*1000000);
		for ($i=0; $i<$nbr; $i++){
			$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
	}

}

?>