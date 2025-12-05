package com.Wurger.controller;

import com.Wurger.dto.UsuarioResponseDTO;
import com.Wurger.model.Usuario;
import com.Wurger.service.UsuarioService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.stream.Collectors;

@RestController
@RequestMapping("/api/usuarios")
public class UsuarioController {

    @Autowired
    private UsuarioService usuarioService;

    // GET all - Devolvemos DTOs para no mostrar passwords
    @GetMapping
    public List<UsuarioResponseDTO> getAll() {
        return usuarioService.findAll().stream().map(usuario -> {
            UsuarioResponseDTO dto = new UsuarioResponseDTO();
            dto.setId(usuario.getId());
            dto.setEmail(usuario.getEmail());
            dto.setRol(usuario.getRol());
            dto.setEstado(usuario.getEstado());
            return dto;
        }).collect(Collectors.toList());
    }

    // GET by id
    @GetMapping("/{id}")
    public ResponseEntity<UsuarioResponseDTO> getById(@PathVariable Integer id) {
        return usuarioService.findById(id)
                .map(usuario -> {
                    UsuarioResponseDTO dto = new UsuarioResponseDTO();
                    dto.setId(usuario.getId());
                    dto.setEmail(usuario.getEmail());
                    dto.setRol(usuario.getRol());
                    dto.setEstado(usuario.getEstado());
                    return ResponseEntity.ok(dto);
                })
                .orElse(ResponseEntity.notFound().build());
    }

    // POST create
    @PostMapping
    public ResponseEntity<UsuarioResponseDTO> create(@RequestBody Usuario usuario) {
        Usuario nuevoUsuario = usuarioService.save(usuario);

        // Convertimos a DTO para la respuesta
        UsuarioResponseDTO dto = new UsuarioResponseDTO();
        dto.setId(nuevoUsuario.getId());
        dto.setEmail(nuevoUsuario.getEmail());
        dto.setRol(nuevoUsuario.getRol());
        dto.setEstado(nuevoUsuario.getEstado());

        return ResponseEntity.ok(dto);
    }

    // PUT update
    @PutMapping("/{id}")
    public ResponseEntity<?> update(@PathVariable Integer id, @RequestBody Usuario usuarioDetails) {
        try {
            Usuario actualizado = usuarioService.update(id, usuarioDetails);
            // Convertir a DTO rápido
            UsuarioResponseDTO dto = new UsuarioResponseDTO();
            dto.setId(actualizado.getId());
            dto.setEmail(actualizado.getEmail());
            dto.setRol(actualizado.getRol());
            dto.setEstado(actualizado.getEstado());
            return ResponseEntity.ok(dto);
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }

    // DELETE
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        if (usuarioService.delete(id)) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.notFound().build();
    }
}