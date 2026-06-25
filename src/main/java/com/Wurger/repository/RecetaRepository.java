package com.Wurger.repository;

import com.Wurger.model.Receta;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface RecetaRepository extends JpaRepository<Receta, Integer> {
    List<Receta> findByProductoTerminadoId(Integer idProductoTerminado);
}
