package com.Wurger.service;

import com.Wurger.dto.UnidadMedidaDTO;
import com.Wurger.model.Producto;
import com.Wurger.model.UnidadMedida;
import com.Wurger.repository.ProductoRepository;
import com.Wurger.repository.UnidadMedidaRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class UnidadMedidaService {

    @Autowired
    private UnidadMedidaRepository unidadRepository;

    @Autowired
    private ProductoRepository productoRepository;

    public List<UnidadMedida> findAll() {
        return unidadRepository.findAll();
    }

    public Optional<UnidadMedida> findById(Integer id) {
        return unidadRepository.findById(id);
    }

    public UnidadMedida save(UnidadMedidaDTO dto) {
        UnidadMedida unidad = new UnidadMedida();
        return mapAndSave(unidad, dto);
    }

    public UnidadMedida update(Integer id, UnidadMedidaDTO dto) {
        UnidadMedida unidad = unidadRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Unidad de medida no encontrada"));
        return mapAndSave(unidad, dto);
    }

    private UnidadMedida mapAndSave(UnidadMedida unidad, UnidadMedidaDTO dto) {
        unidad.setNombre(dto.getNombre());
        unidad.setCantidad(dto.getCantidad());

        if (dto.getIdProducto() != null) {
            Producto producto = productoRepository.findById(dto.getIdProducto())
                    .orElseThrow(() -> new RuntimeException("Producto no encontrado ID: " + dto.getIdProducto()));
            unidad.setProducto(producto);
        }

        return unidadRepository.save(unidad);
    }

    public boolean delete(Integer id) {
        if (unidadRepository.existsById(id)) {
            unidadRepository.deleteById(id);
            return true;
        }
        return false;
    }
}