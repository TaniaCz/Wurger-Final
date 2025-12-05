package com.Wurger.dto;

import lombok.Data;
import java.util.List;

@Data
public class VentaRequestDTO {
    private Integer idUsuario; // El cliente o vendedor
    private String direccion; // Dirección de envío
    private String observaciones; // Notas del pedido
    private List<DetalleVentaDTO> detalles;
}