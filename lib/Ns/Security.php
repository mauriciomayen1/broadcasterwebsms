<?php

Class Ns_Security 
{
	function validarHorarioAcceso($FechaActivacion,$FechaExpiracion,$DiasAcceso,$HorarioInicio,$HorarioFinal){
	$FechaActivacion=explode("-",$FechaActivacion);
	$FechaExpiracion=explode("-",$FechaExpiracion);
	$Calendario= new Date_Calc;
		//Verificar que el usuario este accesando en un dia dentro de 
		//la fecha de activacion y la fecha de expiracion
		if( ($Calendario->isPastDate($FechaActivacion[2],$FechaActivacion[1],$FechaActivacion[0]) 
		&& ($Calendario->isFutureDate($FechaExpiracion[2],$FechaExpiracion[1],$FechaExpiracion[0])))
		|| ($Calendario->compareDates($FechaActivacion[2],$FechaActivacion[1],$FechaActivacion[0],$Calendario->getYear(), $Calendario->getMonth(),$Calendario->getDay()) == 0)
		|| ($Calendario->compareDates($FechaExpiracion[2],$FechaExpiracion[1],$FechaExpiracion[0],$Calendario->getYear(), $Calendario->getMonth(),$Calendario->getDay())) == 0) {
		//echo "<br>Fecha de Acceso Valida";
			//Verificar dia de la semana
			$Dias=explode(",",$DiasAcceso);
			if( in_array(date("w"),$Dias) ){
				//echo "<br>Dia de Acceso Valido";
				//Verificar hora de acceso
				$HorarioInicio=explode(":",$HorarioInicio);
				$HorarioFinal=explode(":",$HorarioFinal);
				$HoraLocal=explode(":",date("H:i"));
				
				$LimiteInf=($HorarioInicio[0]*60)+($HorarioInicio[1]);
				//echo "<br>Inf:".$LimiteInf."<br>";
				$LimiteSup=($HorarioFinal[0]*60)+($HorarioFinal[1]);
				//echo "<br>Sup:".$LimiteSup."<br>";
				$HoraLocal=($HoraLocal[0]*60)+($HoraLocal[1]);
				//echo "  Hora local".$HoraLocal."<br>";
				
				if( $LimiteInf <= $HoraLocal && $HoraLocal <= $LimiteSup ){
					//echo "<br>Horario de Acceso Correcto";
					return true;
				} else{
					//echo "<br>Horario de Acceso INCorrecto";
				}
			} else{
				//echo "<br>Dia de Acceso Invalido";
			}
		}else{
			//echo "<br>Fecha de Acceso INCorrecto";
			return false;
		}
	}
	
	//{{{ function validarIPRemota($TablasIP){
	
	function validarIPRemota($TablasIP)
	{
		if ($TablasIP){
			$IpRemota = $_SERVER['REMOTE_ADDR'];
			$IpRemotaExplode = explode(".",$IpRemota);
			
			$TablasIpExplode = explode(",",$TablasIP);
			for ($i=0; $i < sizeof($TablasIpExplode); $i++){
				$IpExplode	 = explode(".",$TablasIpExplode[$i]);
				if( $this->validarIP($TablasIpExplode[$i]) ){
					$IPValida[$i] = $this->CompararIP($IpExplode,$IpRemotaExplode);
				}else{
					$IPValida[$i] = 0;
				}
			}

			if (($IPValida[0] == 1) || ($IPValida[1] == 1) ){
				return true;
			} else{
				return false;
			}
		} else{
			return false;
		}
	}
	//}}}
	
	//{{{ function validarIP($IP)
	function validarIP($IP)
    {
        $oct = explode('.', $IP);
        if (count($oct) != 4) {
            return false;
        }
        for ($i = 0; $i < 4; $i++) {
            if (!is_numeric($oct[$i])) {
                return false;
            }
            if ($oct[$i] < 0 || $oct[$i] > 255) {
                return false;
            }
        }
        return true;
    }
	//}}}


	//{{{ function CompararIP($IP,$IPRemota){
	function CompararIP($IpExplode,$IpRemotaExplode)
	{
		for( $i=0; $i < sizeof($IpExplode); $i++ ){
				if( $IpExplode[$i] == $IpRemotaExplode[$i]){
					$IPValida[$i] = 1;
				} else{
						if ($IpExplode[$i] == 0) {
							$IPValida[$i] = 1;
						}else{
							$IPValida[$i] = 0;
						}
				}
		}
		
		$ip_primaria_ok	= 0;
		
		if ($IPValida[3] == 1) {
			if (($IPValida[2] == 1) && ($IPValida[1] == 1) && ($IPValida[0] == 1)){
				$ip_primaria_ok = 1;
			}else{
				$ip_primaria_ok = 0;
			}
		}
		if ($IPValida[2] == 1) {
			if (($IPValida[1] == 1) && ($IPValida[0] == 1)){
				 $ip_primaria_ok = 1;
			}else{
				$ip_primaria_ok = 0;
			}
		}
		
		if ($IPValida[1] == 1) {
			if ($IPValida[0] == 1){
				 $ip_primaria_ok = 1;
			}else{
				$ip_primaria_ok = 0;
			}
		}
		if ($IPValida[0] == 1) {
			if (($IPValida[1] == 1) && ($IPValida[2] == 1) && ($IPValida[3] == 1)){
				$ip_primaria_ok = 1;
			}else{
				$ip_primaria_ok = 0;
			}
		}


		if ($ip_primaria_ok == 1) {
			$ip_ok = 1;
		} else {
			$ip_ok = 0;
 	  }
		return $ip_ok;
		
	}
	//}}}

} // fin clase Ns_Security

?>