#README

El presente documento detalla el proceso de instalación 
del Dashboard de la aplicación Territorios del Saber, así
como las tecnologías con las que ha sido implementada.

##Tecnologías
* PHP 7.3 o superior
* MySQL 5.7 o superior
* WebServer Nginx o Apache

##Frameworks utilizados
* DooPHP
* jQuery

##Instalación
Dentro de la carpeta **db** se encuentra el script de creación
de la base de datos y el proyecto de MySQL Workbench para visualizar
el esquema y su estructura.

Para instalar el proyecto en un servidor web, debe colocar el 
código del proyecto en un servidor web apache o nginx apuntando 
como root la raíz del proyecto y configurar  los URL rewrites 
como archivo de entrada el archivo index.php. 

Dentro de la carpeta **protected/config**, encontrará los archivos
de configuración para la conexión a Base de Datos (db.conf.php) y
así como la configuración de si la aplicación se encuentra en modo
desarrollo o modo producción. 

```
$config['APP_MODE'] = 'dev'; //Modo DEV
$config['APP_MODE'] = 'prod'; //Modo Producción
```

En modo desarrollo la aplicación mostrará en pantalla los mensajes
de error de cualquier problema que pueda ocurrir, si es modo producción
la aplicación no mostrará errores en pantalla.

La base de datos ya include un usuario por default el cual es:
* Usuario: admin@admin.com
* Contraseña: ts123456


