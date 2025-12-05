package com.Wurger.controller;

import com.Wurger.dto.VentaRequestDTO;
import com.Wurger.model.Venta;
import com.Wurger.service.VentaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/ventas")
public class VentaController {

    @Autowired
    private VentaService ventaService;

    @GetMapping
    public ResponseEntity<?> getAll() {
        try {
            return ResponseEntity.ok(ventaService.findAll());
        } catch (Exception e) {
            e.printStackTrace(); // Log to server console
            return ResponseEntity.internalServerError().body("Error al obtener ventas: " + e.getMessage());
        }
    }

    @GetMapping("/usuario/{id}")
    public List<Venta> getByUsuarioId(@PathVariable Integer id) {
        return ventaService.findByUsuarioId(id);
    }

    @PostMapping
    public ResponseEntity<?> crearVenta(@RequestBody VentaRequestDTO ventaDTO) {
        try {
            Venta nuevaVenta = ventaService.crearVenta(ventaDTO);
            return ResponseEntity.ok(nuevaVenta);
        } catch (RuntimeException e) {
            return ResponseEntity.badRequest().body(e.getMessage());
        }
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> updateEstado(@PathVariable Integer id, @RequestBody java.util.Map<String, String> body) {
        try {
            String nuevoEstado = body.get("estado");
            Venta ventaActualizada = ventaService.updateEstado(id, nuevoEstado);
            return ResponseEntity.ok(ventaActualizada);
        } catch (RuntimeException e) {
            return ResponseEntity.badRequest().body(e.getMessage());
        }
    }
}