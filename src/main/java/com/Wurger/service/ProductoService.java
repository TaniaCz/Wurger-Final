package com.Wurger.service;

import com.Wurger.dto.ProductoDTO;
import com.Wurger.model.CategoriaProducto;
import com.Wurger.model.Producto;
import com.Wurger.repository.CategoriaProductoRepository;
import com.Wurger.repository.ProductoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class ProductoService {

    @Autowired
    private ProductoRepository productoRepository;

    @Autowired
    private CategoriaProductoRepository categoriaRepository;

    public List<Producto> findAll() {
        return productoRepository.findAll();
    }

    public Optional<Producto> findById(Integer id) {
        return productoRepository.findById(id);
    }

    // Guardar
    public Producto save(ProductoDTO dto) {
        Producto producto = new Producto();
        return mapAndSave(producto, dto);
    }

    // Actualizar
    public Producto update(Integer id, ProductoDTO dto) {
        Producto producto = productoRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Producto no encontrado"));

        return mapAndSave(producto, dto);
    }

    // Método auxiliar para no repetir código entre save y update
    private Producto mapAndSave(Producto producto, ProductoDTO dto) {
        producto.setNombreProducto(dto.getNombreProducto());
        producto.setStock(dto.getStock());
        producto.setStockMin(dto.getStockMin());
        producto.setStockMax(dto.getStockMax());
        producto.setPrecioCompra(dto.getPrecioCompra());
        producto.setPrecioVenta(dto.getPrecioVenta());
        producto.setEstado(dto.getEstado());
        producto.setFechaIngreso(dto.getFechaIngreso());
        producto.setImagen(dto.getImagen());

        // Buscamos la categoría si viene el ID
        if (dto.getIdCategoria() != null) {
            CategoriaProducto cat = categoriaRepository.findById(dto.getIdCategoria())
                    .orElseThrow(() -> new RuntimeException("Categoría no encontrada"));
            producto.setCategoria(cat);
        }

        return productoRepository.save(producto);
    }

    public boolean delete(Integer id) {
        if (productoRepository.existsById(id)) {
            productoRepository.deleteById(id);
            return true;
        }
        return false;
    }
}