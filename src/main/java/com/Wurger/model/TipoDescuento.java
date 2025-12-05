package com.Wurger.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name = "tipo_descuento")
@Getter
@Setter
public class TipoDescuento {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_tipo_descuento")
    private Integer id;

    @Column(nullable = false, length = 50)
    private String nombre;

    // Relación Muchos a Uno con FormaPago
    @ManyToOne
    @JoinColumn(name = "id_fp", nullable = false)
    private FormaPago formaPago;
}