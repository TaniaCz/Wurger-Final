package com.Wurger.dto;

import com.Wurger.model.Pedido.EstadoPedido;
import lombok.Data;
import java.time.LocalDateTime;

@Data
public class PedidoDTO {
    private Integer id;
    private LocalDateTime fecha;
    private String observaciones;
    private EstadoPedido estado;

    // Vinculación con UsuarioInfo (Cliente)
    private Integer idUsuarioInfo;
}