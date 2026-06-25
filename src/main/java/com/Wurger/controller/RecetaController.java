package com.Wurger.controller;

import com.Wurger.model.Receta;
import com.Wurger.service.RecetaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/api/recetas")
@CrossOrigin(origins = "*")
public class RecetaController {

    @Autowired
    private RecetaService recetaService;

    @GetMapping
    public List<Receta> getAllRecetas() {
        return recetaService.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<Receta> getRecetaById(@PathVariable Integer id) {
        Optional<Receta> receta = recetaService.findById(id);
        return receta.map(ResponseEntity::ok).orElseGet(() -> ResponseEntity.notFound().build());
    }

    @GetMapping("/producto-terminado/{id}")
    public List<Receta> getRecetasByProductoTerminado(@PathVariable Integer id) {
        return recetaService.findByProductoTerminado(id);
    }

    @PostMapping
    public Receta createReceta(@RequestBody Receta receta) {
        return recetaService.save(receta);
    }

    @PutMapping("/{id}")
    public ResponseEntity<Receta> updateReceta(@PathVariable Integer id, @RequestBody Receta recetaDetails) {
        Optional<Receta> receta = recetaService.findById(id);
        if (receta.isPresent()) {
            Receta updatedReceta = receta.get();
            updatedReceta.setCantidadUsada(recetaDetails.getCantidadUsada());
            updatedReceta.setProducto(recetaDetails.getProducto());
            updatedReceta.setProductoTerminado(recetaDetails.getProductoTerminado());
            return ResponseEntity.ok(recetaService.save(updatedReceta));
        } else {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteReceta(@PathVariable Integer id) {
        recetaService.deleteById(id);
        return ResponseEntity.noContent().build();
    }
}
