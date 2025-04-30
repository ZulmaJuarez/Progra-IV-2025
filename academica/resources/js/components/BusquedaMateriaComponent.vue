<template>
    <div class="row">
        <div class="col-6">
            <table class="table table-sm table-bordered table-hover">
                <thead>
                    <tr>
                        <th>BUSCAR POR</th>
                        <th>
                            <select v-model="buscarTipo" class="form-control">
                                <option value="codigo">CÓDIGO</option>
                                <option value="nombre">NOMBRE</option>
                                <option value="uv">UV</option>
                            </select>
                        </th>
                        <th colspan="4">
                            <input type="text" v-model="buscar" class="form-control">
                        </th>
                        <th>
                            <button class="btn btn-info" @click="listarMaterias()">Buscar</button>
                        </th>
                    </tr>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>NOMBRE</th>
                        <th>UV</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="materia in materias" @click="modificarMateria(materia)" :key="materia.codigo_transaccion">
                        <td>{{ materia.codigo }}</td>
                        <td>{{ materia.nombre }}</td>
                        <td>{{ materia.uv }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" @click.stop="eliminarMateria(materia)">DELETE</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import alertify from 'alertifyjs';

export default {
    data() {
        return {
            buscar: '',
            buscarTipo: 'nombre',
            materias: [],
        };
    },
    methods: {
        modificarMateria(materia) {
            this.$emit('modificar', materia);
        },
        async eliminarMateria(materia) {
            alertify.confirm(
                'Eliminar Materia',
                `¿Está seguro de eliminar la materia ${materia.nombre}?`,
                async () => {
                    try {
                        await axios.delete(`/api/materias/${materia.codigo}`);
                        alertify.success(`Materia ${materia.nombre} eliminada`);
                        this.listarMaterias();  // Refresca la lista después de eliminar
                    } catch (error) {
                        alertify.error('Error al eliminar la materia');
                        console.error(error);
                    }
                },
                () => {}
            );
        },
        // Función que hace la consulta a la API para listar materias
        async listarMaterias() {
            try {
                const response = await axios.get('/api/materias');
                // Filtro en frontend según el tipo de búsqueda
                this.materias = response.data.filter((materia) =>
                    materia[this.buscarTipo]
                        .toString()
                        .toLowerCase()
                        .includes(this.buscar.toLowerCase())
                );
            } catch (error) {
                console.error('Error al listar materias:', error);
            }
        },
    },
    watch: {
        // Llamar a listarMaterias cuando cambian los valores de buscar o buscarTipo
        buscar() {
            this.listarMaterias();
        },
        buscarTipo() {
            this.listarMaterias();
        },
    },
    created() {
        this.listarMaterias();
    },
};
</script>
