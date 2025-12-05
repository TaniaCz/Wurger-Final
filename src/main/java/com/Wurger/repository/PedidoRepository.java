package com.Wurger.repository;

import com.Wurger.model.Pedido;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface PedidoRepository extends JpaRepository<Pedido, Integer> {
    java.util.List<Pedido> findByUsuarioInfo_Usuario_Id(Integer usuarioId);
}
