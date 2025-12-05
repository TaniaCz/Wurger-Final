package com.Wurger.service;

import com.Wurger.dto.PedidoDTO;
import com.Wurger.model.Pedido;
import com.Wurger.model.UsuarioInfo;
import com.Wurger.repository.PedidoRepository;
import com.Wurger.repository.UsuarioInfoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class PedidoService {

    @Autowired
    private PedidoRepository pedidoRepository;

    @Autowired
    private UsuarioInfoRepository usuarioInfoRepository;

    public List<Pedido> findAll() {
        return pedidoRepository.findAll();
    }

    public List<Pedido> findByUsuarioId(Integer usuarioId) {
        return pedidoRepository.findByUsuarioInfo_Usuario_Id(usuarioId);
    }

    public Optional<Pedido> findById(Integer id) {
        return pedidoRepository.findById(id);
    }

    public Pedido save(PedidoDTO dto) {
        Pedido pedido = new Pedido();
        return mapAndSave(pedido, dto);
    }

    public Pedido update(Integer id, PedidoDTO dto) {
        Pedido pedido = pedidoRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Pedido no encontrado"));
        return mapAndSave(pedido, dto);
    }

    private Pedido mapAndSave(Pedido pedido, PedidoDTO dto) {
        pedido.setFecha(dto.getFecha());
        pedido.setObservaciones(dto.getObservaciones());
        pedido.setEstado(dto.getEstado());

        if (dto.getIdUsuarioInfo() != null) {
            UsuarioInfo info = usuarioInfoRepository.findById(dto.getIdUsuarioInfo())
                    .orElseThrow(
                            () -> new RuntimeException("Usuario Info no encontrado ID: " + dto.getIdUsuarioInfo()));
            pedido.setUsuarioInfo(info);
        }

        return pedidoRepository.save(pedido);
    }

    public boolean delete(Integer id) {
        if (pedidoRepository.existsById(id)) {
            pedidoRepository.deleteById(id);
            return true;
        }
        return false;
    }
}