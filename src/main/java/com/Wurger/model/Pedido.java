package com.Wurger.model;

import com.fasterxml.jackson.annotation.JsonFormat;
import jakarta.persistence.*;
import lombok.Getter;
import lombok.Setter;
import java.time.LocalDateTime;

@Entity
@Table(name = "pedido")
@Getter
@Setter
public class Pedido {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_pedido")
    private Integer id;

    @Column(nullable = false)
    @JsonFormat(pattern = "yyyy-MM-dd'T'HH:mm:ss")
    private LocalDateTime fecha;

    @Column(length = 255)
    private String observaciones;

    @Enumerated(EnumType.STRING)
    @Column(length = 20)
    private EstadoPedido estado;

    // Relación con UsuarioInfo
    @ManyToOne
    @JoinColumn(name = "id_usuario_info", nullable = false)
    private UsuarioInfo usuarioInfo;

    public enum EstadoPedido {
        Pendiente,
        Entregado,
        Cancelado
    }
}