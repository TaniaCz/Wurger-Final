package com.Wurger.repository;

import com.Wurger.model.ProductoTerminado;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface ProductoTerminadoRepository extends JpaRepository<ProductoTerminado, Integer> {
}
