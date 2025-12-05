package com.Wurger.dto;

import com.Wurger.model.Promocion.EstadoPromocion;
import lombok.Data;
import java.time.LocalDate;

@Data
public class PromocionDTO {
    private Integer id;
    private String nombre;
    private LocalDate inicio;
    private LocalDate fin;
    private Integer cantidadUsos;
    private EstadoPromocion estado;
    private String descripcion;
    private Double descuento;
    private String tipoDescuento;

    // Producto al que se le aplica la promoción
    private Integer idProducto;
}