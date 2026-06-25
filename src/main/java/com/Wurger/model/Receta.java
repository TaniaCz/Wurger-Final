package com.Wurger.model;

import com.fasterxml.jackson.annotation.JsonIgnore;
import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;
import java.math.BigDecimal;

@Entity
@Table(name = "receta")
@Getter
@Setter
public class Receta {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_receta")
    private Integer id;

    @Column(name = "cantidad_usada", nullable = false, precision = 10, scale = 2)
    private BigDecimal cantidadUsada;

    @ManyToOne
    @JoinColumn(name = "id_producto_terminado", nullable = false)
    @JsonIgnore
    private ProductoTerminado productoTerminado;

    @ManyToOne
    @JoinColumn(name = "id_producto", nullable = false)
    private Producto producto;
}
