package com.Wurger.controller;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.io.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.nio.charset.StandardCharsets;
import java.util.Base64;
import java.util.HashMap;
import java.util.Map;

@RestController
@RequestMapping("/api/upload")
@CrossOrigin(origins = "*")
public class UploadController {

    @Value("${imgbb.api.key:}")
    private String imgbbApiKey;

    @PostMapping
    public ResponseEntity<Map<String, String>> uploadImage(@RequestParam("file") MultipartFile file) {
        Map<String, String> response = new HashMap<>();
        try {
            if (file.isEmpty()) {
                response.put("error", "El archivo está vacío");
                return new ResponseEntity<>(response, HttpStatus.BAD_REQUEST);
            }

            // Si no hay API Key de ImgBB configurada, devolver error claro
            if (imgbbApiKey == null || imgbbApiKey.isBlank()) {
                response.put("error", "No se ha configurado la API Key de ImgBB en el servidor.");
                return new ResponseEntity<>(response, HttpStatus.INTERNAL_SERVER_ERROR);
            }

            // Convertir imagen a Base64
            byte[] fileBytes = file.getBytes();
            String base64Image = Base64.getEncoder().encodeToString(fileBytes);

            // Armar la petición a ImgBB
            String apiUrl = "https://api.imgbb.com/1/upload";
            String params = "key=" + URLEncoder.encode(imgbbApiKey, StandardCharsets.UTF_8)
                    + "&image=" + URLEncoder.encode(base64Image, StandardCharsets.UTF_8);

            URL url = new URL(apiUrl);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setRequestMethod("POST");
            conn.setDoOutput(true);
            conn.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");

            try (OutputStream os = conn.getOutputStream()) {
                os.write(params.getBytes(StandardCharsets.UTF_8));
            }

            // Leer respuesta
            int responseCode = conn.getResponseCode();
            InputStream is = (responseCode >= 200 && responseCode < 300)
                    ? conn.getInputStream()
                    : conn.getErrorStream();

            StringBuilder sb = new StringBuilder();
            try (BufferedReader br = new BufferedReader(new InputStreamReader(is, StandardCharsets.UTF_8))) {
                String line;
                while ((line = br.readLine()) != null) {
                    sb.append(line);
                }
            }

            String jsonResponse = sb.toString();

            // Extraer la URL directa del JSON de ImgBB de forma simple
            // El JSON tiene: "url":"https://i.ibb.co/..."
            if (jsonResponse.contains("\"url\"")) {
                int startIndex = jsonResponse.indexOf("\"url\":\"") + 7;
                int endIndex = jsonResponse.indexOf("\"", startIndex);
                // La url directa está en data.display_url o data.url
                // Buscamos la URL de "display_url" que es la imagen directa
                String displayUrl = "";
                if (jsonResponse.contains("\"display_url\":\"")) {
                    int s = jsonResponse.indexOf("\"display_url\":\"") + 15;
                    int e = jsonResponse.indexOf("\"", s);
                    displayUrl = jsonResponse.substring(s, e).replace("\\/", "/");
                } else {
                    displayUrl = jsonResponse.substring(startIndex, endIndex).replace("\\/", "/");
                }

                response.put("url", displayUrl);
                return new ResponseEntity<>(response, HttpStatus.OK);
            } else {
                response.put("error", "Error al subir imagen a ImgBB: " + jsonResponse);
                return new ResponseEntity<>(response, HttpStatus.INTERNAL_SERVER_ERROR);
            }

        } catch (IOException e) {
            e.printStackTrace();
            response.put("error", "Error de conexión al subir la imagen: " + e.getMessage());
            return new ResponseEntity<>(response, HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
