package com.Wurger.controller;

import com.Wurger.dto.FormaPagoDTO;
import com.Wurger.model.FormaPago;
import com.Wurger.service.FormaPagoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/formas-pago")
public class FormaPagoController {

    @Autowired
    private FormaPagoService formaPagoService;

    @GetMapping
    public List<FormaPago> getAll() {
        return formaPagoService.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<FormaPago> getById(@PathVariable Integer id) {
        return formaPagoService.findById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PostMapping
    public ResponseEntity<?> create(@RequestBody FormaPagoDTO dto) {
        try {
            return ResponseEntity.ok(formaPagoService.save(dto));
        } catch (RuntimeException e) {
            return ResponseEntity.badRequest().body(e.getMessage());
        }
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> update(@PathVariable Integer id, @RequestBody FormaPagoDTO dto) {
        try {
            return ResponseEntity.ok(formaPagoService.update(id, dto));
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        if (formaPagoService.delete(id)) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.notFound().build();
    }
}