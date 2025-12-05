package com.Wurger.service;

import com.Wurger.dto.PromocionDTO;
import com.Wurger.model.Producto;
import com.Wurger.model.Promocion;
import com.Wurger.repository.ProductoRepository;
import com.Wurger.repository.PromocionRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class PromocionService {

    @Autowired
    private PromocionRepository promocionRepository;

    @Autowired
    private ProductoRepository productoRepository;

    public List<Promocion> findAll() {
        return promocionRepository.findAll();
    }

    public Optional<Promocion> findById(Integer id) {
        return promocionRepository.findById(id);
    }

    public Promocion save(PromocionDTO dto) {
        Promocion p = new Promocion();
        return mapAndSave(p, dto);
    }

    public Promocion update(Integer id, PromocionDTO dto) {
        Promocion p = promocionRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Promoción no encontrada"));
        return mapAndSave(p, dto);
    }

    private Promocion mapAndSave(Promocion p, PromocionDTO dto) {
        p.setNombre(dto.getNombre());
        p.setInicio(dto.getInicio());
        p.setFin(dto.getFin());
        p.setCantidadUsos(dto.getCantidadUsos());
        p.setEstado(dto.getEstado());
        p.setDescripcion(dto.getDescripcion());
        p.setDescuento(dto.getDescuento());
        p.setTipoDescuento(dto.getTipoDescuento());

        if (dto.getIdProducto() != null) {
            Producto prod = productoRepository.findById(dto.getIdProducto())
                    .orElseThrow(() -> new RuntimeException("Producto no encontrado ID: " + dto.getIdProducto()));
            p.setProducto(prod);
        }

        return promocionRepository.save(p);
    }

    public boolean delete(Integer id) {
        if (promocionRepository.existsById(id)) {
            promocionRepository.deleteById(id);
            return true;
        }
        return false;
    }
}