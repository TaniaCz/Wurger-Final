package com.Wurger.dto;

import lombok.Data;

@Data
public class DetalleMovimientoDTO {
    private Integer id;
    private Integer cantidad;

    // Vinculación con el padre
    private Integer idMovimiento;
}