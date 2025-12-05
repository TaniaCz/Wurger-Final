package com.Wurger.dto;

import com.Wurger.model.Movimiento.TipoMovimiento;
import lombok.Data;
import java.time.LocalDate;

@Data
public class MovimientoDTO {
    private Integer id;
    private TipoMovimiento tipo; // Entrada o Salida
    private Integer cantidad;
    private LocalDate fecha;
    private String descripcion;

    // IMPORTANTE: El ID del producto que vamos a afectar
    private Integer idProducto;
}