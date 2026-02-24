# Guía de Sincronización - Axis Gestora

Esta guía contiene los pasos necesarios para configurar este proyecto en un nuevo ordenador y poder seguir trabajando sin problemas.

## 1. Requisitos Previos
Asegúrate de tener instalado lo siguiente en el nuevo ordenador:
- **Git**: [https://git-scm.com/](https://git-scm.com/)
- **PHP** (v8.1 o superior): Recomendado vía XAMPP o Laragon.
- **Composer**: [https://getcomposer.org/](https://getcomposer.org/)
- **Node.js y NPM**: [https://nodejs.org/](https://nodejs.org/)

## 2. Configuración Inicial en el Nuevo Ordenador

Abre una terminal y sigue estos pasos:

### A. Clonar el repositorio
```bash
git clone https://github.com/AlvaroOrtizUnaWeb/Axis-Gestora.git
cd Axis-Gestora
```

### B. Instalar dependencias
```bash
# Instalar dependencias de PHP
composer install

# Instalar dependencias de Javascript
npm install
```

### C. Configurar el entorno (.env)
El archivo `.env` contiene claves secretas y no se sube a GitHub. Debes crearlo manualmente:
1. Copia `.env.example` y cámbiale el nombre a `.env`.
2. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```
3. Configura tu base de datos en el archivo `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

### D. Preparar la Base de Datos
Si estás usando una base de datos local (MySQL/MariaDB):
1. Crea una base de datos vacía con el nombre que pusiste en el `.env`.
2. Ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```

## 3. Flujo de Trabajo Diario (Sincronización)

Para evitar conflictos, sigue siempre este orden:

### Al empezar a trabajar (en cualquier ordenador):
```bash
git pull origin master
```
*Esto descarga los últimos cambios que hayas hecho en el otro ordenador.*

### Al terminar de trabajar:
1. Guarda todos tus cambios.
2. Sube los cambios a la nube:
   ```bash
   git add .
   git commit -m "Descripción de los cambios realizados"
   git push origin master
   ```

## 4. Uso de la IA (Antigravity / Cursor)
Para que yo (tu asistente) pueda ayudarte en el otro ordenador:
1. Abre el proyecto en tu IDE (Cursor o VS Code).
2. Asegúrate de haber iniciado sesión con tu cuenta de Google que tiene **Google One AI Premium**.
3. ¡Y listo! Podremos seguir donde lo dejamos.
