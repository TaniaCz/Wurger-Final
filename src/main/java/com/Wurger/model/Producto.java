package com.Wurger.model;

import com.fasterxml.jackson.annotation.JsonIgnore; // Importante para evitar errores
import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.math.BigDecimal;
import java.time.LocalDate;
import java.util.List;

@Entity
@Table(name = "producto")
@Getter
@Setter
public class Producto {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_producto")
    private Integer id;

    @Column(name = "nombre_producto", nullable = false, length = 100)
    private String nombreProducto;

    private Integer stock;

    @Column(name = "stock_min")
    private Integer stockMin;

    @Column(name = "stock_max")
    private Integer stockMax;

    @Column(name = "precio_compra")
    private BigDecimal precioCompra;

    @Column(name = "precio_venta")
    private BigDecimal precioVenta;

    @Column(name = "tipo_producto", length = 50)
    private String tipoProducto;

    @Enumerated(EnumType.STRING)
    @Column(nullable = false, length = 20)
    private Estado estado;

    @Column(name = "fecha_ingreso")
    private LocalDate fechaIngreso;

    @Column(name = "imagen", length = 500)
    private String imagen;

    // --- RELACIONES ---
    @ManyToOne
    @JoinColumn(name = "id_categoria")
    private CategoriaProducto categoria;

    // Aquí SÍ ponemos JsonIgnore para que no traiga listas infinitas
    @OneToMany(mappedBy = "producto", cascade = CascadeType.ALL)
    @JsonIgnore
    private List<UnidadMedida> unidades;

    @OneToMany(mappedBy = "producto", cascade = CascadeType.ALL)
    @JsonIgnore
    private List<Movimiento> movimientos;

    @OneToOne(mappedBy = "producto", cascade = CascadeType.ALL)
    @JsonIgnore
    private ProductoTerminado productoTerminado;

    @OneToMany(mappedBy = "producto", cascade = CascadeType.ALL)
    @JsonIgnore
    private List<Promocion> promociones;

    // --- ENUMS ---
    public enum Estado {
        Activo,
        Inactivo
    }
}