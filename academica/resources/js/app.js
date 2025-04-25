import './bootstrap';
import { createApp } from 'vue';
import Dexie from 'dexie';
import alumno from './components/AlumnoComponent.vue';
import buscar_alumno from './components/BusquedaAlumnoComponent.vue';

window.db = new Dexie('db_academico');

const app = createApp({
    components: {
        alumno,
        buscar_alumno,
        materia,
        buscarmateria,
        matricula,
        inscripcion,
        busqueda
    },
    data() {
        return {
            forms : {
                alumno: {mostrar: false},
                buscarAlumno: {mostrar: false},
                materia: {mostrar: false},
                buscarMateria: {mostrar: false},
                matricula: {mostrar: false},
                inscripcion: {mostrar: false},
                busqueda: {mostrar: false},
            },
        };
    },
    methods: {
        buscar(form, metodo) {
            this.$refs[form][metodo]();
        },
        abrirFormulario(componente) {
            this.forms[componente].mostrar = !this.forms[componente].mostrar;
        },
        modificar(form, metodo, datos) {
            this.$refs[form][metodo](datos);
        }
    },
    created() {
        db.version(1).stores({
            alumnos: 'codigo_transaccion, codigo, nombre, direccion, municipio, departamento, telefono, email, fecha_nacimiento, sexo, hash',
            materias: 'codigo_transaccion, codigo, nombre, uv.hash',
            matriculas: '++idMatricula, alumno, fecha, periodo',
            inscripciones: '++idInscripcion, alumno, fecha, materia',
            busqueda: '++idCriterio, busqueda'
        });
    }
});
app.mount('#app');
