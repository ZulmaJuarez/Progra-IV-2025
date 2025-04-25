<template>
    <div class="row">
        <div class="col-6">
            <form id="frmAlumno" name="frmAlumno" @submit.prevent="guardarAlumno">
                <div class="card border-dark mb-3">
                    <div class="card-header bg-dark text-white">Registro de Alumnos</div>
                    <div class="card-body">
                        <div class="row p-1">
                            <div class="col-3 col-md-3">CÓDIGO</div>
                                <div class="col-9 col-md-4">
                                    <input required v-model="alumno.codigo" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">NOMBRE</div>
                                <div class="col-9 col-md-6">
                                    <input required pattern="[A-Za-zñÑáéíóú ]{3,150}" v-model="alumno.nombre" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">DIRECCIÓN</div>
                                <div class="col-9 col-md-8">
                                    <input required v-model="alumno.direccion" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">MUNICIPIO</div>
                                <div class="col-9 col-md-4">
                                    <input required v-model="alumno.municipio" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">DEPARTAMENTO</div>
                                <div class="col-9 col-md-4">
                                    <input required v-model="alumno.departamento" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">TELÉFONO</div>
                                <div class="col-9 col-md-4">
                                    <input v-model="alumno.telefono" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">EMAIL</div>
                                <div class="col-9 col-md-6">
                                    <input v-model="alumno.email" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">FECHA DE NACIMIENTO</div>
                                <div class="col-9 col-md-4">
                                    <input v-model="alumno.fecha_nacimiento" type="date" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-3 col-md-3">SEXO</div>
                                <div class="col-9 col-md-4">
                                    <select v-model="alumno.sexo" class="form-control">
                                        <option value="M">M</option>
                                        <option value="F">F</option>
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
</template>
<script>
    import axios from 'axios';
    import alertify from 'alertifyjs';
    import { v4 as uuidv4 } from 'uuid';
    import CryptoJS from 'crypto-js';
    export default {
        props: ['forms'],
        data() {
            return {
                accion: 'nuevo',
                alumno : {
                    codigo: '',
                    nombre: '',
                    direccion: '',
                    municipio: '',
                    departamento: '',
                    telefono: '',
                    email: '',
                    fecha_nacimiento: '',
                    sexo: '',
                    codigo_transaccion: uuidv4()
                },
            }
        },
        methods: {
            buscarAlumno() {
                this.forms.buscarAlumno.mostrar = !this.forms.buscarAlumno.mostrar;
                this.$emit('buscar');
            },
            modificarAlumno(alumno) {
                this.accion = 'modificar';
                this.alumno = {...alumno};
            },
            guardarAlumno() {
                let alumno = {...this.alumno},
                    metodo="POST";
                alumno.hash = CryptoJS.SHA256(JSON.stringify({
                    codigo: alumno.codigo,
                    nombre: alumno.nombre,
                    direccion: alumno.direccion,
                    municipio: alumno.municipio,
                    departamento: alumno.departamento,
                    telefono: alumno.telefono,
                    email: alumno.email,
                    fecha_nacimiento: alumno.fecha_nacimiento,
                    sexo: alumno.sexo
                })).toString();
                db.alumnos.put(alumno);
                if( this.accion=='modificar' ){
                    metodo = "PUT";
                }
                axios ({
                    method: metodo,
                    url: `alumno`,
                    data: alumno,
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if( response.data.msg != 'ok' ){
                        alertify.error(response.data.msg);
                    }else{
                        this.nuevoAlumno();
                        this.$emit('buscar');
                    }
                }).catch(error => {
                    alertify.error('Error al guardar el alumno: ' + error);
                });
            },
            nuevoAlumno() {
                this.accion = 'nuevo';
                this.alumno = {
                    codigo: '',
                    nombre: '',
                    direccion: '',
                    municipio: '',
                    departamento: '',
                    telefono: '',
                    email: '',
                    fecha_nacimiento: '',
                    sexo: '',
                    codigo_transaccion: uuidv4()
                };
            }
        },
    }
</script>