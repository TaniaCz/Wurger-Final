package com.Wurger.dto;

import lombok.Data;

@Data
public class FormaPagoDTO {
    private Integer id;
    private String nombre; // Ej: "Efectivo", "Tarjeta"

    // Vinculación con la Venta
    private Integer idVenta;
}