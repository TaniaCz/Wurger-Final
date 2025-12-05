package com.Wurger.service;

import com.Wurger.dto.UsuarioInfoDTO;
import com.Wurger.model.Usuario;
import com.Wurger.model.UsuarioInfo;
import com.Wurger.repository.UsuarioInfoRepository;
import com.Wurger.repository.UsuarioRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class UsuarioInfoService {

    @Autowired
    private UsuarioInfoRepository usuarioInfoRepository;

    @Autowired
    private UsuarioRepository usuarioRepository; // Necesitamos esto para buscar al padre

    public List<UsuarioInfo> findAll() {
        return usuarioInfoRepository.findAll();
    }

    public Optional<UsuarioInfo> findById(Integer id) {
        return usuarioInfoRepository.findById(id);
    }

    // Guardar usando el DTO
    public UsuarioInfo save(UsuarioInfoDTO infoDTO) {
        UsuarioInfo info = new UsuarioInfo();
        info.setNombre(infoDTO.getNombre());
        info.setTelefono(infoDTO.getTelefono());
        info.setDireccion(infoDTO.getDireccion());

        // Buscamos al usuario por el ID que nos enviaron
        if (infoDTO.getIdUsuario() != null) {
            Usuario usuario = usuarioRepository.findById(infoDTO.getIdUsuario())
                    .orElseThrow(() -> new RuntimeException("Usuario no encontrado con ID: " + infoDTO.getIdUsuario()));
            info.setUsuario(usuario);
        }

        return usuarioInfoRepository.save(info);
    }

    public UsuarioInfo update(Integer id, UsuarioInfoDTO infoDTO) {
        UsuarioInfo info = usuarioInfoRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Información no encontrada"));

        info.setNombre(infoDTO.getNombre());
        info.setTelefono(infoDTO.getTelefono());
        info.setDireccion(infoDTO.getDireccion());

        // Si quieren cambiar el usuario asociado (poco común, pero posible)
        if (infoDTO.getIdUsuario() != null) {
            Usuario usuario = usuarioRepository.findById(infoDTO.getIdUsuario())
                    .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
            info.setUsuario(usuario);
        }

        return usuarioInfoRepository.save(info);
    }

    public boolean delete(Integer id) {
        if (usuarioInfoRepository.existsById(id)) {
            usuarioInfoRepository.deleteById(id);
            return true;
        }
        return false;
    }
}