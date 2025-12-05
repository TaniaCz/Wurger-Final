package com.Wurger.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;
import java.time.LocalDate;

@Entity
@Table(name = "movimiento")
@Getter
@Setter
public class Movimiento {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_movimiento")
    private Integer id;

    @Enumerated(EnumType.STRING)
    @Column(nullable = false)
    private TipoMovimiento tipo;

    @Column(nullable = false)
    private Integer cantidad;

    @Column(nullable = false)
    private LocalDate fecha;

    @Column(length = 100)
    private String descripcion;

    @ManyToOne
    @JoinColumn(name = "id_producto")
    private Producto producto;

    // Enum definido dentro de la clase
    public enum TipoMovimiento {
        Entrada,
        Salida
    }
}