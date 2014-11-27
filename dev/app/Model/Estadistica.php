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
	$lista = explode("\r\n", $datos);

	foreach ($lista as $key => &$numero) {
		$numero = trim($numero);
		if (!is_numeric($numero)) {
			unset($lista[$key]);
		}
	}
	return $lista;
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
	$primer_elemento = $temp_primer_elemento = current($datos);
	$ultimo_elemento = end($datos);

	$amplitud = ($ultimo_elemento - $primer_elemento + 1) / $clase;
	
	$tabla_clases = array();
	
	$suma_yifi = 0;
	for ($i = 0; $i != $clase; $i++) {
		$nro_clase = $i + 1;
		$limite_inferior = $temp_primer_elemento;
		$limite_superior = $temp_primer_elemento + $amplitud;
		$yi = ($limite_inferior + $limite_superior ) / 2;

		$fi = 0;
		foreach ($datos as $dato) {
			if ($dato >= $limite_inferior && $dato < $limite_superior) {
				$fi++;
			}
		}
		$hi = $fi / count($datos) * 100;

		$ffi = 0;
		foreach ($datos as $dato) {
			if ($dato < $limite_superior) {
				$ffi++;
			}
		}
		$hhi = $ffi / count($datos) * 100;


		$tabla_clases[] = array(
			'nro_clase' => $nro_clase,
			'limite_inferior' => $limite_inferior,
			'limite_superior' => $limite_superior,
			'yi' => $yi,
			'fi' => $fi,
			'hi' => $hi,
			'ffi' => $ffi,
			'hhi' => $hhi,
			'yifi' => $yi * $fi,
			);

		$suma_yifi += $yi * $fi;

		$temp_primer_elemento = $limite_superior;
	}

	$cosas['promedio'] = $suma_yifi / count($datos);

	$sum_ultima = 0;
	foreach ($tabla_clases as &$tb) {
		$tb['ultima'] = $tb['fi'] * pow(($tb['yi'] - $cosas['promedio']), 2);
		$sum_ultima += $tb['ultima'];
	}

	$cosas['clase'] = $clase;
	$cosas['amplitud'] = $amplitud;

	$cosas['varianza_poblacional'] = $sum_ultima / count($datos);
	$cosas['varianza_muestral'] = $sum_ultima / (count($datos) - 1);
	$cosas['desviacion_poblacional'] = sqrt($cosas['varianza_poblacional']);
	$cosas['desviacion_muestral'] = sqrt($cosas['varianza_muestral']);
	$cosas['cv_poblacional'] = $cosas['desviacion_poblacional'] / $cosas['promedio'] * 100;
	$cosas['cv_muestral'] = $cosas['desviacion_muestral'] / $cosas['promedio'] * 100;
	$cosas['rango'] = $this->rango($datos);
	$cosas['tabla'] = $tabla_clases;


	if(count($tabla_clases) > 3) {


		$percentiles = array();
		for ($i = 1; $i != 99; $i++) {
			$p = $i / 100;
			$N = count($datos);
			$pN = $p * $N;

			// buscar la clase
			foreach ($cosas['tabla'] as $key => $datos_clase) {
				if ($key == 0) continue;

				// encuentra la clase a la que pertenece
				if ($datos_clase['ffi'] >= $pN) {
					if ($datos_clase['fi'] == 0) break;
					$anterior = $key - 1;

					$v = $datos_clase['limite_inferior'] + (($pN - $cosas['tabla'][$anterior]['ffi']) / $datos_clase['fi']) * $amplitud;
					$percentiles[] = array(
						'percentil' => $i,
						'valor' => $v,
						);
					
					break;

				}
			}
		}

		$deciles = array();
		for ($i = 10; $i != 100; $i += 10) {
			$p = $i / 100;
			$N = count($datos);
			$pN = $p * $N;

			// buscar la clase
			foreach ($cosas['tabla'] as $key => $datos_clase) {
				if ($key == 0) continue;

				// encuentra la clase a la que pertenece
				if ($datos_clase['ffi'] >= $pN) {
					if ($datos_clase['fi'] == 0) break;
					$anterior = $key - 1;

					$v = $datos_clase['limite_inferior'] + (($pN - $cosas['tabla'][$anterior]['ffi']) / $datos_clase['fi']) * $amplitud;
					$deciles[] = array(
						'decil' => $i,
						'valor' => $v,
						);
					
					break;

				}
			}
		}

		$cuartiles = array();
		for ($i = 25; $i != 100; $i += 25) {
			$p = $i / 100;
			$N = count($datos);
			$pN = $p * $N;

			// buscar la clase
			foreach ($cosas['tabla'] as $key => $datos_clase) {
				if ($key == 0) continue;

				// encuentra la clase a la que pertenece
				if ($datos_clase['ffi'] >= $pN) {
					if ($datos_clase['fi'] == 0) break;
					$anterior = $key - 1;

					$v = $datos_clase['limite_inferior'] + (($pN - $cosas['tabla'][$anterior]['ffi']) / $datos_clase['fi']) * $amplitud;
					$cuartiles[] = array(
						'cuartil' => $i,
						'valor' => $v,
						);
					
					break;

				}
			}
		}

		$cosas['percentiles'] = $percentiles;
		$cosas['cuartiles'] = $cuartiles;
		$cosas['deciles'] = $deciles;

		$intervalo_modal = 0;
		foreach ($cosas['tabla'] as $key => $datos_clase) {
			if ($datos_clase['fi'] > $intervalo_modal) {
				$intervalo_modal = $datos_clase['fi'];
				$llave = $key;
			}
		}

		if(isset($cosas['tabla'][$llave]['fi']) && isset($cosas['tabla'][$llave+1]['fi']) &&isset($cosas['tabla'][$llave-1]['fi'])) {

		$m_fi = $cosas['tabla'][$llave]['fi'];
		$m_fi_ant = $cosas['tabla'][$llave-1]['fi'];
		$m_fi_sig = $cosas['tabla'][$llave+1]['fi'];

		$cosas['moda'] = $cosas['tabla'][$llave]['limite_inferior'] + ($m_fi - $m_fi_ant) / (($m_fi - $m_fi_ant)+($m_fi - $m_fi_sig)) * $amplitud;

		}
		


		// mediana
		$p = 50 / 100;
			$N = count($datos);
			$pN = $p * $N;

			// buscar la clase
			foreach ($cosas['tabla'] as $key => $datos_clase) {
				if ($key == 0) continue;

				// encuentra la clase a la que pertenece
				if ($datos_clase['ffi'] >= $pN) {
					if ($datos_clase['fi'] == 0) break;
					$anterior = $key - 1;

					$cosas['mediana'] = $datos_clase['limite_inferior'] + (($pN - $cosas['tabla'][$anterior]['ffi']) / $datos_clase['fi']) * $amplitud;
					
					
					break;

				}
			}
		}
	return $cosas;

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
