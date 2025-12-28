<?php
include("./includes/db.php");

if (isset($_POST['query'])) {
    $inputText = $_POST['query'];

    if (strlen($inputText) > 1) {
        $sql = "SELECT id, name, price, image_url FROM products WHERE name LIKE :search LIMIT 5";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => '%' . $inputText . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            foreach ($results as $row) {
                // Tıklayınca o ürüne gideceğimiz linkler
                echo '<a href="shop-single.php?id=' . $row['id'] . '" class="list-group-item list-group-item-action d-flex align-items-center">';
                // Küçük resim
                echo '<img src="assets/img/products/' . $row['image_url'] . '" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">';
                // Ürün adı ve fiyatı
                echo '<div>';
                echo '<div class="fw-bold">' . $row['name'] . '</div>';
                echo '<small class="text-muted">' . $row['price'] . ' ₺</small>';
                echo '</div>';
                echo '</a>';
            }
        } else {
            echo '<div class="list-group-item">Ürün bulunamadı.</div>';
        }
    }
}
?>