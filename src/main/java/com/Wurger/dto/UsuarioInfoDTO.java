package com.Wurger.dto;

import lombok.Data;

@Data
public class UsuarioInfoDTO {
    // Datos propios de la tabla
    private Integer id;
    private String nombre;
    private String telefono;
    private String direccion;

    // IMPORTANTE: Solo recibimos el ID del usuario padre
    private Integer idUsuario;
}