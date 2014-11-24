<?php
App::uses('AppController', 'Controller');

/**
* 
*/
class EstadisticasController extends AppController {

/**
* [index description]
* @return [type] [description]
* @author Carlos Vásquez <carlos.vasquez@ideauno.cl>
*/
public function index()
{

	if (! empty($this->request->data)) {
		
		// separa los numeros
	    $datos = $this->Estadistica->separar_numeros($this->request->data['Estadisticas']['datos']);

	    // se ordena
	    sort($datos);

	    // si hay clase la coloca
	    if ($this->request->data['Estadisticas']['clases']) {
	    	$clases = (int)$this->request->data['Estadisticas']['clases'];
	    } else { // si no la calcula
	    	$clases = $this->Estadistica->calcular_clase($datos);
	    }

	    $resultado['sin_agrupar'] = $this->Estadistica->estadistica_sin_agrupar($datos);
	    $resultado['agrupados'] = $this->Estadistica->estadistica_agrupado($datos, $clases);


	    $this->set('resultado', $resultado);

	    $this->render('resultados');
	}
	

}


}
