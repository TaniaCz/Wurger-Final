package com.Wurger.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name = "proveedor")
@Getter
@Setter
public class Proveedor {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_proveedor")
    private Integer id;

    @Column(nullable = false, length = 100)
    private String nombre;

    @Column(length = 20)
    private String telefono;

    @Column(length = 100)
    private String email;

    @Column(length = 100)
    private String direccion;

    @Enumerated(EnumType.STRING)
    @Column(length = 20)
    private Estado estado;

    // Relación Muchos a Uno con Usuario (Puede ser nulo)
    @ManyToOne
    @JoinColumn(name = "id_usuario")
    private Usuario usuario;

    public enum Estado {
        Activo,
        Inactivo
    }
}