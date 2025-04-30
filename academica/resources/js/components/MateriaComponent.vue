<template>
    <div class="row">
        <div class="col-6">
            <form id="frmMateria" name="frmMateria" @submit.prevent="guardarMateria">
                <div class="card border-dark mb-3">
                    <div class="card-header bg-dark text-white">Registro de Materias</div>
                    <div class="card-body">
                        <div class="row p-1">
                            <div class="col-3 col-md-2">CÓDIGO</div>
                            <div class="col-9 col-md-4">
                                <input required v-model="materia.codigo" type="text" name="txtCodigoMateria" id="txtCodigoMateria" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-3 col-md-2">NOMBRE</div>
                            <div class="col-9 col-md-6">
                                <input required pattern="[A-Za-zñÑáéíóú ]{3,150}" v-model="materia.nombre" type="text" name="txtNombreMateria" id="txtNombreMateria" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-3 col-md-2">UV</div>
                            <div class="col-9 col-md-4">
                                <input required type="number" min="1" max="10" v-model="materia.uv" name="txtUVMateria" id="txtUVMateria" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-dark text-center">
                        <input type="submit" value="Guardar" class="btn btn-primary"> 
                        <input type="reset" value="Nuevo" class="btn btn-warning">
                        <input type="button" @click="buscarMateria" value="Buscar" class="btn btn-info">
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

export default {
    props: ['forms'],
    data() {
        return {
            accion: 'nuevo',
            materia: {
                codigo: '',
                nombre: '',
                uv: '',
                codigo_transaccion: uuidv4()
            },
        };
    },
    methods: {
        buscarMateria() {
            this.forms.buscarMateria.mostrar = !this.forms.buscarMateria.mostrar;
            // Emitimos el evento 'buscar' con los parámetros necesarios
            this.$emit('buscar', 'materia', 'listarMaterias');
        },
        modificarMateria(materia) {
            this.accion = 'modificar';
            this.materia = { ...materia };
        },
        async guardarMateria() {
            let materia = { ...this.materia };
            try {
                if (this.accion === 'nuevo') {
                    const response = await axios.post('/api/materias', materia);
                    if (response.data.success) {
                        alertify.success('Materia guardada exitosamente');
                        this.nuevaMateria();
                        this.$emit('buscar');
                    } else {
                        alertify.error('Error al guardar materia');
                    }
                } else {
                    const response = await axios.put(`/api/materias/${materia.codigo}`, materia);
                    if (response.data.success) {
                        alertify.success('Materia modificada exitosamente');
                        this.nuevaMateria();
                        this.$emit('buscar');
                    } else {
                        alertify.error('Error al modificar materia');
                    }
                }
            } catch (error) {
                console.error(error);
                alertify.error('Hubo un error al realizar la acción');
            }
        },
        async eliminarMateria(materia) {
            try {
                const response = await axios.delete(`/api/materias/${materia.codigo}`);
                if (response.data.success) {
                    alertify.success(`Materia ${materia.nombre} eliminada`);
                    this.$emit('buscar');
                } else {
                    alertify.error('Error al eliminar materia');
                }
            } catch (error) {
                console.error(error);
                alertify.error('Hubo un error al eliminar la materia');
            }
        },
        nuevaMateria() {
            this.accion = 'nuevo';
            this.materia = {
                codigo: '',
                nombre: '',
                uv: '',
                codigo_transaccion: uuidv4()
            };
        }
    }
};
</script>
