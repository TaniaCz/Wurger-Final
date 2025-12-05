package com.Wurger.controller;

import com.Wurger.dto.UsuarioInfoDTO;
import com.Wurger.model.UsuarioInfo;
import com.Wurger.service.UsuarioInfoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/usuario-info")
public class UsuarioInfoController {

    @Autowired
    private UsuarioInfoService usuarioInfoService;

    @GetMapping
    public List<UsuarioInfo> getAll() {
        // Nota: Al devolver la entidad directa aquí, asegúrate de tener @JsonIgnore
        // en la clase Usuario o se hará un bucle infinito.
        return usuarioInfoService.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<UsuarioInfo> getById(@PathVariable Integer id) {
        return usuarioInfoService.findById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PostMapping
    public ResponseEntity<?> create(@RequestBody UsuarioInfoDTO infoDTO) {
        try {
            UsuarioInfo nuevoInfo = usuarioInfoService.save(infoDTO);
            return ResponseEntity.ok(nuevoInfo);
        } catch (RuntimeException e) {
            // Retorna error 400 si el usuario no existe
            return ResponseEntity.badRequest().body(e.getMessage());
        }
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> update(@PathVariable Integer id, @RequestBody UsuarioInfoDTO infoDTO) {
        try {
            UsuarioInfo actualizado = usuarioInfoService.update(id, infoDTO);
            return ResponseEntity.ok(actualizado);
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        if (usuarioInfoService.delete(id)) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.notFound().build();
    }
}