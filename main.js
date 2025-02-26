const {createApp, ref} = Vue;
const Dexie = window.Dexie,
    db = new Dexie('db_academico');

const app = createApp({
    components: {
        alumno,
        materia,
        buscaralumno,
        buscarmateria,
        matricula,
        inscripcion
    },
    data() {
        return {
            forms : {
                alumno: {mostrar: false},
                buscarAlumno: {mostrar: false},
                materia: {mostrar: false},
                buscarMateria: {mostrar: false},
                matricula: { mostrar: false },
                inscripcion: { mostrar: false }
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
            alumnos: '++idAlumno, codigo, nombre, direccion, municipio, departamento, telefono, email, fecha_nacimiento, sexo',
            materias: '++idMateria, codigo, nombre, uv',
            matriculas: '++idMatricula, alumno, fecha, periodo',
            inscripciones: '++idInscripcion, alumno, fecha, materia'
        });
    }
});
app.mount('#app');
