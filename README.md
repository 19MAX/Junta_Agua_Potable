# Descripción
Sistema web para la junta administrativa de agua potable.
Utiliza un servicio API.

# Preparación (Windows)
1. Crear un archivo **cookieFile.txt** en la ruta del proyecto.
2. Cambiar, de ser necesario, la ruta BASE de la API en el archivo **APIurls.php**.

# Preparación (Linux)
1. Crear un archivo **cookieFile.txt** en la ruta del proyecto.
2. Asignar el usuario y grupo **www-data** al archivo cookieFile.txt.
3. Otorgar permisos de escritura y lectura para los usuarios en el archivo cookieFile.txt.
4. Otorgar permisos 775 a la carpeta del proyecto. El grupo asignado debe ser www-data.
5. Cambiar, de ser necesario, la ruta BASE de la API en el archivo **APIurls.php**.

## Importante
* Tener activo el servicio API de junta de agua potable.
* Contar con la DB creada y previamente configurada con el primer administrador y la configuracion.
* En el archivo **APIurls.php** hacer mencion a la ruta del servicio API.