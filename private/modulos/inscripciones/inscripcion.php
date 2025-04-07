<?php
include('../../Config/Config.php');
extract($_REQUEST); //extrae todas las variables

$inscripciones = $inscripciones ?? '[]';
$accion = $accion ?? '';
$class_inscripciones = new inscripciones($conexion);
print_r(json_encode($class_inscripciones->recibir_datos($inscripciones)));
class inscripciones {
    private $datos = [], $db, $respuesta=['msg'=>'ok'];

    public function __construct($conexion) {
        $this->db = $conexion;
    }
    public function recibir_datos($inscripciones){
        global $accion;
        if($accion == 'consultar'){
            return $this->administrar_inscripciones();
        }else{
            $this->datos = json_decode($inscripciones, true);
            return $this->validar_datos();
        }
    }
    private function validar_datos(){
        if( empty($this->datos['alumno']) ){
            $this->respuesta['msg'] = 'El alumno es requerido';
        }
        if( empty($this->datos['fecha']) ){
            $this->respuesta['msg'] = 'La fecha es requerida';
        }
        if( empty($this->datos['materia']) ){
            $this->respuesta['msg'] = 'La materia es requerida';
        }
        return $this->administrar_inscripciones();
    }
    private function administrar_inscripciones(){
        global $accion;
        if($this->respuesta['msg'] == 'ok'){
            $this->db->consultasql('INSERT INTO bitacora(idDocumento, hash, data, fecha_hora) VALUES(?, ?, ?, ?)', 
            $this->datos['codigo_transaccion'], $this->datos['hash'], json_encode($this->datos), date('Y-m-d H:i:s') );
            
            if($accion == 'nuevo'){
                return $this->db->consultasql('INSERT INTO inscripciones(alumno,fecha,materia,codigo_transaccion, hash) VALUES(?, ?, ?, ?, ?)', 
                    $this->datos['alumno'], $this->datos['fecha'], $this->datos['materia'], 
                    $this->datos['codigo_transaccion'], $this->datos['hash']);
            }else if($accion == 'modificar'){
                return $this->db->consultasql('UPDATE inscripciones SET alumno=?, fecha=?, materia=?, hash=? WHERE codigo_transaccion = ?', 
                $this->datos['alumno'], $this->datos['fecha'], $this->datos['materia'], $this->datos['hash'], $this->datos['codigo_transaccion']);
            }else if($accion == 'eliminar'){
                return $this->db->consultasql('DELETE FROM inscripciones WHERE codigo_transaccion = ?', $this->datos['codigo_transaccion']);
            }else if($accion == 'consultar'){
                $this->db->consultasql('SELECT idInscripcion, alumno, fecha, materia, codigo_transaccion, hash FROM inscripciones');
                return $this->db->obtener_datos();
            }
        }else{
            return $this->respuesta;
        }
    }
}
