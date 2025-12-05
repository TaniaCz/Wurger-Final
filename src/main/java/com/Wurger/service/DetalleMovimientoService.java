package com.Wurger.service;

import com.Wurger.dto.DetalleMovimientoDTO;
import com.Wurger.model.DetalleMovimiento;
import com.Wurger.model.Movimiento;
import com.Wurger.repository.DetalleMovimientoRepository;
import com.Wurger.repository.MovimientoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class DetalleMovimientoService {

    @Autowired
    private DetalleMovimientoRepository detalleRepository;

    @Autowired
    private MovimientoRepository movimientoRepository;

    public List<DetalleMovimiento> findAll() {
        return detalleRepository.findAll();
    }

    public Optional<DetalleMovimiento> findById(Integer id) {
        return detalleRepository.findById(id);
    }

    public DetalleMovimiento save(DetalleMovimientoDTO dto) {
        DetalleMovimiento detalle = new DetalleMovimiento();
        return mapAndSave(detalle, dto);
    }

    public DetalleMovimiento update(Integer id, DetalleMovimientoDTO dto) {
        DetalleMovimiento detalle = detalleRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Detalle no encontrado"));
        return mapAndSave(detalle, dto);
    }

    private DetalleMovimiento mapAndSave(DetalleMovimiento detalle, DetalleMovimientoDTO dto) {
        detalle.setCantidad(dto.getCantidad());

        if (dto.getIdMovimiento() != null) {
            Movimiento movimiento = movimientoRepository.findById(dto.getIdMovimiento())
                    .orElseThrow(
                            () -> new RuntimeException("Movimiento padre no encontrado ID: " + dto.getIdMovimiento()));
            detalle.setMovimiento(movimiento);
        }

        return detalleRepository.save(detalle);
    }

    public boolean delete(Integer id) {
        if (detalleRepository.existsById(id)) {
            detalleRepository.deleteById(id);
            return true;
        }
        return false;
    }
}