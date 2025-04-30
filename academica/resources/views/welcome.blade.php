<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aplicacion Academica - Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
      
       <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    </head>
    <body class="antialiased">
        <div class="container-fluid" id="app">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img width="150" src= "img/logo.png" alt="Logo UGB">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" @click="abrirFormulario('alumno')" href="#">Alumno</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" @click="abrirFormulario('materia')" href="#">Materia</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" @click="abrirFormulario('matricula')" href="#">Matricula</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" @click="abrirFormulario('inscripcion')" href="#">Inscripción</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" @click="abrirFormulario('busqueda')" href="#">Busqueda</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container-fluid" id="appSistema">
                <alumno v-show="forms.alumno.mostrar" :forms="forms" ref="alumno" @buscar="buscar('buscarAlumno', 'listarAlumnos')"></alumno>
                <buscarAlumno v-show="forms.buscarAlumno.mostrar" ref="buscarAlumno" @modificar="modificar('alumno', 'modificarAlumno', $event)"></buscarAlumno>
                <materia v-show="forms.materia.mostrar" :forms="forms" ref="materia" @buscar="buscar('buscarMateria', 'listarMaterias')"></materia>
                <buscarMateria v-show="forms.buscarMateria.mostrar" ref="buscarMateria" @modificar="modificar('materia', 'modificarMateria', $event)"></buscarMateria>
                <matricula v-show="forms.matricula.mostrar" :forms="forms" ref="matricula" @buscar="buscar('buscarmatricula', 'listarMatricula')"></matricula>
                <inscripcion v-show="forms.inscripcion.mostrar" :forms="forms" ref="inscripcion" @buscar="buscar('buscarinscripcion', 'listarInscripcion')"></inscripcion>
                <busqueda v-show="forms.busqueda.mostrar"ref="busqueda" @modificar="modificar('alumno', 'modificarAlumno', $event)"></busqueda>
            </div>
        </div>

        @vite('resources/js/app.js')
    </body>
</html>