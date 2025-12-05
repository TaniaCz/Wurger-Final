package com.Wurger.repository;

import com.Wurger.model.TipoDescuento;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface TipoDescuentoRepository extends JpaRepository<TipoDescuento, Integer> {
}
