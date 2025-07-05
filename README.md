# Tienda de Tenis

Este proyecto es una aplicación web desarrollada en PHP y MySQL para la gestión de una tienda de tenis. Permite la administración de productos, categorías y pedidos, el registro para clientes y un inicio de sesion para los administradores.

# Características principales

- Catálogo: Los visitantes pueden ver todos los productos disponibles, sus imágenes, categorías, tallas y precios.
- Registro de clientes: Los clientes pueden registrarse para solicitar pedidos.
- Zona de administración: Acceso exclusivo para el administrador, donde puede gestionar productos, categorías y ver los pedidos realizados.
- Gestión de productos: El administrador puede agregar, editar y eliminar productos, incluyendo la subida de imágenes.
- Gestión de categorías: El administrador puede crear y eliminar categorías de productos.
- Gestión de pedidos: El administrador puede visualizar todos los pedidos realizados por los clientes.
- Solicitar pedido: Los clientes pueden solicitar la compra de un producto, ingresando sus datos para validar su identidad y registrar el pedido.

# Estructura del proyecto

- /Vista/html/  Contiene las vistas (páginas) del sistema, tanto públicas como de administración.
- /Vista/css/  Hojas de estilo CSS.
- /Vista/js/  Scripts JavaScript (si se usan).
- /Modelo/  Clases PHP para la conexión a la base de datos y la lógica de negocio.
- /Controlador/  Lógica de control y enrutamiento de acciones.
- /Uploads/  Carpeta donde se almacenan las imágenes de los productos subidas por el administrador.

# Usuarios

- Administrador: Puede acceder a la zona de administración desde "Zona Admin" e iniciar sesión con un usuario que tenga el rol `admin`.
- Clientes: Se registran desde la opción "Registrarse" y pueden solicitar pedidos desde el catálogo.

# Notas

- El sistema no implementa cifrado de contraseñas, faltaron algunos detalles en el apartado visual del software pero es funcional.

Desarrollado por Joan Sebastian Montenegro Vargas.