package com.Wurger.controller;

import com.Wurger.model.CategoriaProducto;
import com.Wurger.service.CategoriaProductoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/categoria-productos")
public class CategoriaProductoController {

    @Autowired
    private CategoriaProductoService categoriaService;

    @GetMapping
    public List<CategoriaProducto> getAll() {
        return categoriaService.findAll();
    }

    @GetMapping("/{id}")
    public ResponseEntity<CategoriaProducto> getById(@PathVariable Integer id) {
        return categoriaService.findById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PostMapping
    public CategoriaProducto create(@RequestBody CategoriaProducto categoria) {
        return categoriaService.save(categoria);
    }

    @PutMapping("/{id}")
    public ResponseEntity<CategoriaProducto> update(@PathVariable Integer id,
            @RequestBody CategoriaProducto categoriaDetails) {
        try {
            return ResponseEntity.ok(categoriaService.update(id, categoriaDetails));
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Integer id) {
        if (categoriaService.delete(id)) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.notFound().build();
    }
}