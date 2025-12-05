package com.Wurger.dto;

import com.Wurger.model.Proveedor.Estado;
import lombok.Data;

@Data
public class ProveedorDTO {
    private Integer id;
    private String nombre;
    private String telefono;
    private String email;
    private String direccion;
    private Estado estado;

    // Relación opcional con Usuario
    private Integer idUsuario;
}