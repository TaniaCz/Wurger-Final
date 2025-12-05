package com.Wurger.config;

import com.Wurger.model.Usuario;
import com.Wurger.model.UsuarioInfo;
import com.Wurger.model.CategoriaProducto;
import com.Wurger.repository.UsuarioInfoRepository;
import com.Wurger.repository.UsuarioRepository;
import com.Wurger.repository.CategoriaProductoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.stereotype.Component;

@Component
public class DataInitializer implements CommandLineRunner {

    @Autowired
    private UsuarioRepository usuarioRepository;

    @Autowired
    private UsuarioInfoRepository usuarioInfoRepository;

    @Autowired
    private com.Wurger.service.UsuarioService usuarioService;

    @Autowired
    private CategoriaProductoRepository categoriaRepository;

    @Override
    public void run(String... args) throws Exception {
        // Crear categorías por defecto
        String[] categorias = { "Comida Rápida", "Bebidas", "Postres", "Acompañamientos" };
        for (String nombreCat : categorias) {
            boolean existe = false;
            for (CategoriaProducto c : categoriaRepository.findAll()) {
                if (c.getNombreCategoria().equalsIgnoreCase(nombreCat)) {
                    existe = true;
                    break;
                }
            }

            if (!existe) {
                CategoriaProducto cat = new CategoriaProducto();
                cat.setNombreCategoria(nombreCat);
                cat.setCantidadCategoria(0);
                categoriaRepository.save(cat);
                System.out.println("✅ Categoría creada: " + nombreCat);
            }
        }

        // Verificar si el admin ya existe
        if (usuarioRepository.findByEmail("Wurger@admin.com").isEmpty()) {
            // Crear usuario admin
            Usuario admin = new Usuario();
            admin.setEmail("Wurger@admin.com");
            admin.setPassword("Wurger101010.");
            admin.setRol(Usuario.Rol.Administrador);
            admin.setEstado(Usuario.Estado.Activo);

            Usuario adminGuardado = usuarioService.save(admin);

            // Crear info del admin
            UsuarioInfo adminInfo = new UsuarioInfo();
            adminInfo.setNombre("Admin Default");
            adminInfo.setTelefono("0000000000");
            adminInfo.setDireccion("Wurger HQ");
            adminInfo.setUsuario(adminGuardado);

            usuarioInfoRepository.save(adminInfo);

            System.out.println("✅ Usuario administrador creado: Wurger@admin.com");
        } else {
            System.out.println("ℹ️ Usuario administrador ya existe");
        }
    }
}
