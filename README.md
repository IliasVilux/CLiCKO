<p align="center"><a href="https://https://clicko.es/" target="_blank"><img src="https://blog.clicko.es/wp-content/uploads/2018/09/clicko-venta-online-smartphone-1160x568.jpg" width="1350" height="200" style="object-fit: cover; object-position: left bottom;"></a></p>

<h2 align="center" style="color: #0B951F"><b>CLiCKO</b> / Prueba técnica</h2>

# **Introducción**

Este proyecto aparece a raíz de la prueba técnica desarrollada para [CLiCKO](https://clicko.es/). Consiste de crear una API con el framework de [Laravel](https://laravel.com/docs) en la versión 8.x.

Para realizar esta prueba había varios puntos que el proyecto debería tener:
- Seeder para añadir 20 usuarios en la base de datos
- Crear un endpoint que devuelva los 3 dominios más frecuentes, en orden descendente
- CRUD básico

<p>&nbsp;</p>

# **Instalación**

Para empezar debemos clonar el repositorio:

```
git clone https://github.com/IliasVilux/CLiCKO.git
```

<p>&nbsp;</p>

Una vez ya esté el proyecto clonado, debemos instalar el composer dentro del repositorio:
```
composer install
```
Para poder conectarnos a la base de datos, tenemos que crear el archivo `.env` y modificar las variables de la base de datos:

```
cp .env.example .env
```
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre-de-la-base-de-datos*
DB_USERNAME=nombre-de-usuario
DB_PASSWORD=contraseña
```

<p>&nbsp;</p>

Configurada ya la conexión a la base de datos, ya podemos ejecutar las migraciones y el seeder para alimentar la base de datos.
```
php artisan migrate -seed
```
Los datos se han generado con [FakerPHP](https://fakerphp.github.io/), que es una librería que genera datos falsos para poder trabajar de una manera más realista en el entorno de desarrollo.

<p>&nbsp;</p>

> **Atención!**
> Al ejecutar este comando saltará un error y es porque en el seeder duplica la última inyección a la base de datos. Pero aun así los 20 usuarios se habrán insertado correctamente.

<p>&nbsp;</p>
<p>&nbsp;</p>

# **Utilización**

Teniendo el proyecto ya configurado, ejecutamos el siguiente comando en la terminal para inicializar el servidor:
```
php artisan serve
```
Ahora ya podemos acceder a la ruta donde se nos ha desplegado el servidor de desarollo.

<p>&nbsp;</p>

|                                         |        |                 |
|:---                                     | :---:  |             ---:|
| Registro                                | POST   | /api/register   |
| Login                                   | POST   | /api/login      |
| Crear nuevo usuario                     | POST   | /api/users      |
| Mostrar todos los usuarios              | GET    | /api/users      |
| Mostrar usuario específico              | GET    | /api/users/{id} |
| Modificar usuario                       | PUT    | /api/users/{id} |
| Eliminar usuario                        | DELETE | /api/users/{id} |
| Los 3 dominios más usados (descendente) | GET    | /api/top        |

<p>&nbsp;</p>

En la API se ha implementado [Sanctum](https://laravel.com/docs/8.x/sanctum), por lo que debemos de registrarnos para poder acceder a las peticiones. Para ello accedemos a la ruta que le pertenece `/api/register` y como parámetros añadimos el nombre, email y contraseña.
```json
{
    "name": "Marijke Felicitas",
    "email": "bavec65509@mustbeit.com",
    "password": "MYrODwiNg"
}
```
Una vez registrados, podemos acceder a `/api/login` y con nuestras credenciales iniciar sesión, obteniendo un token. Este lo tenemos que añadir en el apartado de Autorización y a partir de entonces podemos acceder a todas las rutas
![Auth Token](https://i.gyazo.com/a482b70f6e9121c57a82573d48a76b2f.png)

<p>&nbsp;</p>

Para crear un usuario se deben de pasar 3 parámetros que son obligatorios. El **nombre**, el **email**, que de no estar en el formato correcto no se creará el usuario y por último la **contraseña**, que debe de tener un mínimo de 5 caracteres y esta se encripta automáticamente gracias al sistema de hashing de Laravel `bcrypt()`
```
{
  "name": "Eppie Berniece",
  "email": "bavec65509@hotmail.com",
  "password": "TeRfulAdB"
}
```

Para modificar un usuario, se deben de pasar los datos que se deseen modificar y en caso de introducir uno de los datos de manera errónea, solo este no será modificado, en cambio, si el resto de datos introducidos son correctos, si lo serán.
