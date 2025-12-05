package com.Wurger.dto;

import com.Wurger.model.ProductoTerminado.Estado;
import lombok.Data;
import java.math.BigDecimal;
import java.time.LocalDate;

@Data
public class ProductoTerminadoDTO {
    private Integer id;
    private String nombre;
    private String descripcion;
    private String categoria;
    private BigDecimal costo;
    private BigDecimal precio;
    private Integer stockActual;
    private Integer stockMin;
    private Estado estado;
    private LocalDate fechaIngreso;

    // IMPORTANTE: Para vincular con la tabla Producto
    private Integer idProducto;
}