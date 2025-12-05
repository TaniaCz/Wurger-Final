package com.Wurger.model;

import com.fasterxml.jackson.annotation.JsonIgnore; // <--- IMPORTANTE
import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

import java.util.List;

@Entity
@Table(name = "categoria_producto")
@Getter
@Setter
public class CategoriaProducto {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_categoria")
    private Integer id;

    @Column(name = "nombre_categoria", nullable = false, length = 50)
    private String nombreCategoria;

    @Column(name = "cantidad_categoria")
    private Integer cantidadCategoria;

    // Relación 1:N con producto
    @OneToMany(mappedBy = "categoria", cascade = CascadeType.ALL)
    @JsonIgnore // <--- AGREGAR ESTO: Evita que al pedir la categoría te traiga miles de
                // productos
    private List<Producto> productos;
}