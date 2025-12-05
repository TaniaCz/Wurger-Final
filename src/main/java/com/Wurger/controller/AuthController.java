package com.Wurger.controller;

import com.Wurger.dto.LoginRequestDTO;
import com.Wurger.dto.UsuarioResponseDTO;
import com.Wurger.model.Usuario;
import com.Wurger.repository.UsuarioRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import jakarta.validation.Valid;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;
import java.util.stream.Collectors;

@RestController
@RequestMapping("/api/auth")
public class AuthController {

    @Autowired
    private UsuarioRepository usuarioRepository;

    @Autowired
    private com.Wurger.service.UsuarioService usuarioService;

    @Autowired
    private com.Wurger.repository.UsuarioInfoRepository usuarioInfoRepository;

    // Herramienta para comparar contraseñas encriptadas
    private BCryptPasswordEncoder passwordEncoder = new BCryptPasswordEncoder();

    @PostMapping("/register")
    public ResponseEntity<?> register(@Valid @RequestBody com.Wurger.dto.RegisterRequestDTO registerRequest,
            BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            String errors = bindingResult.getAllErrors().stream()
                    .map(error -> error.getDefaultMessage())
                    .collect(Collectors.joining(", "));
            return ResponseEntity.badRequest().body(errors);
        }

        if (usuarioRepository.findByEmail(registerRequest.getEmail()).isPresent()) {
            return ResponseEntity.badRequest().body("El email ya está registrado");
        }

        Usuario usuario = new Usuario();
        usuario.setEmail(registerRequest.getEmail());
        usuario.setPassword(registerRequest.getPassword());
        usuario.setRol(Usuario.Rol.Usuario);
        usuario.setEstado(Usuario.Estado.Activo);

        Usuario nuevoUsuario = usuarioService.save(usuario);

        com.Wurger.model.UsuarioInfo info = new com.Wurger.model.UsuarioInfo();
        info.setNombre(registerRequest.getNombre());
        info.setTelefono(registerRequest.getTelefono());
        info.setDireccion(registerRequest.getDireccion());
        info.setUsuario(nuevoUsuario);

        usuarioInfoRepository.save(info);

        return ResponseEntity.ok("Usuario registrado exitosamente");
    }

    @PostMapping("/login")
    public ResponseEntity<?> login(@RequestBody LoginRequestDTO loginRequest) {
        // 1. Buscar si el email existe en la BD
        Usuario usuario = usuarioRepository.findByEmail(loginRequest.getEmail())
                .orElse(null);

        // Si no existe el usuario
        if (usuario == null) {
            return ResponseEntity.status(401).body("Usuario o contraseña incorrectos");
        }

        // 2. Comparar contraseña (la que escriben vs la encriptada en BD)
        if (passwordEncoder.matches(loginRequest.getPassword(), usuario.getPassword())) {

            // 3. Verificar si el usuario está activo
            if (usuario.getEstado() == Usuario.Estado.Inactivo) {
                return ResponseEntity.status(403).body("Usuario inactivo. Contacte al administrador.");
            }

            // ¡LOGIN EXITOSO!
            // Preparamos la respuesta (DTO) sin devolver el password
            UsuarioResponseDTO response = new UsuarioResponseDTO();
            response.setId(usuario.getId());
            response.setEmail(usuario.getEmail());
            response.setRol(usuario.getRol());
            response.setEstado(usuario.getEstado());

            return ResponseEntity.ok(response);
        } else {
            // Contraseña incorrecta
            return ResponseEntity.status(401).body("Usuario o contraseña incorrectos");
        }
    }
}