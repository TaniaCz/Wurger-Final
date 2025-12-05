package com.Wurger.service;

import com.Wurger.dto.MovimientoDTO;
import com.Wurger.model.Movimiento;
import com.Wurger.model.Producto;
import com.Wurger.repository.MovimientoRepository;
import com.Wurger.repository.ProductoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;
import java.util.Optional;

@Service
public class MovimientoService {

    @Autowired
    private MovimientoRepository movimientoRepository;

    @Autowired
    private ProductoRepository productoRepository;

    public List<Movimiento> findAll() {
        return movimientoRepository.findAll();
    }

    public Optional<Movimiento> findById(Integer id) {
        return movimientoRepository.findById(id);
    }

    // --- LÓGICA DE INVENTARIO ---
    @Transactional
    public Movimiento registrarMovimiento(MovimientoDTO dto) {
        // 1. Buscar el producto
        Producto producto = productoRepository.findById(dto.getIdProducto())
                .orElseThrow(() -> new RuntimeException("Producto no encontrado ID: " + dto.getIdProducto()));

        // 2. Crear el movimiento
        Movimiento movimiento = new Movimiento();
        movimiento.setTipo(dto.getTipo());
        movimiento.setCantidad(dto.getCantidad());
        movimiento.setFecha(dto.getFecha());
        movimiento.setDescripcion(dto.getDescripcion());
        movimiento.setProducto(producto);

        // 3. ACTUALIZAR STOCK DEL PRODUCTO
        int stockActual = (producto.getStock() != null) ? producto.getStock() : 0;

        if (dto.getTipo() == Movimiento.TipoMovimiento.Entrada) {
            producto.setStock(stockActual + dto.getCantidad());
        } else if (dto.getTipo() == Movimiento.TipoMovimiento.Salida) {
            if (stockActual < dto.getCantidad()) {
                throw new RuntimeException(
                        "Stock insuficiente. Tienes: " + stockActual + ", intentas sacar: " + dto.getCantidad());
            }
            producto.setStock(stockActual - dto.getCantidad());
        }

        // 4. Guardar cambios en Producto (actualiza stock)
        productoRepository.save(producto);

        // 5. Guardar el historial del movimiento
        return movimientoRepository.save(movimiento);
    }

    // Nota: El Delete y Update en movimientos de inventario son delicados.
    // Si borras un movimiento, deberías revertir el stock.
    // Por simplicidad, aquí solo permitimos borrar el registro.
    public void delete(Integer id) {
        movimientoRepository.deleteById(id);
    }
}