package com.Wurger.service;

import com.Wurger.model.Usuario;
import com.Wurger.repository.UsuarioRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;
import java.util.List;
import java.util.Optional;

@Service
public class UsuarioService {

    @Autowired
    private UsuarioRepository usuarioRepository;

    // Herramienta de encriptación
    private BCryptPasswordEncoder passwordEncoder = new BCryptPasswordEncoder();

    public List<Usuario> findAll() {
        return usuarioRepository.findAll();
    }

    public Optional<Usuario> findById(Integer id) {
        return usuarioRepository.findById(id);
    }

    public Usuario save(Usuario usuario) {
        // 1. Validar si el email ya existe (opcional pero recomendado)
        // if(usuarioRepository.findByEmail(usuario.getEmail()).isPresent()) { ... }

        // 2. Encriptar contraseña (Nunca guardar texto plano)
        String passEncriptada = passwordEncoder.encode(usuario.getPassword());
        usuario.setPassword(passEncriptada);

        return usuarioRepository.save(usuario);
    }

    public Usuario update(Integer id, Usuario usuarioDetails) {
        Usuario usuarioExistente = usuarioRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Usuario no encontrado con ID: " + id));

        usuarioExistente.setEmail(usuarioDetails.getEmail());
        usuarioExistente.setRol(usuarioDetails.getRol());
        usuarioExistente.setEstado(usuarioDetails.getEstado());

        // Solo encriptamos si nos envían una nueva contraseña
        if (usuarioDetails.getPassword() != null && !usuarioDetails.getPassword().isEmpty()) {
            usuarioExistente.setPassword(passwordEncoder.encode(usuarioDetails.getPassword()));
        }

        return usuarioRepository.save(usuarioExistente);
    }

    public boolean delete(Integer id) {
        if (usuarioRepository.existsById(id)) {
            usuarioRepository.deleteById(id);
            return true;
        }
        return false;
    }
}