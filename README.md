# ReparaYa

Aplicación web desarrollada en PHP para la gestión de averías domésticas, como fontanería, electricidad y otros servicios técnicos.

## Descripción del proyecto

ReparaYa permite que clientes particulares y empresas soliciten asistencias técnicas, mientras que el administrador puede gestionar avisos, asignar técnicos y organizar el calendario de trabajo.

Este proyecto se desarrolla en **PHP original sin frameworks**, siguiendo una arquitectura **MVC** y utilizando **Docker** para el entorno local.

## Objetivo del producto

El objetivo de este producto es desarrollar una aplicación web con acceso a base de datos en entorno servidor, aplicando una arquitectura MVC y utilizando Git/GitHub para el control de versiones del trabajo en equipo.

## Estructura del proyecto

```text
app/
  controllers/
  core/
  models/
  views/
    admin/
    auth/
    client/
    home/
    layouts/
    profile/
    technician/

config/
database/
docker/
  php/
    Dockerfile

public/
  assets/
    css/
    img/
    js/
  index.php

.env
.gitignore
docker-compose.yml
README.md