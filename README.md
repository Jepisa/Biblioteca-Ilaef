<p align="center"><a href="https://biblioteca.ilaef.org" target="_blank"><img src="https://biblioteca.ilaef.org/img/logo-celeste.png" width="400"></a></p>

## INSTALACIONES NECESARIAS PARA CORRER EL PROYECTO

- [XAMPP](https://www.apachefriends.org/es/download.html) Con la version 8 de PHP

    Esto te descargar un Servider Web Local, Mysql, PHP, ...
- [COMPOSER](https://getcomposer.org/download/) (gestión de dependencias en PHP)
- [NODEJS](https://nodejs.org/es/)  por defecto tambien npm (gestión de dependencias en JS)


## COMANDOS EN CONSOLA PARAR COMENZAR
```
clone https://github.com/Jepisa/Biblioteca-Ilaef.git
cd Biblioteca-Ilaef
composer install
npm install
npm run dev
copy .env.example .env
php artisan key:generate
php artisan storage:link
```
## CONFIGUARAR BASE DE DATOS Y CONECCIÓN AL MISMO
 -Abrir XAPP, comenzar MySql y abril "Shell"
    ![image](https://user-images.githubusercontent.com/54465629/115766639-92db8980-a37e-11eb-8294-c255baa46748.png)

-En la consola (Shell) conectarse a mysql
```
mysql -u root
create database biblioteca_ilaef;
```
Por default se crea un -u (usuario) root y password no tiene, así que si te pide una, solo le das enter.
Si querés, podés cambiar el nombre de datos por otro.

##Codificar el archivo *.env* (está al final de los archivos del proyecto).
- Hay que modificar los datos para conectarse a la base de datos.
Te tendría que quedar algo así.
    
![image](https://user-images.githubusercontent.com/54465629/115768959-5e1d0180-a381-11eb-9167-da808adc2baa.png)

## Agregar una imagen para una muestra de como quedaría la vista welcome
- Ir a la carpeta storage/app/public
- En public, crear una carpeta "content" y agregarle cualquier imagen con el nombre "default.jpg".

## Comandos para llenar la base de datos y levantar el servidor
```
php artisan migrate
php aretisan db:seed
```

## Levantar el servidor e iniciar con un usuario admin
```
php artisan serve
```

- Abrir el navegador e ir a la ruta localhost:8000
- En este momente aparecerá el "login" y entrarás con el email: *admin@admin.com* y el password: *password* 

*Por cualquier error, contactarme.*
