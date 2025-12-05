package com.Wurger.controller;

import com.Wurger.dto.TipoDescuentoDTO;
import com.Wurger.model.TipoDescuento;
import com.Wurger.service.TipoDescuentoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/tipos-descuento")
public class TipoDescuentoController {

    @Autowired
    private TipoDescuentoService tipoDescuentoService;

    @GetMapping
    public List<TipoDescuento> getAll() {
        return tipoDescuentoService.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<TipoDescuento> getById(@PathVariable Integer id) {
        return tipoDescuentoService.findById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PostMapping
    public ResponseEntity<?> create(@RequestBody TipoDescuentoDTO dto) {
        try {
            return ResponseEntity.ok(tipoDescuentoService.save(dto));
        } catch (RuntimeException e) {
            return ResponseEntity.badRequest().body(e.getMessage());
        }
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> update(@PathVariable Integer id, @RequestBody TipoDescuentoDTO dto) {
        try {
            return ResponseEntity.ok(tipoDescuentoService.update(id, dto));
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        if (tipoDescuentoService.delete(id)) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.notFound().build();
    }
}