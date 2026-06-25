package com.Wurger.service;

import com.Wurger.model.Receta;
import com.Wurger.repository.ProductoRepository;
import com.Wurger.repository.ProductoTerminadoRepository;
import com.Wurger.repository.RecetaRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class RecetaService {

    @Autowired
    private RecetaRepository recetaRepository;

    @Autowired
    private ProductoTerminadoRepository productoTerminadoRepository;

    @Autowired
    private ProductoRepository productoRepository;

    public List<Receta> findAll() {
        return recetaRepository.findAll();
    }

    public Optional<Receta> findById(Integer id) {
        return recetaRepository.findById(id);
    }

    public List<Receta> findByProductoTerminado(Integer idProductoTerminado) {
        return recetaRepository.findByProductoTerminadoId(idProductoTerminado);
    }

    public Receta save(Receta receta) {
        if (receta.getProductoTerminado() != null && receta.getProductoTerminado().getId() != null) {
            receta.setProductoTerminado(productoTerminadoRepository.findById(receta.getProductoTerminado().getId())
                .orElseThrow(() -> new RuntimeException("Plato no encontrado")));
        }
        if (receta.getProducto() != null && receta.getProducto().getId() != null) {
            receta.setProducto(productoRepository.findById(receta.getProducto().getId())
                .orElseThrow(() -> new RuntimeException("Insumo no encontrado")));
        }
        return recetaRepository.save(receta);
    }

    public void deleteById(Integer id) {
        recetaRepository.deleteById(id);
    }
}
