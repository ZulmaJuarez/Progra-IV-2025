<template>
    <div class="card border-dark mb-3">
        <div class="card-header bg-dark text-white">Registro de Matrícula</div>
        <div class="card-body">
            <div class="row p-1">
                <div class="col-3">Alumno</div>
                <div class="col-6">
                    <select v-model="matricula.alumno" class="form-control">
                        <option disabled value="">Seleccione un alumno</option>
                        <option v-for="alumno in alumnos" :key="alumno.id" :value="alumno.id">
                            {{ alumno.nombre }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="row p-1">
                <div class="col-3">Fecha</div>
                <div class="col-6">
                    <input type="date" v-model="matricula.fecha" class="form-control">
                </div>
            </div>
            <div class="row p-1">
                <div class="col-3">Periodo</div>
                <div class="col-6">
                    <select v-model="matricula.periodo" class="form-control">
                        <option disabled value="">Seleccione un periodo</option>
                        <option>Ciclo I-2025</option>
                        <option>Ciclo II-2025</option>
                        <option>Ciclo I-2026</option>
                    </select>
                </div>
            </div>
            <div class="row p-1">
                <div class="col-12 text-end">
                    <button @click="guardarMatricula" class="btn btn-success">Guardar Matrícula</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import alertify from 'alertifyjs';

export default {
    props: ['forms'],
    data() {
        return {
            alumnos: [],
            matricula: {
                alumno: '',
                fecha: '',
                periodo: ''
            }
        };
    },
    created() {
        this.cargarAlumnos();
    },
    methods: {
        async cargarAlumnos() {
            try {
                const response = await axios.get('/api/alumnos');
                this.alumnos = response.data;
            } catch (error) {
                alertify.error('Error al cargar alumnos');
                console.error(error);
            }
        },
        async guardarMatricula() {
            if (!this.matricula.alumno || !this.matricula.fecha || !this.matricula.periodo) {
                alertify.error("Todos los campos son obligatorios");
                return;
            }

            try {
                await axios.post('/api/matriculas', this.matricula);
                alertify.success("Matrícula guardada exitosamente");
                this.matricula = { alumno: '', fecha: '', periodo: '' };
            } catch (error) {
                alertify.error("Error al guardar matrícula");
                console.error(error);
            }
        }
    }
};
</script>
