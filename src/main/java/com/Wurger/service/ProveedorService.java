package com.Wurger.service;

import com.Wurger.dto.ProveedorDTO;
import com.Wurger.model.Proveedor;
import com.Wurger.model.Usuario;
import com.Wurger.repository.ProveedorRepository;
import com.Wurger.repository.UsuarioRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class ProveedorService {

    @Autowired
    private ProveedorRepository proveedorRepository;

    @Autowired
    private UsuarioRepository usuarioRepository;

    public List<Proveedor> findAll() {
        return proveedorRepository.findAll();
    }

    public Optional<Proveedor> findById(Integer id) {
        return proveedorRepository.findById(id);
    }

    public Proveedor save(ProveedorDTO dto) {
        Proveedor p = new Proveedor();
        return mapAndSave(p, dto);
    }

    public Proveedor update(Integer id, ProveedorDTO dto) {
        Proveedor p = proveedorRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Proveedor no encontrado"));
        return mapAndSave(p, dto);
    }

    private Proveedor mapAndSave(Proveedor p, ProveedorDTO dto) {
        p.setNombre(dto.getNombre());
        p.setTelefono(dto.getTelefono());
        p.setEmail(dto.getEmail());
        p.setDireccion(dto.getDireccion());
        p.setEstado(dto.getEstado());

        // Vinculación con Usuario (Opcional según tu SQL)
        if (dto.getIdUsuario() != null) {
            Usuario u = usuarioRepository.findById(dto.getIdUsuario())
                    .orElseThrow(() -> new RuntimeException("Usuario no encontrado ID: " + dto.getIdUsuario()));
            p.setUsuario(u);
        } else {
            p.setUsuario(null); // Permitir desvincular si mandan null
        }

        return proveedorRepository.save(p);
    }

    public boolean delete(Integer id) {
        if (proveedorRepository.existsById(id)) {
            proveedorRepository.deleteById(id);
            return true;
        }
        return false;
    }
}