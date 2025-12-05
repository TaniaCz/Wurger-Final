package com.Wurger.controller;

import com.Wurger.model.CategoriaProducto;
import com.Wurger.repository.CategoriaProductoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/categorias")
public class CategoriaController {

    @Autowired
    private CategoriaProductoRepository categoriaRepository;

    @GetMapping
    public List<CategoriaProducto> getAll() {
        return categoriaRepository.findAll();
    }
}
