package com.Wurger.model;

import com.fasterxml.jackson.annotation.JsonIgnore;
import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;
import java.util.List;

@Entity
@Table(name = "forma_pago")
@Getter
@Setter
public class FormaPago {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_fp")
    private Integer id;

    @Column(nullable = false, length = 50)
    private String nombre;

    // Relación con Venta (Padre)
    @ManyToOne
    @JoinColumn(name = "id_venta", nullable = false)
    private Venta venta;

    // Relación con TipoDescuento (Hijo)
    // Usamos JsonIgnore para evitar loops si pides la forma de pago
    @OneToMany(mappedBy = "formaPago", cascade = CascadeType.ALL)
    @JsonIgnore
    private List<TipoDescuento> tiposDescuento;
}