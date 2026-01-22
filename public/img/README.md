# 📁 Estructura de Imágenes - Heladería Santa Rosa

## 🎨 Paleta de Colores
```
#1FB9A2 - Turquesa/Verde agua (Principal)
#D03994 - Rosa/Magenta (Secundario)
#83D7D0 - Azul agua claro (Terciario)
#ECCFD8 - Rosa pastel (Fondo suave)
#819985 - Verde gris (Acentos)
```

## 📂 Organización de Carpetas

### `/public/img/` - Imágenes Estáticas
Almacena imágenes fijas del sitio que NO cambian:
- **logoPrincipal.png** ✓ - Logo de la heladería
- **favicon.ico** - Icono del navegador
- **banners/** - Imágenes promocionales
- **iconos/** - Iconos del sitio
- **decorativas/** - Elementos visuales fijos

**Uso en Blade:**
```php
<img src="{{ asset('img/logoPrincipal.png') }}" alt="Logo">
```

---

### `/storage/app/public/productos/` - Imágenes de Productos
Almacena fotos de productos subidas por el administrador:
- Fotos de helados cargadas desde dispositivos
- Se suben mediante el formulario de administración
- Solo se guarda el nombre del archivo en la base de datos

**Configuración requerida:**
```bash
php artisan storage:link
```

**Uso en Blade:**
```php
<img src="{{ Storage::url($producto->imagen) }}" alt="{{ $producto->nombre }}">
```

**Ruta física:** `c:\laragon\www\heladeria\storage\app\public\productos\`
**Ruta pública:** `http://127.0.0.1:8000/storage/productos/nombre-archivo.jpg`

---

## 📝 Convenciones de Nombres

### Imágenes Estáticas
- Usar camelCase: `logoPrincipal.png`, `bannerVerano.jpg`
- Descriptivos y específicos
- Sin espacios ni caracteres especiales

### Imágenes de Productos
- Generadas automáticamente por el sistema
- Formato: `timestamp_nombre-original.extension`
- Ejemplo: `1737561234_helado-frutilla.jpg`

---

## 🔧 Comandos Útiles

```bash
# Crear enlace simbólico para storage (una sola vez)
php artisan storage:link

# Ver estructura de storage
dir storage\app\public

# Ver imágenes públicas
dir public\img
```

---

## 📊 Flujo de Trabajo

### Para Administradores
1. Ir a "Productos" en el panel admin
2. Crear/editar producto
3. Subir imagen desde dispositivo
4. El sistema guarda automáticamente en `storage/productos/`

### Para Desarrolladores
1. Imágenes fijas → `public/img/`
2. Imágenes dinámicas → Suben los usuarios admin
3. Actualizar vistas con `asset()` o `Storage::url()`

---

## ✅ Checklist de Implementación

- [x] Crear carpeta `public/img/`
- [x] Agregar logo principal
- [x] Configurar CSS con paleta de colores
- [x] Actualizar vistas con logo
- [ ] Ejecutar `php artisan storage:link`
- [ ] Subir productos de prueba con imágenes
- [ ] Agregar favicon.ico
- [ ] Crear banners promocionales

---

📅 Última actualización: 22 de enero de 2026
🏢 Heladería Santa Rosa - Sistema de Gestión
