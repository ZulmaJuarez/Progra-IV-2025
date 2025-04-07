<?php
include('../../Config/Config.php');
extract($_REQUEST); // extrae todas las variables

$matriculas = $matriculas ?? '[]';
$accion = $accion ?? '';
$class_matriculas = new matriculas($conexion);
print_r(json_encode($class_matriculas->recibir_datos($matriculas)));

class matriculas {
    private $datos = [], $db, $respuesta = ['msg' => 'ok'];

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function recibir_datos($matriculas) {
        global $accion;
        if ($accion == 'consultar') {
            return $this->administrar_matriculas();
        } else {
            $this->datos = json_decode($matriculas, true);
            return $this->validar_datos();
        }
    }

    private function validar_datos() {
        if (empty($this->datos['alumno'])) {
            $this->respuesta['msg'] = 'El alumno es requerido';
        }
        if (empty($this->datos['fecha'])) {
            $this->respuesta['msg'] = 'La fecha es requerida';
        }
        if (empty($this->datos['periodo'])) {
            $this->respuesta['msg'] = 'El periodo es requerido';
        }
        return $this->administrar_matriculas();
    }

    private function administrar_matriculas() {
        global $accion;
        if ($this->respuesta['msg'] == 'ok') {
            switch ($accion) {
                case 'nuevo':
                    // Insertar nueva matrícula
                    return $this->db->consultasql('INSERT INTO matriculas(alumno, fecha, periodo, codigo_transaccion) VALUES(?, ?, ?, ?)', 
                        $this->datos['alumno'], $this->datos['fecha'], $this->datos['periodo'], $this->datos['codigo_transaccion']);
                case 'modificar':
                    // Modificar matrícula existente
                    return $this->db->consultasql('UPDATE matriculas SET alumno=?, fecha=?, periodo=? WHERE codigo_transaccion = ?', 
                        $this->datos['alumno'], $this->datos['fecha'], $this->datos['periodo'], $this->datos['codigo_transaccion']);
                case 'eliminar':
                    // Eliminar matrícula
                    return $this->db->consultasql('DELETE FROM matriculas WHERE codigo_transaccion = ?', $this->datos['codigo_transaccion']);
                case 'consultar':
                    // Consultar todas las matrículas
                    $this->db->consultasql('SELECT idMatricula, alumno, fecha, periodo, codigo_transaccion FROM matriculas');
                    return $this->db->obtener_datos();
                default:
                    $this->respuesta['msg'] = 'Acción no reconocida';
                    return $this->respuesta;
            }
        } else {
            return $this->respuesta;
        }
    }
}
