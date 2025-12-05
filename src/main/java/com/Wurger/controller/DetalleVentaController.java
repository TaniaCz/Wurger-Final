package com.Wurger.controller;

import com.Wurger.model.DetalleVenta;
import com.Wurger.repository.DetalleVentaRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/api/detalle-ventas")
public class DetalleVentaController {

    @Autowired
    private DetalleVentaRepository detalleVentaRepository;

    @GetMapping
    public List<DetalleVenta> getAll() {
        return detalleVentaRepository.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<DetalleVenta> getById(@PathVariable Integer id) {
        Optional<DetalleVenta> detalle = detalleVentaRepository.findById(id);
        return detalle.map(ResponseEntity::ok).orElse(ResponseEntity.notFound().build());
    }

    @PostMapping
    public DetalleVenta create(@RequestBody DetalleVenta detalle) {
        return detalleVentaRepository.save(detalle);
    }

    @PutMapping("/{id}")
    public ResponseEntity<DetalleVenta> update(@PathVariable Integer id, @RequestBody DetalleVenta details) {
        Optional<DetalleVenta> optional = detalleVentaRepository.findById(id);
        if (!optional.isPresent())
            return ResponseEntity.notFound().build();

        DetalleVenta detalle = optional.get();
        detalle.setCantidad(details.getCantidad());
        detalle.setPrecioUnitario(details.getPrecioUnitario());
        detalle.setSubtotal(details.getSubtotal());
        detalle.setDescuento(details.getDescuento());
        detalle.setVenta(details.getVenta());

        return ResponseEntity.ok(detalleVentaRepository.save(detalle));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        if (!detalleVentaRepository.existsById(id))
            return ResponseEntity.notFound().build();
        detalleVentaRepository.deleteById(id);
        return ResponseEntity.noContent().build();
    }
}
