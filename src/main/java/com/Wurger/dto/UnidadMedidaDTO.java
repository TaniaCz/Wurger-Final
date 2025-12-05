package com.Wurger.dto;

import lombok.Data;

@Data
public class UnidadMedidaDTO {
    private Integer id;
    private String nombre;
    private Integer cantidad; // Ej: 12 si es una docena

    // El vínculo con el producto padre
    private Integer idProducto;
}