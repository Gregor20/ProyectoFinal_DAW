-- ============================================================
--  MODA SHOP — Script SQL adaptado al diagrama ERD del TFG
--  Respeta fielmente las tablas y campos del diagrama
-- ============================================================

CREATE DATABASE IF NOT EXISTS tienda_moda
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_spanish_ci;
    
USE tienda_moda;

-- ------------------------------------------------------------
-- 1. ROLES
--    Campos del diagrama: id (PK), nombre_rol
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS roles (
    id         INT         AUTO_INCREMENT PRIMARY KEY,  -- Identificador único del rol
    nombre_rol VARCHAR(50) NOT NULL UNIQUE              -- 'admin' | 'cliente'
);

INSERT INTO roles (nombre_rol) VALUES ('admin'), ('cliente');


-- ------------------------------------------------------------
-- 2. CATEGORIAS
--    Campos del diagrama: id (PK), nombre
--    + imagen_url (añadida: portadas visuales de categoría)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categorias (
    id         INT          AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(50)  NOT NULL UNIQUE,
    -- imagen_url VARCHAR(500) DEFAULT NULL -- Opcional: URL de imagen representativa de la categoría
);

INSERT INTO categorias (nombre) VALUES
    ('Mujer'), ('Hombre'), ('Accesorios'), ('New In'), ('Sale');


-- ------------------------------------------------------------
-- 3. PRODUCTOS
--    Campos del diagrama: id (PK), nombre, precio, id_categoria (FK)
--    + imagen_url (añadida: esencial para mostrar el producto)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS productos (
    id           INT            AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(50)    NOT NULL,
    precio       DECIMAL(10, 2) NOT NULL,
    id_categoria INT            NOT NULL,
    imagen_url   VARCHAR(500)   DEFAULT NULL,
    CONSTRAINT fk_producto_categoria
        FOREIGN KEY (id_categoria) REFERENCES categorias (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

INSERT INTO productos (nombre, precio, id_categoria, imagen_url) VALUES
    ('Blazer Oversize Lino',      129.95, 1, 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600'),
    ('Vestido Midi Saten',         89.95, 1, 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600'),
    ('Chaqueta Tecnica Slim',     149.00, 2, 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600'),
    ('Pantalon Cargo Relaxed',     79.95, 2, 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=600'),
    ('Bolso Tote Cuero Vegano',    95.00, 3, 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600'),
    ('Trench Coat Clasico',       195.00, 4, 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=600'),
    ('Camiseta Essential Cotton',  24.95, 5, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600'),
    ('Falda Plisada Midi',         65.00, 1, 'https://images.unsplash.com/photo-1583496661160-fb5218f9a3df?w=600');


-- ------------------------------------------------------------
-- 4. USUARIOS
--    Campos del diagrama: id (PK), nombre, email, contraseña, id_rol (FK)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    id         INT          AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(50)  NOT NULL,
    email      VARCHAR(70)  NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,               
    id_rol     INT          NOT NULL DEFAULT 2,
    CONSTRAINT fk_usuario_rol                       -- Rol por defecto: 'cliente' (id_rol = 2)
        FOREIGN KEY (id_rol) REFERENCES roles (id)  -- Relación con tabla roles
        ON UPDATE CASCADE ON DELETE RESTRICT        -- Evita eliminación de rol si hay usuarios asociados
);

-- Admin por defecto (contraseña: Admin1234!)
INSERT INTO usuarios (nombre, email, contraseña, id_rol) VALUES
    ('Admin', 'admin@modashop.com',
     '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);


-- ------------------------------------------------------------
-- 5. PEDIDOS
--    Campos del diagrama: id (PK), id_usuario (FK), fecha, total
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS pedidos (
    id         INT            AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT            NOT NULL,
    fecha      DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total      DECIMAL(10, 2) NOT NULL,
    CONSTRAINT fk_pedido_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);


-- ------------------------------------------------------------
-- 6. DETALLE_PEDIDOS
--    Campos del diagrama: id (PK), id_pedido (FK), id_producto (FK),
--                         cantidad, precio_unitario
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS detalle_pedidos (
    id              INT            AUTO_INCREMENT PRIMARY KEY,
    id_pedido       INT            NOT NULL,
    id_producto     INT            NOT NULL,
    cantidad        INT            NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    CONSTRAINT fk_detalle_pedido
        FOREIGN KEY (id_pedido)   REFERENCES pedidos   (id) ON DELETE CASCADE,
    CONSTRAINT fk_detalle_producto
        FOREIGN KEY (id_producto) REFERENCES productos  (id) ON DELETE RESTRICT
);
