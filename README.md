# Kata PnP Egg Dropper

Supongamos que nos encontramos en un rascacielos de 100 plantas y tenemos 100 huevos. Queremos conocer cuál es la planta más alta desde la cual podemos lanzar un huevo sin romperse. ¿Cuántos lanzamientos serán necesarios como mínimo en el peor de los casos? ¿Y si sólo tenemos 2 huevos? ¿Y si tenemos X huevos y Y plantas?

### Prerequisitos

Para lanzar el proyecto es necesario tener instalado **PHP** y **Composer**, idealmente agregados al PATH para facilitar el uso de los comandos.

## Instrucciones

Para conseguir una copia del proyecto lo clonamos y lanzamos Composer:

````
git clone https://github.com/aaronarriero/pnp-egg-dropper.git
cd pnp-egg-dropper
composer install
````

Para lanzar el script que muestra los resultados navegamos a la carpeta `pnp-egg-dropper` y ejecutamos el siguiente comando:

````
cd src
php results.php
````

### Tests

Para lanzar los tests puede emplearse el ejecutable `test.cmd` o lanzarlos a través de Composer con siguiente comando desde la carpeta `pnp-egg-dropper`:

````
composer test
````

## Construído con

* [PHP](http://www.php.net/) - Lenguaje de scripting
* [VSCode](https://code.visualstudio.com/) - Editor de texto
* [Composer](https://getcomposer.org/) - Gestor de dependencias

## Autores

* **Aarón Arriero Diago** - *Trabajo inicial* - [aaronarriero](https://github.com/aaronarriero)

## Licencia

Este proyecto se encuentra licenciado bajo la licencia MIT - Ver el fichero [LICENSE.md](LICENSE.md) para más detalles.
