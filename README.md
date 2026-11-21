# 💊 FarmaStock — Sistema de Gestión e Inventario Farmacéutico

> **Módulo de Backend — Asignatura Programación II (UNETI)**  
> **Desarrollado por:**  (Albert Mass, Abraham Mora, Mario Tovar) / Equipo FarmaStock  

---

## 📋 Descripción del Proyecto
FarmaStock es una solución robusta orientada al control integral de inventarios farmacéuticos (entradas, salidas, gestión de lotes y administración de almacén), diseñada bajo los estándares de arquitectura limpia y alta disponibilidad para entornos corporativos B2B.

---

## 🛠️ Stack Tecnológico (Soberanía y Robustez)
El sistema está construido sobre una infraestructura moderna, auditada y libre de vulnerabilidades críticas:
* **Lenguaje:** PHP 8.3.36 (NTS x64) — *Versión parcheada contra fallos RCE recientes.*
* **Framework Backend:** Laravel (Arquitectura MVC / ORM Eloquent).
* **Base de Datos:** MySQL 8.4.3 (Gestionada localmente mediante motor relacional optimizado).
* **Entorno de Desarrollo:** Laragon (Apache 2.4 / PHP CLI / Composer 2.x).
* **Control de Versiones:** Git & GitHub (Flujo basado en ramas y commits semánticos).

---

## 📂 Arquitectura del Directorio Backend
```text
FarmaStock/
├── app/                  # Lógica de negocio (Controladores, Modelos, Middleware)
├── bootstrap/            # Arranque del framework y configuración de contenedores
├── config/               # Archivos de configuración general del sistema
├── database/             # Migraciones, Factories y Seeders (Esquema relacional)
├── public/               # Punto de entrada web (DocumentRoot de Apache)
├── resources/            # Vistas (Blade), hojas de estilo y assets de frontend
├── routes/               # Definición de rutas API y Web
├── storage/              # Logs de auditoría, caché y archivos compilados
└── tests/                # Pruebas unitarias y de integración