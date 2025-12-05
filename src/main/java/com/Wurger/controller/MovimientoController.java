package com.Wurger.controller;

import com.Wurger.dto.MovimientoDTO;
import com.Wurger.model.Movimiento;
import com.Wurger.service.MovimientoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/movimientos")
public class MovimientoController {

    @Autowired
    private MovimientoService movimientoService;

    @GetMapping
    public List<Movimiento> getAll() {
        return movimientoService.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<Movimiento> getById(@PathVariable Integer id) {
        return movimientoService.findById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PostMapping
    public ResponseEntity<?> create(@RequestBody MovimientoDTO dto) {
        try {
            // Esto guardará el movimiento Y actualizará el stock del producto
            // automáticamente
            Movimiento nuevoMovimiento = movimientoService.registrarMovimiento(dto);
            return ResponseEntity.ok(nuevoMovimiento);
        } catch (RuntimeException e) {
            // Devuelve error si no hay stock o no existe el producto
            return ResponseEntity.badRequest().body(e.getMessage());
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        movimientoService.delete(id);
        return ResponseEntity.noContent().build();
    }
}