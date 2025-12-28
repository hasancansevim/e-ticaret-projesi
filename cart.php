<?php
ob_start(); // html hatası için ( yönlendirme yaparken hata alıyordum)
session_start(); // Başka Sayfaya Geçince Sepetteki Ürünler Gitmesin Diye
include './includes/db.php';

// --- İŞLEM 1: SİPARİŞİ TAMAMLAMA (Form Gönderildiyse) ---
$order_success = false;
$order_id = 0;
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complete_order'])) {

    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $address = htmlspecialchars(trim($_POST['address']));
    $total_amount = $_POST['total_amount'];

    if (empty($name) || empty($email) || empty($address)) {
        $error_msg = "Lütfen ad, e-posta ve adres alanlarını doldurunuz.";
    } elseif (empty($_SESSION['cart'])) {
        $error_msg = "Sepetiniz boş, sipariş verilemez.";
    } else {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, total_amount) VALUES (?, ?, ?, ?, ?)");
            // Telefon Numarasını Formdan Kaldırdım Onun İçin Belirtilmedi Geçiyorum
            $stmt->execute([$name, $email, 'Belirtilmedi', $address, $total_amount]);
            $order_id = $pdo->lastInsertId();

            foreach ($_SESSION['cart'] as $item) {
                $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price, selected_color, selected_size) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt_item->execute([$order_id, $item['id'], $item['qty'], $item['price'], $item['color'], $item['size']]);
            }

            $pdo->commit();

            // Sepeti Boşalt ve Başarılı De
            $_SESSION['cart'] = [];
            $order_success = true;

        } catch (Exception $e) {
            $pdo->rollBack();
            $error_msg = "Sipariş hatası: " . $e->getMessage();
        }
    }
}

// --- İŞLEM 2: SEPETTEN ÜRÜN SİLME ---
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

// --- İŞLEM 3: SEPETE ÜRÜN EKLEME (Shop-Single'dan gelen) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'addtocart' || isset($_POST['action']) && $_POST['action'] == 'buy') {

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

        if (!isset($_SESSION['cart']))
            $_SESSION['cart'] = [];
        $_SESSION['cart'][] = $new_item;

        header("Location: cart.php");
        exit;
    }
}

include("header.php");
?>

<div class="container py-5">

    <?php if ($order_success): ?>
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <div class="mb-4 text-success"><i class="fas fa-check-circle fa-5x"></i></div>
            <h2 class="fw-bold text-success">Siparişiniz Alındı!</h2>
            <p class="text-muted lead">Sipariş Numaranız: <strong>#<?php echo $order_id; ?></strong></p>
            <p>Bizi tercih ettiğiniz için teşekkür ederiz.</p>
            <a href="shop.php" class="btn btn-success btn-lg mt-3">Alışverişe Devam Et</a>
        </div>
    </div>

    <?php elseif (empty($_SESSION['cart'])): ?>
    <div class="alert alert-warning text-center py-5 shadow-sm border-0">
        <i class="fas fa-shopping-basket fa-3x mb-3 text-muted"></i>
        <h4>Sepetinizde ürün yok.</h4>
        <a href="shop.php" class="btn btn-success mt-3">Alışverişe Başla</a>
    </div>

    <?php else: ?>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <h2 class="h3 text-dark">Alışveriş Sepetim</h2>
        </div>

        <?php if ($error_msg): ?>
        <div class="col-12 mb-3">
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        </div>
        <?php endif; ?>

        <div class="col-lg-7">
            <div class="table-responsive mb-4">
                <table class="table table-bordered bg-white shadow-sm">
                    <thead class="bg-light">
                        <tr>
                            <th>Ürün</th>
                            <th>Fiyat</th>
                            <th>Adet</th>
                            <th>Toplam</th>
                            <th>Sil</th>
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
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="assets/img/products/<?php echo $item['image']; ?>"
                                        style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                    <div>
                                        <span class="fw-bold d-block"><?php echo $item['name']; ?></span>
                                        <small class="text-muted">
                                            <?php echo ($item['color'] != '-') ? $item['color'] : ''; ?>
                                            <?php echo ($item['size'] != '-') ? $item['size'] : ''; ?>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle"><?php echo number_format($item['price'], 0); ?> ₺</td>
                            <td class="align-middle text-center"><?php echo $item['qty']; ?></td>
                            <td class="align-middle fw-bold text-success"><?php echo number_format($row_total, 0); ?> ₺
                            </td>
                            <td class="align-middle text-center">
                                <a href="cart.php?remove=<?php echo $key; ?>" class="text-danger"
                                    onclick="return confirm('Sil?')"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a href="shop.php" class="btn btn-outline-secondary btn-sm mb-4"><i class="fas fa-arrow-left"></i>
                Alışverişe Dön</a>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-truck me-2"></i> Teslimat Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="total_amount" value="<?php echo $grand_total; ?>">

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Ad Soyad</label>
                            <input type="text" name="name" class="form-control" placeholder="Adınız Soyadınız" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">E-Posta</label>
                            <input type="email" name="email" class="form-control" placeholder="ornek@mail.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Adres</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Açık adresiniz..."
                                required></textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="h5">Toplam Tutar:</span>
                            <span class="h4 text-success fw-bold"><?php echo number_format($grand_total, 2); ?> ₺</span>
                        </div>

                        <button type="submit" name="complete_order" class="btn btn-success btn-lg w-100 shadow">
                            Siparişi Tamamla <i class="fas fa-check ms-2"></i>
                        </button>
                        <small class="text-muted d-block text-center mt-2"><i class="fas fa-lock"></i> Güvenli Ödeme
                            (Kapıda)</small>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <?php endif; ?>
</div>

<?php
include("footer.php");
ob_end_flush();
?>