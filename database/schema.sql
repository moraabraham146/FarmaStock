CREATE DATABASE farmastock;

-- 2. Tabla de Categorías
CREATE TABLE categorias (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabla de Proveedores
CREATE TABLE proveedores (
    id BIGSERIAL PRIMARY KEY,
    rif VARCHAR(20) NOT NULL UNIQUE,
    razon_social VARCHAR(150) NOT NULL,
    telefono VARCHAR(25) NULL,
    correo VARCHAR(100) NULL,
    direccion TEXT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tabla de Medicinas (Almacén / Catálogo)
CREATE TABLE medicinas (
    id BIGSERIAL PRIMARY KEY,
    categoria_id BIGINT NOT NULL,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(150) NOT NULL,
    principio_activo VARCHAR(150) NULL,
    presentacion VARCHAR(80) NOT NULL,
    laboratorio VARCHAR(100) NULL,
    precio_unitario NUMERIC(10, 2) NOT NULL DEFAULT 0.00,
    stock_minimo INTEGER NOT NULL DEFAULT 5,
    stock_total INTEGER NOT NULL DEFAULT 0,
    requiere_recipe BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_medicinas_categoria FOREIGN KEY (categoria_id) 
        REFERENCES categorias(id) ON DELETE RESTRICT
);

-- 5. Tabla de Lotes y Vencimientos
CREATE TABLE lotes (
    id BIGSERIAL PRIMARY KEY,
    medicina_id BIGINT NOT NULL,
    numero_lote VARCHAR(60) NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    cantidad_actual INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uk_medicina_lote UNIQUE (medicina_id, numero_lote),
    CONSTRAINT fk_lotes_medicina FOREIGN KEY (medicina_id) 
        REFERENCES medicinas(id) ON DELETE CASCADE
);

-- 6. Tabla de Movimientos de Inventario (Entradas y Salidas)
CREATE TABLE movimientos_inventario (
    id BIGSERIAL PRIMARY KEY,
    medicina_id BIGINT NOT NULL,
    lote_id BIGINT NULL,
    proveedor_id BIGINT NULL,
    user_id BIGINT NOT NULL,
    tipo VARCHAR(10) NOT NULL CHECK (tipo IN ('entrada', 'salida')),
    cantidad INTEGER NOT NULL CHECK (cantidad > 0),
    precio_costo_venta NUMERIC(10, 2) NULL,
    motivo VARCHAR(150) NOT NULL,
    observacion TEXT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_mov_medicina FOREIGN KEY (medicina_id) 
        REFERENCES medicinas(id) ON DELETE RESTRICT,
    CONSTRAINT fk_mov_lote FOREIGN KEY (lote_id) 
        REFERENCES lotes(id) ON DELETE SET NULL,
    CONSTRAINT fk_mov_proveedor FOREIGN KEY (proveedor_id) 
        REFERENCES proveedores(id) ON DELETE SET NULL,
    CONSTRAINT fk_mov_user FOREIGN KEY (user_id) 
        REFERENCES users(id) ON DELETE RESTRICT
);

-- Índices recomendados para acelerar consultas de inventario y vencimientos
CREATE INDEX idx_medicinas_nombre ON medicinas(nombre);
CREATE INDEX idx_lotes_vencimiento ON lotes(fecha_vencimiento);
CREATE INDEX idx_movimientos_tipo_fecha ON movimientos_inventario(tipo, created_at);