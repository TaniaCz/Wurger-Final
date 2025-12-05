package com.Wurger.dto;

import com.Wurger.model.Usuario.Rol;
import com.Wurger.model.Usuario.Estado;
import lombok.Data;

@Data
public class UsuarioResponseDTO {
    private Integer id;
    private String email;
    private Rol rol;
    private Estado estado;
}