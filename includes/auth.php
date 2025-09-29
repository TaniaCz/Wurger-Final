<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function login($email, $password) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM usuario WHERE Email_usuario = ? AND Estado_usuario = 'Activo'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['Password_usuario'])) {
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_name'] = $user['Nom_usuario'];
        $_SESSION['user_email'] = $user['Email_usuario'];
        $_SESSION['user_role'] = $user['id_rol_FK'];
        return true;
    }
    return false;
}

function logout() {
    session_destroy();
    header('Location: login.php');
    exit();
}

function getCurrentUser() {
    if (!isLoggedIn()) return null;
    
    $db = getDB();
    $stmt = $db->prepare("SELECT u.*, r.Nombre_rol FROM usuario u 
                         LEFT JOIN rol r ON u.id_rol_FK = r.id_rol 
                         WHERE u.id_usuario = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function hasPermission($required_role) {
    if (!isLoggedIn()) return false;
    return $_SESSION['user_role'] >= $required_role;
}
?>
