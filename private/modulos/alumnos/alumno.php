<?php
include('../../Config/Config.php');
extract($_REQUEST); //extrae todas las variables

$alumnos = $alumnos ?? '[]';
$accion = $accion ?? '';
$class_alumnos = new alumnos($conexion);
print_r(json_encode($class_alumnos->recibir_datos($alumnos)));
class alumnos {
    private $datos = [], $db, $respuesta=['msg'=>'ok'];

    public function __construct($conexion) {
        $this->db = $conexion;
    }
    public function recibir_datos($alumnos){
        global $accion;
        if($accion == 'consultar'){
            return $this->administrar_alumnos();
        }else{
            $this->datos = json_decode($alumnos, true);
            return $this->validar_datos();
        }
    }
    private function validar_datos(){
        if( empty($this->datos['codigo']) ){
            $this->respuesta['msg'] = 'El código es requerido';
        }
        if( empty($this->datos['nombre']) ){
            $this->respuesta['msg'] = 'El nombre es requerido';
        }
        if( empty($this->datos['direccion']) ){
            $this->respuesta['msg'] = 'La dirección es requerida';
        }
        if( empty($this->datos['municipio']) ){
                $this->respuesta['msg'] = 'El municipio es requerido';
        }
        if( empty($this->datos['departamento']) ){
            $this->respuesta['msg'] = 'El departamento es requerido';
        }
        if( empty($this->datos['telefono']) ){
            $this->respuesta['msg'] = 'El teléfono es requerido';
        }
        if( empty($this->datos['email']) ){
            $this->respuesta['msg'] = 'El email es requerido';
        }
        if( empty($this->datos['fecha_nacimiento']) ){
            $this->respuesta['msg'] = 'La fecha de nacimiento es requerido';
        }
        if( empty($this->datos['sexo']) ){
            $this->respuesta['msg'] = 'El sexo es requerido';
        }
        return $this->administrar_alumnos();
    }
    private function administrar_alumnos(){
        global $accion;
        if (!isset($this->datos['hash'])) {
            $this->datos['hash'] = md5(uniqid(rand(), true)); // Genera un hash único
        }    
        if($this->respuesta['msg'] == 'ok'){
            $this->db->consultasql('INSERT INTO bitacora(idDocumento, hash, data, fecha_hora) VALUES(?, ?, ?, ?)', 
            $this->datos['codigo_transaccion'], $this->datos['hash'], json_encode($this->datos), date('Y-m-d H:i:s') );
            
            if($accion == 'nuevo'){
                return $this->db->consultasql('INSERT INTO alumnos(codigo,nombre,direccion, municipio,departamento,telefono,email, fecha_nacimiento,sexo,codigo_transaccion, hash) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
                    $this->datos['codigo'], $this->datos['nombre'], $this->datos['direccion'], 
                    $this->datos['municipio'], $this->datos['departamento'],
                    $this->datos['telefono'], $this->datos['email'],
                    $this->datos['fecha_nacimiento'], $this->datos['sexo'], $this->datos['codigo_transaccion'], $this->datos['hash']);
            }else if($accion == 'modificar'){
                return $this->db->consultasql('UPDATE alumnos SET codigo=?,nombre=?,direccion=?, municipio=?,departamento=?,telefono=?,email=?, fecha_nacimiento=?,sexo=?, hash=? WHERE codigo_transaccion = ?', 
                $this->datos['codigo'], $this->datos['nombre'], $this->datos['direccion'], $this->datos['municipio'], $this->datos['departamento'], $this->datos['telefono'], 
                    $this->datos['email'], $this->datos['fecha_nacimiento'], $this->datos['sexo'], $this->datos['hash'], $this->datos['codigo_transaccion']);
            }else if($accion == 'eliminar'){
                return $this->db->consultasql('DELETE FROM alumnos WHERE codigo_transaccion = ?', $this->datos['codigo_transaccion']);
            }else if($accion == 'consultar'){
                $this->db->consultasql('SELECT idAlumno, codigo, nombre, direccion, municipio, departamento, telefono, email, fecha_nacimiento, sexo, codigo_transaccion, hash FROM alumnos');
                return $this->db->obtener_datos();
            }
        }else{
            return $this->respuesta;
        }
    }
}
