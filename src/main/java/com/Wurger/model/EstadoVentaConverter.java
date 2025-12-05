package com.Wurger.model;

import jakarta.persistence.AttributeConverter;
import jakarta.persistence.Converter;
import com.Wurger.model.Venta.EstadoVenta;

@Converter(autoApply = true)
public class EstadoVentaConverter implements AttributeConverter<EstadoVenta, String> {

    @Override
    public String convertToDatabaseColumn(EstadoVenta attribute) {
        if (attribute == null) {
            return null;
        }
        // Map Enum to String for DB
        switch (attribute) {
            case EnProceso:
                return "En Proceso"; // Keep legacy format if desired, or use "EnProceso"
            default:
                return attribute.name();
        }
    }

    @Override
    public EstadoVenta convertToEntityAttribute(String dbData) {
        if (dbData == null) {
            return null;
        }

        // Handle legacy values
        switch (dbData) {
            case "En Proceso":
                return EstadoVenta.EnProceso;
            case "Pagada":
                return EstadoVenta.Pagada;
            case "Anulada":
                return EstadoVenta.Anulada;
            default:
                try {
                    return EstadoVenta.valueOf(dbData);
                } catch (IllegalArgumentException e) {
                    System.err.println("Unknown EstadoVenta: " + dbData);
                    return EstadoVenta.Pendiente; // Fallback to prevent crash
                }
        }
    }
}
