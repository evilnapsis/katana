# Katana Lite v5.0 - E-commerce & Sistema de Ventas en PHP

**Katana Lite** es la versión gratuita y ligera del sistema de comercio electrónico **Katana Pro**, desarrollada por [Evilnapsis](https://evilnapsis.com). Construido sobre el micro-framework modular **LegoBox v5**, ofrece un catálogo en línea ágil, carrito de compras, gestión de pedidos y un panel de administración profesional sin complejidades innecesarias.

---

## Comparativa de Versiones: Katana Lite vs. Katana Pro

| Módulo / Funcionalidad | Katana Lite (Gratis) | Katana Pro (Premium) |
| :--- | :---: | :---: |
| **Catálogo de Productos** | ✅ Sí (1 imagen principal) | ✅ Sí (+ Galería de fotos múltiples) |
| **Categorización del Catálogo** | ✅ Categorías planas (1 nivel) | ✅ Categorías + Subcategorías anidadas |
| **Galería de Imágenes (`product_image`)** | ❌ No disponible | ✅ Sí (Múltiples fotos por ítem) |
| **Métodos de Pago** | ✅ Depósito Bancario y Contra Entrega | ✅ Depósito, Contra Entrega, PayPal y Mercado Pago |
| **Cupones de Descuento** | ❌ No disponible | ✅ Sí (Monto fijo y porcentaje, vigencias) |
| **Calificaciones con Estrellas (`rating`)** | ❌ No disponible | ✅ Sí (1 a 5 estrellas + cálculo promedio) |
| **Preguntas y Respuestas (`question`)** | ❌ No disponible | ✅ Sí (Interacción cliente-vendedor) |
| **Sliders / Banners de Portada** | ✅ Sí | ✅ Sí |
| **Carrito de Compras e Impuestos (IVA)** | ✅ Sí | ✅ Sí (+ Cupones) |
| **Área Privada de Clientes ("Mis Compras")** | ✅ Sí | ✅ Sí |
| **Dashboard Administrativo con KPIs y Gráficas** | ✅ Sí (Chart.js) | ✅ Sí (+ Analítica de cupones y conversión) |
| **Gestión de Pedidos e Historial de Estados** | ✅ Sí | ✅ Sí |
| **Gestión de Clientes y Staff de Usuarios** | ✅ Sí | ✅ Sí |
| **Script de Migración Directa sin perder datos** | ❌ | ✅ `upgrade_from_lite.sql` incluido |

> 👉 **¿Deseas desbloquear pagos automáticos con PayPal/MercadoPago, cupones, subcategorías y calificaciones?**  
> Conoce más y adquiere la versión completa en:  
> **[https://evilnapsis.com/product/katana/](https://evilnapsis.com/product/katana/)**

---

## Ventajas Principales de Katana Lite

* **Ligero y ultrarrápido**: Consume menos de 4–6 MB de RAM por petición HTTP y no requiere Node.js ni compiladores externos.
* **Despliegue directo**: Funciona en cualquier servidor Apache/PHP 8 (cPanel, XAMPP, VPS) copiando los archivos.
* **Arquitectura limpia**: Enrutamiento declarativo con **FastRoute**, plantillas desacopladas con **Twig 3** y modelos seguros con **Prepared Statements (PDO)**.
* **Diseño responsivo**: Tienda basada en **Tabler UI** y panel de administración en **CoreUI / Bootstrap**.

---

## Requisitos del Sistema

* **PHP**: `>= 8.0` (con extensiones `pdo_mysql`, `mbstring`, `fileinfo`)
* **Servidor Web**: Apache con módulo `mod_rewrite` habilitado (XAMPP, Laragon, cPanel, etc.)
* **Base de Datos**: MySQL `>= 5.7` o MariaDB `>= 10.4`
* **Composer**: `>= 2.0`

---

## Instalación y Puesta en Marcha

### 1. Ubicación del Proyecto
Ubica la carpeta `katana` dentro de la raíz de tu servidor web (por ejemplo `C:\xampp\htdocs\katana` o `public_html/`).

### 2. Base de Datos
Crea una base de datos en tu servidor MySQL (por defecto `katana`) e importa el archivo `schema.sql`:

```bash
mysql -u root -p katana < schema.sql
```

### 3. Configuración de Conexión
Si tus credenciales de base de datos son diferentes a `root` sin contraseña, configúralas en:
* `core/controller/Database.php` (para la tienda pública)
* `admin/core/controller/Database.php` (para el panel de administración)

```php
function __construct(){
    $this->user = "root";
    $this->pass = "";
    $this->host = "localhost";
    $this->ddbb = "katana";
}
```

### 4. Credenciales Iniciales de Administración
* **URL del panel**: `http://localhost/katana/admin`
* **Usuario**: `admin`
* **Contraseña**: `admin`

---

## Estructura del Proyecto

```text
katana/
├── .htaccess                   # Reescritura de URLs para Apache (Front Controller)
├── composer.json               # Dependencias (Twig 3, FastRoute) y PSR-4
├── index.php                   # Front Controller de la Tienda Pública
├── schema.sql                  # Base de datos simplificada de Katana Lite
├── public/                     # Vistas Twig de la tienda pública
│   ├── layouts/store.html.twig # Layout maestro de la tienda
│   └── store/                  # Vistas: home, catálogo, producto, carrito, checkout, etc.
├── admin/                      # Suite del Panel de Administración
│   ├── index.php               # Front Controller del Admin
│   ├── core/app/               # Controladores, modelos y servicios del Admin
│   └── public/admin/           # Vistas Twig del Admin (dashboard, productos, pedidos, etc.)
└── core/                       # Núcleo del microframework LegoBox v5
    ├── autoload.php            # Autocargador del sistema
    └── controller/             # Clases del núcleo (Database, Request, Session, ViewEngine)
```

---

## Migración a Katana Pro

Si en el futuro tu tienda crece y necesitas cupones de descuento, pagos con tarjeta por PayPal o MercadoPago, calificaciones y subcategorías, la actualización a **Katana Pro** es transparente y conserva el 100% de tus productos, clientes y compras previas gracias al script de migración oficial provisto con la versión Pro.

Visita **[https://evilnapsis.com/product/katana/](https://evilnapsis.com/product/katana/)** para obtener la licencia comercial.
