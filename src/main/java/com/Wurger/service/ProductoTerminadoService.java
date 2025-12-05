package com.Wurger.service;

import com.Wurger.dto.ProductoTerminadoDTO;
import com.Wurger.model.Producto;
import com.Wurger.model.ProductoTerminado;
import com.Wurger.repository.ProductoRepository;
import com.Wurger.repository.ProductoTerminadoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class ProductoTerminadoService {

    @Autowired
    private ProductoTerminadoRepository terminadoRepository;

    @Autowired
    private ProductoRepository productoRepository;

    public List<ProductoTerminado> findAll() {
        return terminadoRepository.findAll();
    }

    public Optional<ProductoTerminado> findById(Integer id) {
        return terminadoRepository.findById(id);
    }

    public ProductoTerminado save(ProductoTerminadoDTO dto) {
        ProductoTerminado pt = new ProductoTerminado();
        return mapAndSave(pt, dto);
    }

    public ProductoTerminado update(Integer id, ProductoTerminadoDTO dto) {
        ProductoTerminado pt = terminadoRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Producto Terminado no encontrado"));
        return mapAndSave(pt, dto);
    }

    private ProductoTerminado mapAndSave(ProductoTerminado pt, ProductoTerminadoDTO dto) {
        pt.setNombre(dto.getNombre());
        pt.setDescripcion(dto.getDescripcion());
        pt.setCategoria(dto.getCategoria());
        pt.setCosto(dto.getCosto());
        pt.setPrecio(dto.getPrecio());
        pt.setStockActual(dto.getStockActual());
        pt.setStockMin(dto.getStockMin());
        pt.setEstado(dto.getEstado());
        pt.setFechaIngreso(dto.getFechaIngreso());

        // Vinculación con Producto Padre
        if (dto.getIdProducto() != null) {
            Producto productoPadre = productoRepository.findById(dto.getIdProducto())
                    .orElseThrow(() -> new RuntimeException("Producto padre no encontrado ID: " + dto.getIdProducto()));
            pt.setProducto(productoPadre);
        }

        return terminadoRepository.save(pt);
    }

    public boolean delete(Integer id) {
        if (terminadoRepository.existsById(id)) {
            terminadoRepository.deleteById(id);
            return true;
        }
        return false;
    }
}