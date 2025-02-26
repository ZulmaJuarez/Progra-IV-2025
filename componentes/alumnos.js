    
 const alumno = {
    props: ['forms'],
    data() {
        return {
            accion: 'nuevo',
            idAlumno: '',
            codigo: '',
            nombre: '',
            direccion: '',
            municipio: '',
            departamento: '',
            telefono: '',
            email: '',
            fecha_nacimiento: '',
            sexo: '',
        }
    },
    methods: {
        buscarAlumno() {
            this.forms.buscarAlumno.mostrar = !this.forms.buscarAlumno.mostrar;
            this.$emit('buscar');
        },
        modificarAlumno(alumno) {
            this.accion = 'modificar';
            this.idAlumno = alumno.idAlumno;
            this.codigo = alumno.codigo;
            this.nombre = alumno.nombre;
            this.direccion = alumno.direccion;
            this.municipio = alumno.municipio;
            this.departamento = alumno.departamento;
            this.telefono = alumno.telefono;
            this.email = alumno.email;
            this.fecha_nacimiento = alumno.fecha_nacimiento;
            this.sexo = alumno.sexo;
        },
        guardarAlumno() {
            let alumno = {
                codigo: this.codigo,
                nombre: this.nombre,
                direccion: this.direccion,
                municipio: this.municipio,
                departamento: this.departamento,
                telefono: this.telefono,
                email: this.email,
                fecha_nacimiento: this.fecha_nacimiento,
                sexo: this.sexo
            };
            if (this.accion == 'modificar') {
                alumno.idAlumno = this.idAlumno;
            }
            db.alumnos.put(alumno);
            this.nuevoAlumno();
        },
        nuevoAlumno() {
            this.accion = 'nuevo';
            this.idAlumno = '';
            this.codigo = '';
            this.nombre = '';
            this.direccion = '';
            this.municipio = '';
            this.departamento = '';
            this.telefono = '';
            this.email = '';
            this.fecha_nacimiento = '';
            this.sexo = '';
        }
    },
    template: `
        <div class="row">
            <div class="col-6">
                <form id="frmAlumno" name="frmAlumno" @submit.prevent="guardarAlumno">
                    <div class="card border-dark mb-3">
                        <div class="card-header bg-dark text-white">Registro de Alumnos</div>
                        <div class="card-body">
                            <div class="row p-1">
                                <div class="col-3 col-md-3">CODIGO</div>
                                <div class="col-9 col-md-4">
                                    <input required v-model="codigo" type="text" name="txtCodigoAlumno" id="txtCodigoAlumno" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">NOMBRE</div>
                                <div class="col-9 col-md-6">
                                    <input required pattern="[A-Za-zñÑáéíóú ]{3,150}" v-model="nombre" type="text" name="txtNombreAlumno" id="txtNombreAlumno" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">DIRECCION</div>
                                <div class="col-9 col-md-6">
                                    <input required v-model="direccion" type="text" name="txtDireccionAlumno" id="txtDireccionAlumno" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">MUNICIPIO</div>
                                <div class="col-9 col-md-4">
                                    <input required v-model="municipio" type="text" name="txtMunicipioAlumno" id="txtMunicipioAlumno" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">DEPARTAMENTO</div>
                                <div class="col-9 col-md-4">
                                    <input required v-model="departamento" type="text" name="txtDepartamentoAlumno" id="txtDepartamentoAlumno" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">TELEFONO</div>
                                <div class="col-9 col-md-4">
                                    <input v-model="telefono" type="text" name="txtTelefonoAlumno" id="txtTelefonoAlumno" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">EMAIL</div>
                                <div class="col-9 col-md-6">
                                    <input v-model="email" type="text" name="txtEmailAlumno" id="txtEmailAlumno" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">FECHA DE NACIMIENTO</div>
                                <div class="col-9 col-md-4">
                                    <input v-model="fecha_nacimiento" type="date" name="txtFechaNacimientoAlumno" id="txtFechaNacimientoAlumno" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">SEXO</div>
                                <div class="col-9 col-md-4">
                                    <select v-model="sexo" class="form-select">
                                        <option value="M">MASCULINO</option>
                                        <option value="F">FEMENINO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-dark text-center">
                            <input type="submit" value="Guardar" class="btn btn-primary"> 
                            <input type="reset" value="Nuevo" class="btn btn-warning">
                            <input type="button" @click="buscarAlumno" value="Buscar" class="btn btn-info">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `
};