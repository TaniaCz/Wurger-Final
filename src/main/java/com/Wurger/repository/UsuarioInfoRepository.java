package com.Wurger.repository;

import com.Wurger.model.UsuarioInfo;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface UsuarioInfoRepository extends JpaRepository<UsuarioInfo, Integer> {
}
