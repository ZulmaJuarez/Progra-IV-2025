<template>
    <div class="card border-dark mb-3">
            <div class="card-header bg-dark text-white">Buscar Alumno</div>
            <div class="card-body">
                <div class="row p-1">
                    <div class="col-8">
                        <input v-model="busqueda" type="text" class="form-control" placeholder="Ingrese nombre o código">
                    </div>
                    <div class="col-4">
                        <button @click="filtrarAlumnos" class="btn btn-primary w-100"> Buscar</button>
                    </div>
                </div>
                <ul class="list-group mt-2" v-if="resultados.length">
                    <li v-for="alumno in resultados" :key="alumno.idAlumno" 
                        class="list-group-item list-group-item-action" 
                        @click="seleccionar(alumno)">
                        {{ alumno.nombre }} - {{ alumno.codigo }}
                    </li>
                </ul>
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
            busqueda: "",
            resultados: []
        };
    },
    methods: {
        async filtrarAlumnos() {
            const alumnos = await db.alumnos.toArray();
            this.resultados = alumnos.filter(alumno => 
                alumno.nombre.toLowerCase().includes(this.busqueda.toLowerCase()) ||
                alumno.codigo.toLowerCase().includes(this.busqueda.toLowerCase())
            );
        },
        seleccionar(alumno) {
            this.$emit("modificar", alumno);

                
            }
        }
    }
</script>