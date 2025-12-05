package com.Wurger.model;

import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name = "usuario")
@Getter
@Setter
public class Usuario {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_usuario")
    private Integer id;

    @Column(nullable = false, unique = true, length = 100)
    private String email;

    // --- CORRECCIÓN IMPORTANTE ---
    // @JsonProperty(access = WRITE_ONLY) permite que:
    // 1. Spring RECIBA la contraseña cuando creas el usuario (evita el error
    // 'rawPassword cannot be null').
    // 2. Spring OCULTE la contraseña cuando devuelves la respuesta (seguridad).
    @Column(nullable = false, length = 150)
    @JsonProperty(access = JsonProperty.Access.WRITE_ONLY)
    private String password;

    @Enumerated(EnumType.STRING)
    @Column(nullable = false, length = 20)
    private Rol rol;

    @Enumerated(EnumType.STRING)
    @Column(nullable = false, length = 20)
    private Estado estado;

    // Relación 1:1 con usuario_info
    // Usamos JsonIgnore aquí para evitar bucles infinitos si pides el usuario
    @OneToOne(mappedBy = "usuario", cascade = CascadeType.ALL)
    @JsonIgnore
    private UsuarioInfo usuarioInfo;

    // --- ENUMS ---
    public enum Rol {
        Administrador,
        Usuario
    }

    public enum Estado {
        Activo,
        Inactivo
    }
}