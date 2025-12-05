package com.Wurger.model;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name = "usuario_info")
@Getter
@Setter
public class UsuarioInfo {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_usuario_info")
    private Integer id;

    @Column(nullable = false, length = 100)
    private String nombre;

    private String telefono;

    private String direccion;

    @OneToOne
    @JoinColumn(name = "id_usuario", unique = true, nullable = false)
    private Usuario usuario;
}
