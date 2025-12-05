package com.Wurger.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name = "detalle_movimiento")
@Getter
@Setter
public class DetalleMovimiento {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_detalle_movimiento")
    private Integer id;

    @Column(nullable = false)
    private Integer cantidad;

    // Relación Muchos a Uno con Movimiento
    @ManyToOne
    @JoinColumn(name = "id_movimiento", nullable = false)
    private Movimiento movimiento;
}