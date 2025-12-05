package com.Wurger.controller;

import com.Wurger.dto.UnidadMedidaDTO;
import com.Wurger.model.UnidadMedida;
import com.Wurger.service.UnidadMedidaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/unidades-medida")
public class UnidadMedidaController {

    @Autowired
    private UnidadMedidaService unidadService;

    @GetMapping
    public List<UnidadMedida> getAll() {
        return unidadService.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<UnidadMedida> getById(@PathVariable Integer id) {
        return unidadService.findById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PostMapping
    public ResponseEntity<?> create(@RequestBody UnidadMedidaDTO dto) {
        try {
            return ResponseEntity.ok(unidadService.save(dto));
        } catch (RuntimeException e) {
            return ResponseEntity.badRequest().body(e.getMessage());
        }
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> update(@PathVariable Integer id, @RequestBody UnidadMedidaDTO dto) {
        try {
            return ResponseEntity.ok(unidadService.update(id, dto));
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        if (unidadService.delete(id)) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.notFound().build();
    }
}