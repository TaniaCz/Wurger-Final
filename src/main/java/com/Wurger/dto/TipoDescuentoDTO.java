package com.Wurger.dto;

import lombok.Data;

@Data
public class TipoDescuentoDTO {
    private Integer id;
    private String nombre; // Ej: "Descuento 10% Jueves"

    // Vinculación con FormaPago
    private Integer idFormaPago;
}