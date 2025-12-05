package com.Wurger.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;
import java.time.LocalDate;

@Entity
@Table(name = "promocion")
@Getter
@Setter
public class Promocion {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_promocion")
    private Integer id;

    @Column(nullable = false, length = 100)
    private String nombre;

    @Column(nullable = false)
    private LocalDate inicio;

    private LocalDate fin;

    @Column(name = "cantidad_usos")
    private Integer cantidadUsos;

    @Enumerated(EnumType.STRING)
    @Column(length = 20)
    private EstadoPromocion estado;

    @Column(length = 255)
    private String descripcion;

    @Column(name = "descuento", nullable = false)
    private Double descuento;

    @Column(name = "tipo_descuento", length = 20, nullable = false)
    private String tipoDescuento; // "PORCENTAJE" o "FIJO"

    // Relación con Producto
    @ManyToOne
    @JoinColumn(name = "id_producto")
    private Producto producto;

    public enum EstadoPromocion {
        Activa,
        Inactiva
    }
}