# Sican Empleo

------

## Herramientas necesarias
1. PHP y Composer
2. Node y pnpm

------

## Pasos De Instalacion Para Desarrollo
1. Clonar el proyecto: `https://github.com/juanjoballesteros/siscanempleo.git`
2. Abrir la carpeta: `cd siscanempleo`
3. Instalar dependencias php: `composer install`
4. Instalar dependencias node: `pnpm install`
5. Copiar archivo env: `cp .env .env.example`
6. Generar la key: `php artisan key:generate`
7. Crear link al storage: `php artisan storage:link`
8. Cambiar informacion de la base de datos en el archivo: `.env`
9. Migrar la base de datos: `php artisan migrate`
10. (Opcional) Agregar usuarios de ejemplo: `php artisan db:seed`
11. Ejecutar el servidor: `composer dev`

------

## Pasos De Instalacion Para Produccion

1. Clonar el proyecto: `https://github.com/juanjoballesteros/siscanempleo.git`
2. Abrir la carpeta: `cd siscanempleo`
3. Instalar dependencias php: `composer install --no-dev -o`
4. Instalar dependencias node: `pnpm install`
5. Copiar archivo env: `cp .env .env.example`
6. Generar la key: `php artisan key:generate`
7. Crear link al storage: `php artisan storage:link`
8. Cambiar informacion de la base de datos, debug mode, entorno, url en el archivo: `.env`
9. Migrar la base de datos: `php artisan migrate`
11. Crear link simbolico hacia el dominio a la carpeta public: `ln -s siscanempleo/public/ empleo.controlntecnologia.co`
