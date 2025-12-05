package com.Wurger.service;

import com.Wurger.dto.DetalleVentaDTO;
import com.Wurger.dto.VentaRequestDTO;
import com.Wurger.model.*;
import com.Wurger.repository.ProductoRepository;
import com.Wurger.repository.UsuarioRepository;
import com.Wurger.repository.VentaRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.math.BigDecimal;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

@Service
public class VentaService {

    @Autowired
    private VentaRepository ventaRepository;

    @Autowired
    private UsuarioRepository usuarioRepository;

    @Autowired
    private ProductoRepository productoRepository;

    @Transactional
    public Venta crearVenta(VentaRequestDTO ventaDTO) {
        // 1. Crear la Cabecera de Venta
        Venta venta = new Venta();
        venta.setFecha(LocalDateTime.now());
        venta.setEstado(Venta.EstadoVenta.Pendiente); // O Pagada, según tu flujo

        // Buscar Usuario
        Usuario usuario = usuarioRepository.findById(ventaDTO.getIdUsuario())
                .orElseThrow(() -> new RuntimeException("Usuario no encontrado ID: " + ventaDTO.getIdUsuario()));
        venta.setUsuario(usuario);

        // Guardar dirección y observaciones
        venta.setDireccion(ventaDTO.getDireccion());
        venta.setObservaciones(ventaDTO.getObservaciones());

        // 2. Procesar Detalles
        BigDecimal totalVenta = BigDecimal.ZERO;
        List<DetalleVenta> detallesEntidad = new ArrayList<>();

        for (DetalleVentaDTO item : ventaDTO.getDetalles()) {
            Producto producto = productoRepository.findById(item.getIdProducto())
                    .orElseThrow(() -> new RuntimeException("Producto no encontrado ID: " + item.getIdProducto()));

            // A) Validar Stock (no descontar aún, se descuenta al completar)
            if (producto.getStock() < item.getCantidad()) {
                throw new RuntimeException("Stock insuficiente para: " + producto.getNombreProducto());
            }

            // B) NO descontar stock aquí - se descontará cuando el pedido se marque como
            // "Completada"
            // producto.setStock(producto.getStock() - item.getCantidad());
            // productoRepository.save(producto);

            // C) Crear Detalle
            DetalleVenta detalle = new DetalleVenta();
            detalle.setCantidad(item.getCantidad());
            detalle.setPrecioUnitario(producto.getPrecioVenta());

            // Cálculos
            BigDecimal subtotal = producto.getPrecioVenta().multiply(new BigDecimal(item.getCantidad()));
            BigDecimal descuento = item.getDescuento() != null ? item.getDescuento() : BigDecimal.ZERO;

            detalle.setDescuento(descuento);
            detalle.setSubtotal(subtotal.subtract(descuento));

            // Relación Bidireccional
            detalle.setVenta(venta); // Importante: Asignar el padre al hijo
            detalle.setProducto(producto);
            detallesEntidad.add(detalle);

            // Sumar al total general
            totalVenta = totalVenta.add(detalle.getSubtotal());
        }

        venta.setDetalles(detallesEntidad);
        venta.setTotalVenta(totalVenta);

        // 3. Guardar Todo (Cascada guarda los detalles)
        return ventaRepository.save(venta);
    }

    public List<Venta> findAll() {
        return ventaRepository.findAll();
    }

    public List<Venta> findByUsuarioId(Integer usuarioId) {
        return ventaRepository.findByUsuarioId(usuarioId);
    }

    @Transactional
    public Venta updateEstado(Integer id, String nuevoEstado) {
        Venta venta = ventaRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Venta no encontrada ID: " + id));

        Venta.EstadoVenta estadoAnterior = venta.getEstado();
        Venta.EstadoVenta estadoNuevo;

        try {
            estadoNuevo = Venta.EstadoVenta.valueOf(nuevoEstado);
        } catch (IllegalArgumentException e) {
            throw new RuntimeException("Estado inválido: " + nuevoEstado);
        }

        // Si cambia a Completada, descontar stock
        if (estadoNuevo == Venta.EstadoVenta.Completada && estadoAnterior != Venta.EstadoVenta.Completada) {
            for (DetalleVenta detalle : venta.getDetalles()) {
                Producto producto = detalle.getProducto();

                // Validar que haya stock suficiente
                if (producto == null) {
                    throw new RuntimeException("Producto no encontrado en el detalle de venta");
                }

                if (producto.getStock() < detalle.getCantidad()) {
                    throw new RuntimeException("Stock insuficiente para completar el pedido. Producto: " +
                            producto.getNombreProducto() + " (Stock disponible: " + producto.getStock() +
                            ", Requerido: " + detalle.getCantidad() + ")");
                }

                // Descontar stock
                producto.setStock(producto.getStock() - detalle.getCantidad());
                productoRepository.save(producto);
            }
        }

        venta.setEstado(estadoNuevo);
        return ventaRepository.save(venta);
    }
}