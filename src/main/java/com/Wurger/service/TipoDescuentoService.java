package com.Wurger.service;

import com.Wurger.dto.TipoDescuentoDTO;
import com.Wurger.model.FormaPago;
import com.Wurger.model.TipoDescuento;
import com.Wurger.repository.FormaPagoRepository;
import com.Wurger.repository.TipoDescuentoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class TipoDescuentoService {

    @Autowired
    private TipoDescuentoRepository tipoDescuentoRepository;

    @Autowired
    private FormaPagoRepository formaPagoRepository;

    public List<TipoDescuento> findAll() {
        return tipoDescuentoRepository.findAll();
    }

    public Optional<TipoDescuento> findById(Integer id) {
        return tipoDescuentoRepository.findById(id);
    }

    public TipoDescuento save(TipoDescuentoDTO dto) {
        TipoDescuento td = new TipoDescuento();
        return mapAndSave(td, dto);
    }

    public TipoDescuento update(Integer id, TipoDescuentoDTO dto) {
        TipoDescuento td = tipoDescuentoRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Tipo de descuento no encontrado"));
        return mapAndSave(td, dto);
    }

    private TipoDescuento mapAndSave(TipoDescuento td, TipoDescuentoDTO dto) {
        td.setNombre(dto.getNombre());

        if (dto.getIdFormaPago() != null) {
            FormaPago fp = formaPagoRepository.findById(dto.getIdFormaPago())
                    .orElseThrow(() -> new RuntimeException("Forma de Pago no encontrada ID: " + dto.getIdFormaPago()));
            td.setFormaPago(fp);
        }

        return tipoDescuentoRepository.save(td);
    }

    public boolean delete(Integer id) {
        if (tipoDescuentoRepository.existsById(id)) {
            tipoDescuentoRepository.deleteById(id);
            return true;
        }
        return false;
    }
}