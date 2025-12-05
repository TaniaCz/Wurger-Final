package com.Wurger.service;

import com.Wurger.dto.FormaPagoDTO;
import com.Wurger.model.FormaPago;
import com.Wurger.model.Venta;
import com.Wurger.repository.FormaPagoRepository;
import com.Wurger.repository.VentaRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class FormaPagoService {

    @Autowired
    private FormaPagoRepository formaPagoRepository;

    @Autowired
    private VentaRepository ventaRepository;

    public List<FormaPago> findAll() {
        return formaPagoRepository.findAll();
    }

    public Optional<FormaPago> findById(Integer id) {
        return formaPagoRepository.findById(id);
    }

    public FormaPago save(FormaPagoDTO dto) {
        FormaPago fp = new FormaPago();
        return mapAndSave(fp, dto);
    }

    public FormaPago update(Integer id, FormaPagoDTO dto) {
        FormaPago fp = formaPagoRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Forma de pago no encontrada"));
        return mapAndSave(fp, dto);
    }

    private FormaPago mapAndSave(FormaPago fp, FormaPagoDTO dto) {
        fp.setNombre(dto.getNombre());

        if (dto.getIdVenta() != null) {
            Venta venta = ventaRepository.findById(dto.getIdVenta())
                    .orElseThrow(() -> new RuntimeException("Venta no encontrada ID: " + dto.getIdVenta()));
            fp.setVenta(venta);
        }

        return formaPagoRepository.save(fp);
    }

    public boolean delete(Integer id) {
        if (formaPagoRepository.existsById(id)) {
            formaPagoRepository.deleteById(id);
            return true;
        }
        return false;
    }
}