<!-- Sunucu tarafında dosya kaydedemediğim için mecburen bu yöntemi kullanıyorum -->
<!-- Yani sepet bilgilerini veri tabanına kaydediyorum  -->

<?php
require_once 'db.php';

// 1. Okuma Fonksiyonu
function sess_read($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT data FROM user_sessions WHERE id = :id");
    $stmt->execute(['id' => $id]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $row['data'];
    }
    return '';
}

// 2. Yazma Fonksiyonu
function sess_write($id, $data)
{
    global $pdo;
    $time = time();
    // Varsa güncelle, yoksa ekle (REPLACE INTO)
    $sql = "REPLACE INTO user_sessions (id, data, timestamp) VALUES (:id, :data, :time)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id, 'data' => $data, 'time' => $time]);
}

// 3. Silme Fonksiyonu
function sess_destroy($id)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM user_sessions WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}

// 4. Temizlik Fonksiyonu (Eski oturumları siler)
function sess_gc($maxlifetime)
{
    global $pdo;
    $old = time() - $maxlifetime;
    $stmt = $pdo->prepare("DELETE FROM user_sessions WHERE timestamp < :old");
    return $stmt->execute(['old' => $old]);
}

// Diğer zorunlu fonksiyonlar (Boş dönebilir)
function sess_open($path, $name)
{
    return true;
}
function sess_close()
{
    return true;
}

// PHP'ye "Artık bu fonksiyonları kullan" diyoruz
session_set_save_handler("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc");

// Oturumu başlat (Eğer başlamadıysa)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>