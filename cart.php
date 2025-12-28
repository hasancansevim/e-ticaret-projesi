<?php
ob_start(); // html hatası için ( yönlendirme yaparken hata alıyordum)
session_start(); // Başka Sayfaya Geçince Sepetteki Ürünler Gitmesin Diye

$order_success = false;
if (isset($_GET['action']) && $_GET['action'] == 'checkout') {
    $_SESSION['cart'] = [];
    $order_success = true;
}

if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

include("./includes/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {

    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $color = isset($_POST['color']) ? $_POST['color'] : '-';
    $size = isset($_POST['size']) ? $_POST['size'] : '-';

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $new_item = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image_url'],
            'qty' => $quantity,
            'color' => $color,
            'size' => $size
        ];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $_SESSION['cart'][] = $new_item;
        header("Location: cart.php");
        exit;
    }
}

include("header.php");
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">

            <?php if ($order_success): ?>
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <div class="mb-4 text-success"><i class="fas fa-check-circle fa-5x"></i></div>
                    <h2 class="fw-bold text-success">Siparişiniz Alındı!</h2>
                    <p class="text-muted lead">Alışverişiniz için teşekkür ederiz. Sipariş numaranız:
                        <strong>#<?php echo rand(10000, 99999); ?></strong>
                    </p>
                    <a href="shop.php" class="btn btn-success btn-lg mt-3">Alışverişe Devam Et</a>
                </div>
            </div>

            <?php elseif (empty($_SESSION['cart'])): ?>
            <div class="alert alert-warning text-center py-5 shadow-sm border-0">
                <i class="fas fa-shopping-basket fa-3x mb-3 text-muted"></i>
                <h4>Sepetinizde henüz ürün yok.</h4>
                <a href="shop.php" class="btn btn-success mt-3">Alışverişe Başla</a>
            </div>

            <?php else: ?>
            <h2 class="h3 mb-4 text-dark">Alışveriş Sepetim</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 100px;">Resim</th>
                            <th>Ürün Adı</th>
                            <th>Özellikler</th>
                            <th>Fiyat</th>
                            <th>Adet</th>
                            <th>Toplam</th>
                            <th style="width: 50px;">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $grand_total = 0;
                            foreach ($_SESSION['cart'] as $key => $item):
                                $row_total = $item['price'] * $item['qty'];
                                $grand_total += $row_total;
                                ?>
                        <tr>
                            <td class="align-middle text-center">
                                <img src="assets/img/products/<?php echo $item['image']; ?>" alt=""
                                    style="width: 60px; height: auto;">
                            </td>
                            <td class="align-middle fw-bold"><?php echo $item['name']; ?></td>
                            <td class="align-middle text-muted">
                                <small>
                                    <?php if ($item['color'] != '-')
                                                echo "Renk: " . $item['color'] . "<br>"; ?>
                                    <?php if ($item['size'] != '-')
                                                echo "Beden: " . $item['size']; ?>
                                </small>
                            </td>
                            <td class="align-middle"><?php echo number_format($item['price'], 2); ?> ₺</td>
                            <td class="align-middle text-center"><?php echo $item['qty']; ?></td>
                            <td class="align-middle fw-bold text-success"><?php echo number_format($row_total, 2); ?> ₺
                            </td>
                            <td class="align-middle">
                                <a href="cart.php?remove=<?php echo $key; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Silmek istediğinize emin misiniz?')"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-lg-8">
                    <a href="shop.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Alışverişe
                        Devam Et</a>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-3">Sepet Özeti</h5>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Ara Toplam</span>
                                <span><?php echo number_format($grand_total, 2); ?> ₺</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span>Kargo</span>
                                <span class="text-success">Ücretsiz</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4 fw-bold h5">
                                <span>Genel Toplam</span>
                                <span><?php echo number_format($grand_total, 2); ?> ₺</span>
                            </div>
                            <div class="d-grid">
                                <a href="cart.php?action=checkout" class="btn btn-success btn-lg">Sepeti Onayla</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include("footer.php");
ob_end_flush();
?>