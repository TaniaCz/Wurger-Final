package com.Wurger.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.math.BigDecimal;
import java.time.LocalDate;

@Entity
@Table(name = "producto_terminado")
@Getter
@Setter
public class ProductoTerminado {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_producto_terminado")
    private Integer id;

    @Column(nullable = false, length = 100)
    private String nombre;

    private String descripcion;

    @Column(length = 50)
    private String categoria;

    private BigDecimal costo;

    private BigDecimal precio;

    @Column(name = "stock_actual")
    private Integer stockActual;

    @Column(name = "stock_min")
    private Integer stockMin;

    @Enumerated(EnumType.STRING)
    @Column(length = 20)
    private Estado estado;

    @Column(name = "fecha_ingreso")
    private LocalDate fechaIngreso;

    // Relación con Producto
    // Aquí NO usamos JsonIgnore porque es útil ver los datos del producto base.
    @OneToOne
    @JoinColumn(name = "id_producto")
    private Producto producto;

    public enum Estado {
        Activo,
        Inactivo
    }
}