package com.Wurger.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name = "unidad_medida")
@Getter
@Setter
public class UnidadMedida {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_unidad")
    private Integer id;

    @Column(nullable = false, length = 50)
    private String nombre;

    private Integer cantidad;

    // Relación Muchos a Uno con Producto
    @ManyToOne
    @JoinColumn(name = "id_producto")
    private Producto producto;
}