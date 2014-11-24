<?php
App::uses('AppModel', 'Model');


class Estadistica extends AppModel {

/**
 * Separa los numeros en un array
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
public function separar_numeros($datos)
{
	return explode("\r\n", $datos);
}

/**
 * Calcula la cantidad de clases
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
public function calcular_clase($datos)
{
	return round(1 + 3.3 * log10(count($datos)), 0);
}

/**
 * Calcula estadisticas de datos sin agrupar
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
public function estadistica_sin_agrupar($datos)
{
	$promedio = $this->promedio($datos);
	$desv_pobla = $this->desviacion($datos);
	$desv_muest = $this->desviacion($datos, true);

	return array(
		'promedio' => $promedio,
		'mediana' => $this->mediana($datos),
		'moda' => $this->moda($datos),
		'rango' => $this->rango($datos),
		'varianza_poblacional' => pow($desv_pobla, 2),
		'varianza_muestral' => pow($desv_muest, 2),
		'desviacion_poblacional' => $desv_pobla,
		'desviacion_muestral' => $desv_muest,
		'cv_poblacional' => $desv_pobla / $promedio * 100,
		'cv_muestral' => $desv_muest / $promedio * 100,
		'cuartiles' => $this->cuartiles($datos),
		'deciles' => $this->deciles($datos),
		'percentiles' => $this->percentiles($datos),
		); 

}

/**
 * Calcula estadisticas para datos agrupados
 * @param  [type] $datos [description]
 * @param  [type] $clase [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
public function estadistica_agrupado($datos, $clase)
{

}

/**
 * Calcula el promedio
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
private function promedio($datos)
{
	return array_sum($datos) / count($datos);

}

/**
 * Calcula la mediana
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
private function mediana($datos)
{
	rsort($datos); 
	$middle = round(count($datos) / 2); 
	return $datos[$middle-1]; 
}

/**
 * Calcula la moda
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
private function moda($datos)
{
	$v = array_count_values($datos); 
	arsort($v); 
	foreach ($v as $k => $v) {
		return $k;
	} 
}

/**
 * Calcula un percentil
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
private function pecentil($data,$percentile)
{

	if( 0 < $percentile && $percentile < 1 ) { 
		$p = $percentile; 
	}else if( 1 < $percentile && $percentile <= 100 ) { 
		$p = $percentile * .01; 
	}else { 
		return ""; 
	} 
	$count = count($data); 
	$allindex = ($count-1)*$p; 
	$intvalindex = intval($allindex); 
	$floatval = $allindex - $intvalindex; 
	sort($data); 
	if(!is_float($floatval)){ 
		$result = $data[$intvalindex]; 
	}else { 
		if($count > $intvalindex+1) 
			$result = $floatval*($data[$intvalindex+1] - $data[$intvalindex]) + $data[$intvalindex]; 
		else 
			$result = $data[$intvalindex]; 
	} 
	return $result; 
}

/**
 * Calcula cuartiles
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
private function cuartiles($datos)
{
	for ($cuartil = 1, $percentil = 25; $percentil != 100; $cuartil++, $percentil += 25) {
		$salida[] = array(
			'cuartil' => $cuartil,
			'valor' => $this->pecentil($datos, $percentil)
			);
	}
	return $salida;

}

/**
 * Calcula deciles
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
private function deciles($datos)
{
	for ($decil = 1, $percentil = 10; $percentil != 100; $decil++, $percentil += 10) {
		$salida[] = array(
			'decil' => $decil,
			'valor' => $this->pecentil($datos, $percentil)
			);
	}
	return $salida;
}

/**
 * Calcula percentiles
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
private function percentiles($datos)
{
	for ($percentil = 1; $percentil != 100; $percentil ++) {
		$salida[] = array(
			'percentil' => $percentil,
			'valor' => $this->pecentil($datos, $percentil)
			);
	}
	return $salida;
}

/**
 * Calcula desviacion estandard
 * @param  [type]  $a      [description]
 * @param  boolean $sample [description]
 * @return [type]          [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
private function desviacion($a, $sample = false) {
	$n = count($a);
	if ($n === 0) {
		trigger_error("The array has zero elements", E_USER_WARNING);
		return false;
	}
	if ($sample && $n === 1) {
		trigger_error("The array has only 1 element", E_USER_WARNING);
		return false;
	}
	$mean = array_sum($a) / $n;
	$carry = 0.0;
	foreach ($a as $val) {
		$d = ((double) $val) - $mean;
		$carry += $d * $d;
	};
	if ($sample) {
		--$n;
	}
	return sqrt($carry / $n);
}

/**
 * Calcula rango recorrido
 * @param  [type] $datos [description]
 * @return [type]        [description]
 * @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
 */
private function rango($datos)
{
	sort($datos); 
	$sml = $datos[0]; 
	rsort($datos); 
	$lrg = $datos[0]; 
	return $lrg - $sml; 
}


}
