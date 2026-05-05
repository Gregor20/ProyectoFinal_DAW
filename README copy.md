nombre-del-proyecto/
├── admin/                # Todo lo relacionado con el panel de gestión
│   ├── index.php         # Dashboard principal del admin
│   ├── productos.php     # CRUD de productos
│   ├── pedidos.php       # Gestión de ventas realizadas
│   └── categorias.php    # Gestión de categorías
├── assets/               # Archivos estáticos (públicos)
│   ├── css/              # Vuestro estilo "moderno y directo"
│   ├── js/               # Validaciones y efectos
│   └── img/              # Subcarpetas: /productos y /ui (logos/iconos)
├── config/               # Configuración del sistema
│   └── db.php            # El archivo PDO que vimos antes
├── database/             # ¡OJO! Guardad aquí vuestro archivo .sql
│   └── estructura.sql    # Exportación de la base de datos
├── includes/             # Piezas de LEGO (Modularidad)
│   ├── header.php        # Menú superior (Inicio, Login, etc.)
│   ├── footer.php        # Pie de página
│   ├── auth.php          # Lógica de sesiones y seguridad
│   └── funciones.php     # Funciones útiles (formatear moneda, etc.)
├── vws/                  # Vistas del cliente (públicas)
│   ├── catalogo.php      # El escaparate de moda
│   ├── producto.php      # Ficha individual de prenda
│   ├── login.php         # Formulario de entrada
│   ├── registro.php      # Formulario de nuevo usuario
│   ├── carrito.php       # El proceso de compra
│   └── contacto.php      # Atención al cliente
├── index.php             # Página de inicio oficial (Home)
├── .htaccess             # Para seguridad y URLs bonitas
└── README.md             # El archivo que redactamos antes