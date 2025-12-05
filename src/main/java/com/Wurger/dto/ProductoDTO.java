package com.Wurger.dto;

import com.Wurger.model.Producto.Estado;
import lombok.Data;
import java.math.BigDecimal;
import java.time.LocalDate;

@Data
public class ProductoDTO {
    private Integer id;
    private String nombreProducto;
    private Integer stock;
    private Integer stockMin;
    private Integer stockMax;
    private BigDecimal precioCompra;
    private BigDecimal precioVenta;
    private Estado estado; // Enum
    private LocalDate fechaIngreso;
    private String imagen; // URL de imagen

    // IMPORTANTE: Recibimos solo el ID
    private Integer idCategoria;
}