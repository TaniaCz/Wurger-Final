package com.Wurger.controller;

import com.Wurger.dto.ProductoTerminadoDTO;
import com.Wurger.model.ProductoTerminado;
import com.Wurger.service.ProductoTerminadoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/productos-terminados")
public class ProductoTerminadoController {

    @Autowired
    private ProductoTerminadoService terminadoService;

    @GetMapping
    public List<ProductoTerminado> getAll() {
        return terminadoService.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<ProductoTerminado> getById(@PathVariable Integer id) {
        return terminadoService.findById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PostMapping
    public ResponseEntity<?> create(@RequestBody ProductoTerminadoDTO dto) {
        try {
            return ResponseEntity.ok(terminadoService.save(dto));
        } catch (RuntimeException e) {
            return ResponseEntity.badRequest().body(e.getMessage());
        }
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> update(@PathVariable Integer id, @RequestBody ProductoTerminadoDTO dto) {
        try {
            return ResponseEntity.ok(terminadoService.update(id, dto));
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        if (terminadoService.delete(id)) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.notFound().build();
    }
}