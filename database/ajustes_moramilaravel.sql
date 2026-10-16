-- Ejecuta este archivo UNA vez en tu base de datos (DBeaver).
-- Las contraseñas nuevas se guardan con hash (60 caracteres); la columna debe ser más ancha.
-- Las contraseñas que ya tienes en texto plano siguen funcionando para iniciar sesión.
ALTER TABLE usuarios MODIFY contrasenia VARCHAR(255) NOT NULL;
