# Configuración del entorno y comandos útiles

> Volver al [**Documento inicial**](README.md).

## Comandos útiles

Todos deben correrse en una consola en la carpeta raíz de este proyecto.

- `composer run migrar` para recrear las tablas.
- `composer run hidratar` para llenar de datos las tablas
- `iniciar` para levantar el servidor de php (ya sea el archivo `.bat` para las PCs con Windows, o `.sh` para las de linux).
- `listar-rutas` para listar las rutas (o endpoints) que ofrece el servidor (ya sea el archivo `.bat` para las PCs con Windows, o `.sh` para las de linux).

## Cómo correr los tests

Recuerden que para ejecutar los tests, al menos en VSCode, deben:

1. Ir al ícono del "bichito + el de play".
2. Seleccionar la opción "Ejecutar archivo PHP actual"
3. Abrir el archivo de tests que quieran ejecutar.
4. Darle clic al botón verde de play o apretar F5.

## Como debuggear el servidor

Si quieren debuggear el servidor, deberán:

1. Tener el servidor iniciado en una consola.
2. Ir al ícono del "bichito + el de play" y seleccionar la opción "Escuchar el servidor".
3. Darle clic al botón verde de play o apretar F5.

En la siguiente operación que hagan (ya sea con un refresh de una vista en el explorador), o al invocar una operación como guardar, actualizar o eliminar desde una vista, el servidor se detendrá si pasa por un breakpoint que hayan puesto.

## Configuración inicial

### Requerimientos técnicos mínimos para poder desarrollar el trabajo

- Tener **php 7.4** o superior instalado. Es requerimiento mínimo para poder utilizar el tipado de atributos en las clases.
- Tener **composer** instalado. Si no lo tienen instalado, vuelvan a revisar el PDF `TP 0.2 - Configuración de PHP`, que allí se explica cómo instalarlo.
- Tener instalado MariaDB.
- Tener instalado un IDE para desarrollo. Se recomienda VSCode.
- Tener instalado un IDE para administración de Bases de Datos. Se recomienda DBeaver, que es de código abierto, multiplataforma y bastante intuitivo. Se puede desargar por acá https://dbeaver.io/

### Pasos iniciales de configuración

Antes de poder programar cualquier cosa, necesitaremos inicializar las distintas herramientas. Para ello se debe hacer lo siguiente:

#### Inicializar composer

1. Acceder a la terminal.
2. Ir a la carpeta del proyecto.
3. Ejecutar `composer install`. Este comando se encargará de instalar todas las dependencias definidas en el archivo `composer.json`. Sin este paso, nada funcionará.

#### Crear archivo de variables de entorno

1. Copiar el archivo `.env.ejemplo` y renombrarlo a `.env`.
2. Acceder al archivo `.env` y editar los valores de las variables `DB_USER` y `DB_PASS`. Estas dos variables serán utilizadas en la aplicación para conectarse a la Base de Datos.
   - `DB_USER` deberá tener asignado el nombre del usuario con el que se conectan a la Base de Datos.
   - `DB_PASS` deberá tener la contraseña que utilizan para conectarse a la BD con el usuario anterior. Si no configuraron contraseña, dejarla como string vacío.

#### Crear la base de datos

1. Acceder a la consola de MariaDB desde la terminal. Para ello deben ejecutar el siguiente comando:
   - Si tienen un usuario con contraseña:
     ```sh
     mysql -u nombre_del_usuario -p
     ```
   - Si tienen un usuario sin contraseña:
     ```sh
     mysql -u nombre_del_usuario
     ```
   - Si no crearon un usuario específico, pueden utilizar el usuario **root**.
2. Crear la base de datos. Para ello, pueden copiar el código SQL que hay en el archivo `creacion-db.sql`, pegarlo en la consola SQL y ejecutarlo.

#### Crear las tablas y los datos

1. Acceder a la terminal.
2. Ir a la carpeta del proyecto.
3. Ejecutar `composer run migrar`. Este comando se de crear todas las tablas.
4. Ejecutar `composer run hidratar`. Este comando se de crear todos los datos iniciales.

## Nota de interés

Este esqueleto está construido con las siguientes tecnologías:

- Diseño MVC.
- [Slim framework](https://www.slimframework.com/): es responsable de manejar la comunicación HTTP: rutas, middlewares para proceso de JSON y de los verbos HTTP para cada ruta.
- [Brick\DateTime](https://github.com/brick/date-time): librería para manejo de fechas inmutables. Lo de inmutabilidad es super importante porque significa que las instancias no cambian su contenido interno al realizar una operación sobre ellas, sino que crean una nueva instancia.
- [Dotenv](https://github.com/vlucas/phpdotenv): librería para leer archivos `.env` y similares y cargar los datos en las variables globales.
- [EndyJasmi\Cuid](https://github.com/endyjasmi/cuid): es una librería generar ids únicos a nivel profesional/global. Esta librería permite que la BD delegue el trabajo de generar IDs únicos al servidor o hasta al cliente. Se utilizó para mantener el diseño orientado a objetos lo más correcto posible. Esto se debe a que son los objetos realmente los responsables de generar su código de identificación único.

Todas estas librerías son herramientas profesionales que podrían llegar a utilizar en algún desarrollo personal o laboral.
