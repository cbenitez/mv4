<?php
function monthName($n){
	$monthName = array(
		1 => "Enero",
		2 => "Febrero",
		3 => "Marzo",
		4 => "Abril",
		5 => "Mayo",
		6 => "Junio",
		7 => "Julio",
		8 => "Agosto",
		9 => "Setiembre",
		10 => "Octubre",
		11 => "Noviembre",
		12 => "Diciembre"
	);
	return $monthName[$n];
}

function dayName($d){
	$dayName = array(
		"Domingo",
		"Lunes",
		"Martes",
		"Miércoles",
		"Jueves",
		"Viernes",
		"Sábado",
	);

	return $dayName[$d];
}

function dateFormat($format,$time=null){
	$time = $time == null ? time() : $time;

	$formats = array(
		'{d}',
		'{dd}',
		'{ddd}',
		'{dddd}',
		'{m}',
		'{mm}',
		'{mmm}',
		'{mmmm}',
		'{yy}',
		'{yyyy}',
		'{h}',
		'{H}',
		'{i}',
		'{s}'
	);

	$replace = array(
		date("j", $time),
		date("d", $time),
		substr(dayName(date("w", $time)),0,3),
		dayName(date("w", $time)),
		date("n", $time),
		date("m", $time),
		substr(monthName(date("n",$time)),0,3),
		monthName(date("n",$time)),
		date("y", $time),
		date("Y", $time),
		date("h", $time),
		date("H", $time),
		date("i", $time),
		date("s", $time)
	);

	return str_replace($formats, $replace, $format);
}

function dateDifference($start, $end="NOW"){
	 $sdate = strtotime($start);
     $edate = strtotime($end);

        $time = $edate - $sdate;
        if($time>=0 && $time<=59) {
                // segundos
                //$timeshift = $time.' segundos';
				$timeshift = array("sec" => $time);

        } elseif($time>=60 && $time<=3599) {
                // Minutos + Segundos
                $pmin = ($edate - $sdate) / 60;
                $premin = explode('.', $pmin);

                $presec = $pmin-$premin[0];
                $sec = $presec*60;

                //$timeshift = $premin[0].' min '.round($sec,0).' seg ';
				$timeshift = array("min" => $premin[0], "sec" => round($sec,0));

        } elseif($time>=3600 && $time<=86399) {
                // Horas + Minutos
                $phour = ($edate - $sdate) / 3600;
                $prehour = explode('.',$phour);

                $premin = $phour-$prehour[0];
                $min = explode('.',$premin*60);

                $presec = '0.'.$min[1];
                $sec = $presec*60;

                //$timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';
				$timeshift = array("hour" => $prehour[0], "min" => $min[0], "sec" => round($sec,0));

        } elseif($time>=86400) {
                // Dias + Horas + Minutos
                $pday = ($edate - $sdate) / 86400;
                $preday = explode('.',$pday);

                $phour = $pday-$preday[0];
                $prehour = explode('.',$phour*24);

                $premin = ($phour*24)-$prehour[0];
                $min = explode('.',$premin*60);

                $presec = '0.'.$min[1];
                $sec = $presec*60;

                //$timeshift = $preday[0].' dias '.$prehour[0].' hs '.$min[0].' min '.round($sec,0).' seg ';
				$timeshift = array("days" => $preday[0], "hour" => $prehour[0], "min" => $min[0], "sec" => round($sec,0));

        }
        return $timeshift;
}
?>
