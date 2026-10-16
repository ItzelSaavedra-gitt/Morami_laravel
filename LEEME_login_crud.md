# Morami_laravel — login y CRUD (usuarios y productos)

1. Ejecuta `database/ajustes_moramilaravel.sql` en DBeaver (ensancha la columna de contraseñas).
2. Revisa `.env` (base `morami_bd`, usuario `root`, sin contraseña).
3. `php artisan view:clear` y abre `/login` (ej. http://morami3.test/login).

Login: valida contra la tabla `usuarios`; datos incorrectos -> aviso rojo arriba a la derecha.
Todas las pantallas internas exigen sesión. "Cerrar sesión" está en el menú lateral.

CRUD (prefix + group + name, como en las diapositivas):
- Usuarios:  /usuarios, /usuarios/vistacrear, /usuarios/guardarusuario, /usuarios/buscarusuario,
             /usuarios/vistaeditar/{id}, /usuarios/editarusuario/{id}, /usuarios/actualizarusuario/{id}, /usuarios/eliminarusuario/{id}
- Productos: /productosre, /productosre/vistacrear, /productosre/guardarproducto, /productosre/buscarproducto,
             /productosre/vistaeditar/{id}, /productosre/editarproducto/{id}, /productosre/actualizarproducto/{id}, /productosre/eliminarproducto/{id}
Las demás pantallas (pedido, cotizacion, inventario, registros) quedan como estaban, sin CRUD.
