const inscripcion = {
    template: `
    <div class="card border-dark mb-3">
        <div class="card-header bg-dark text-white">Registro de Inscripción</div>
        <div class="card-body">
            <div class="row p-1">
                <div class="col-3 col-md-3">Alumno</div>
                <div class="col-9 col-md-4">
                    <select v-model="inscripcion.alumno" class="form-control">
                        <option v-for="matricula in matriculasFiltradas" :value="matricula.alumno">
                            {{ obtenerNombreAlumno(matricula.alumno) }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="row p-1">
                <div class="col-3 col-md-3">Fecha</div>
                <div class="col-9 col-md-4">
                    <input type="date" v-model="inscripcion.fecha" class="form-control">
                </div>
            </div>
            <div class="row p-1">
                <div class="col-3 col-md-3">Materias Disponibles</div>
                <div class="col-9 col-md-4">
                    <select v-model="inscripcion.materia" class="form-control">
                        <option v-for="materia in materias" :value="materia.idMateria">{{ materia.nombre }}</option>
                    </select>
                </div>
            </div>
            <div class="row p-1">
                <div class="col-12 text-end">
                    <button @click="guardarInscripcion" class="btn btn-success">Inscribir</button>
                </div>
            </div>
        </div>
    </div>
    `,
    data() {
        return {
            inscripcion: {
                alumno: '',
                fecha: '',
                materia: ''
            },
            matriculas: [],
            alumnos: [],
            materias: []
        };
    },
    created() {
        db.matriculas.toArray().then(data => {
            this.matriculas = data;
            this.matriculasFiltradas = data;
        });
        db.alumnos.toArray().then(data => {
            this.alumnos = data;
        });
        db.materias.toArray().then(data => {
            this.materias = data;
        });
    },
    methods: {
        buscarAlumno() {
            this.matriculasFiltradas = this.matriculas.filter(matricula =>
                this.obtenerCodigoAlumno(matricula.alumno).includes(this.codigoAlumno)
            );
        },
        obtenerNombreAlumno(idAlumno) {
            const alumno = this.alumnos.find(al => al.idAlumno === idAlumno);
            return alumno ? alumno.nombre : "Desconocido";
        },
        obtenerCodigoAlumno(idAlumno) {
            const alumno = this.alumnos.find(al => al.idAlumno === idAlumno);
            return alumno ? alumno.codigo : "";
        },
        guardarInscripcion() {
            if (!this.inscripcion.alumno) {
                alertify.error("Seleccione un alumno");
                return;
            }
            db.inscripciones.add({
                alumno: this.inscripcion.alumno,
                fecha: this.inscripcion.fecha,
                materias: this.inscripcion.materias
            }).then(() => {
                alertify.success("Inscripción guardada exitosamente.");
                
                // 💡 Limpiar los campos después de guardar
                this.inscripcion = { alumno: "", fecha: "", materias: [] };
            }).catch(error => {
                alertify.error("Error al guardar la inscripción: " + error);
            });
        
        }
    }
};
