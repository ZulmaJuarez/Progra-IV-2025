const matricula = {
    template: `
    <div class="card border-dark mb-3">
        <div class="card-header bg-dark text-white">Registro de Matrícula</div>
        <div class="card-body">
            <div class="row p-1">
                <div class="col-3 col-md-3">Alumno</div>
                <div class="col-9 col-md-4">
                    <select v-model="matricula.alumno" class="form-control">
                        <option v-for="alumno in alumnosFiltrados" :value="alumno.idAlumno">{{ alumno.nombre }}</option>
                    </select>
                </div>
            </div>
            <div class="row p-1">
                <div class="col-3 col-md-3">Fecha</div>
                <div class="col-9 col-md-4">
                    <input type="date" v-model="matricula.fecha" class="form-control">
                </div>
            </div>
            <div class="row p-1">
                <div class="col-3 col-md-3">Periodo</div>
                <div class="col-9 col-md-4">
                    <select v-model="matricula.periodo" class="form-control">
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
    `,

    data() {
        return {
            alumnosFiltrados: [], 
            matricula: {
                alumno: '',
                fecha: '',
                periodo: ''
            },
            alumnos: []
        };
    },
    created() {
            db.alumnos.toArray().then(data => {
                this.alumnos = data;
                this.alumnosFiltrados = data;
            });
        },
        methods: {
            buscarAlumno() {
                this.alumnosFiltrados = this.alumnos.filter(alumno =>
                    alumno.codigo.includes(this.codigoAlumno)
                );
            },
            guardarMatricula() {
                if (!this.matricula.alumno) {
                    alertify.error("Seleccione un alumno");
                    return;
                }
                db.matriculas.add({
                    alumno: this.matricula.alumno,
                    fecha: this.matricula.fecha,
                    periodo: this.matricula.periodo
                }).then(() => {
                    alertify.success("Matrícula guardada exitosamente.");
                    
                    // Limpiar campos después de guardar
                    this.matricula = { alumno: "", fecha: "", periodo: "" };
                }).catch(error => {
                    alertify.error("Error al guardar la matrícula: " + error);
                });
            
            }
        }
    };