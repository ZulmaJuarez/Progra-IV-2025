const {createApp} = Vue;

createApp({
    data() {
        return {
            alumnos: [],
            codigo: '',
            nombre: '',
            direccion: '',
            municipio: '',
            departamento: '',
            telefono: '',
            fecha_nacimiento: '',
            sexo: '',
        }
    },
    methods: {
        eliminarAlumno(alumno) {
            if (confirm(`¿Esta seguro de eliminar el alumno ${alumno.nombre}?`)){
                localStorage.removeItem(alumno.codigo);
                this.listarAlumnos();
            }
        },
        verAlumno(alumno) {
            this.codigo = alumno.codigo;
            this.nombre = alumno.nombre;
            this.direccion = alumno.direccion;
            this.municipio = alumno.municipio;
            this.departamento = alumno.departamento;
            this.telefono = alumno.telefono;
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
                fecha_nacimiento: this.fecha_nacimiento,
                sexo: this.sexo
                
            };
            localStorage.setItem(this.codigo, JSON.stringify(alumno));
            this.listarAlumnos();
        },
        listarAlumnos() {
            this.alumnos = [];
            for (let i = 0; i < localStorage.length; i++) {
                let clave = localStorage.key(i),
                    valor = localStorage.getItem(clave);
                this.alumnos.push(JSON.parse(valor));
            }
        }
    },
    created() {
        this.listarAlumnos();
    }
}).mount('#app');