package com.Wurger.controller;

import com.Wurger.dto.DetalleMovimientoDTO;
import com.Wurger.model.DetalleMovimiento;
import com.Wurger.service.DetalleMovimientoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/detalle-movimientos")
public class DetalleMovimientoController {

    @Autowired
    private DetalleMovimientoService detalleService;

    @GetMapping
    public List<DetalleMovimiento> getAll() {
        return detalleService.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<DetalleMovimiento> getById(@PathVariable Integer id) {
        return detalleService.findById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PostMapping
    public ResponseEntity<?> create(@RequestBody DetalleMovimientoDTO dto) {
        try {
            return ResponseEntity.ok(detalleService.save(dto));
        } catch (RuntimeException e) {
            return ResponseEntity.badRequest().body(e.getMessage());
        }
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> update(@PathVariable Integer id, @RequestBody DetalleMovimientoDTO dto) {
        try {
            return ResponseEntity.ok(detalleService.update(id, dto));
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        if (detalleService.delete(id)) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.notFound().build();
    }
}