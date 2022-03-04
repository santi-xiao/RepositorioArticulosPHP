# Práctica Symfony Santiago Xiao Rodríguez López

## Descripción del proyecto

Proyecto de PHP creado para el aprendizaje del uso de las BBDD y ORM con Symfony.  
Una aplicación para crear, editar y eliminar **Artículos**.

## Uso del proyecto y requisitos del entorno de desarrollo

Para poder ejecutar la plicación abrá que tener **instalado**:

| Teconología | Versión                   |
| ----------- | ------------------------- |
| PHP         | 8.0.2 (o mayor)           |
| Symfony     | Instalar con **Composer** |

Instalamos las dependencias necesarias para correr el proyecto  
```
composer install
```

Ejecutamos la migración
```
php bin/console doctrine:migrations:migrate
```

Para ejecutar la aplicación se abrirá una consola desde la carpeta raíz del proyecto y usaremos el comando

```
symfony server:start
```

## Teconologías utilizadas

- PHP
- Symfony
- SQLite
- Twig

## Autor

Santiago Xiao Rodríguez López.

## Licencia

Licencia MIT.
