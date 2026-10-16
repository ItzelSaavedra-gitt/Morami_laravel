CAMBIOS DE INICIO DE SESION Y CRUD DE USUARIOS

Se conservaron los nombres originales de las clases y métodos de interfaz.

Archivos modificados:
- routes/web.php
- app/Http/Controllers/loginController.php
- app/Http/Controllers/usuarioController.php
- app/Http/Controllers/registro_usuController.php
- resources/views/login.blade.php
- resources/views/usuario.blade.php
- resources/views/registro_usu.blade.php

Inicio de sesión:
- GET /login muestra el formulario.
- POST /login valida usuario y contraseña contra la tabla `usuarios`.
- Credenciales incorrectas muestran el mensaje "Usuario y contraseña incorrecto".
- Las contraseñas heredadas en texto plano se aceptan una vez y se convierten a hash al iniciar sesión correctamente.
- Las contraseñas nuevas se guardan con hash.

CRUD:
- GET /usuarios lista los usuarios.
- GET /usuarios/crear muestra el formulario.
- POST /usuarios registra.
- GET /usuarios/{id}/editar edita.
- PUT /usuarios/{id} actualiza.
- DELETE /usuarios/{id} elimina.

IMPORTANTE:
1. El código usa la tabla existente `usuarios` y las columnas `id_usu_pk`, `nombre`, `apellidoPaterno`, `apellidoMaterno`, `usuario`, `contrasenia` que aparecen en el proyecto original.
2. Configura las credenciales MySQL en tu archivo .env local. El archivo .env original no se incluye en este paquete por seguridad; conserva tu copia local.
3. El formulario no muestra las contraseñas en la lista.
4. El campo `rol` se conserva visualmente en el formulario original, pero no se guarda porque el controlador original no evidencia una columna `rol` en la tabla. Si tu tabla sí tiene esa columna, puede añadirse explícitamente.
5. Las rutas del CRUD todavía requieren que agregues protección de acceso/middleware antes de publicar el sistema en internet.

Para probar:
- Copia los archivos modificados sobre tu proyecto (o usa esta carpeta como referencia).
- Revisa la conexión DB_* en .env.
- Ejecuta `php artisan route:list` y abre `/login`.
