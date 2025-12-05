package com.Wurger.service;

import com.Wurger.model.CategoriaProducto;
import com.Wurger.repository.CategoriaProductoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class CategoriaProductoService {

    @Autowired
    private CategoriaProductoRepository categoriaRepository;

    public List<CategoriaProducto> findAll() {
        return categoriaRepository.findAll();
    }

    public Optional<CategoriaProducto> findById(Integer id) {
        return categoriaRepository.findById(id);
    }

    public CategoriaProducto save(CategoriaProducto categoria) {
        // Aquí podrías validar que no exista otra categoría con el mismo nombre
        return categoriaRepository.save(categoria);
    }

    public CategoriaProducto update(Integer id, CategoriaProducto categoriaDetails) {
        CategoriaProducto categoria = categoriaRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Categoría no encontrada"));

        categoria.setNombreCategoria(categoriaDetails.getNombreCategoria());
        // Nota: Idealmente 'cantidadCategoria' debería calcularse sola,
        // pero respetamos tu lógica actual de editarla manualmente.
        categoria.setCantidadCategoria(categoriaDetails.getCantidadCategoria());

        return categoriaRepository.save(categoria);
    }

    public boolean delete(Integer id) {
        if (categoriaRepository.existsById(id)) {
            // OJO: Al tener CascadeType.ALL en el modelo,
            // si borras la categoría, se borrarán sus productos.
            // Asegúrate de que eso es lo que quieres.
            categoriaRepository.deleteById(id);
            return true;
        }
        return false;
    }
}