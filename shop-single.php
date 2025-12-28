<?php
include("header.php");
include("./includes/db.php"); // Veritabanı bağlantısı

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. ÜRÜN BİLGİSİNİ ÇEK
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ürün yoksa hata ver
    if (!$product) {
        echo "<div class='container py-5'><div class='alert alert-danger'>Ürün bulunamadı.</div></div>";
        include 'includes/footer.php';
        exit;
    }

    // 2. VARYASYONLARI ÇEK (YENİ SİSTEM)
    $v_sql = "SELECT * FROM product_variants WHERE product_id = :id";
    $v_stmt = $pdo->prepare($v_sql);
    $v_stmt->execute(['id' => $id]);
    $variants = $v_stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. VERİLERİ GRUPLAYALIM
    $renkler = [];
    $bedenler = [];
    $beden_etiketi = "Beden"; // Varsayılan etiket

    foreach ($variants as $v) {
        if ($v['variant_type'] == 'renk') {
            $renkler[] = $v['variant_value'];
        } elseif ($v['variant_type'] == 'beden') {
            $bedenler[] = $v['variant_value'];
            $beden_etiketi = "Beden";
        } elseif ($v['variant_type'] == 'numara') { // Ayakkabı ise
            $bedenler[] = $v['variant_value'];
            $beden_etiketi = "Numara";
        }
    }

    // 4. BENZER ÜRÜNLERİ ÇEK
    $featured_sql = "SELECT * FROM products WHERE is_featured = 1 AND id != :id LIMIT 3";
    $stmt_featured = $pdo->prepare($featured_sql);
    $stmt_featured->execute(['id' => $id]);
    $featured_products = $stmt_featured->fetchAll(PDO::FETCH_ASSOC);

} else {
    header("Location: shop.php");
    exit;
}
?>

<section class="bg-light">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-5 mt-5">
                <div class="card mb-3 shadow-sm border-0">
                    <div class="product-image-container">
                        <img class="card-img img-fluid" src="assets/img/products/<?php echo $product['image_url']; ?>"
                            alt="Ürün Fotoğrafı" id="product-detail">
                    </div>
                </div>
            </div>

            <div class="col-lg-7 mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <h1 class="h2 text-dark fw-bold"><?php echo $product['name']; ?></h1>
                        <p class="h3 py-2 text-success fw-bold"><?php echo $product['price']; ?> ₺</p>

                        <p class="py-2">
                            <?php
                            $puan = $product['rating'] ? $product['rating'] : 0;
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $puan) {
                                    echo '<i class="fa fa-star text-warning"></i>';
                                } else {
                                    echo '<i class="fa fa-star text-secondary"></i>';
                                }
                            }
                            ?>
                            <span class="list-inline-item text-dark">Rating <?php echo $puan; ?> | 36 Yorum</span>
                        </p>

                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Marka:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>Zay Shop</strong></p>
                            </li>
                        </ul>

                        <h6>Açıklama:</h6>
                        <p class="text-muted"><?php echo $product['description']; ?></p>

                        <form action="cart.php" method="POST">

                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                            <?php if (!empty($renkler)): ?>
                            <div class="row pb-3">
                                <div class="col-3">
                                    <h6>Renk:</h6>
                                </div>
                                <div class="col-9">
                                    <select class="form-select" name="color">
                                        <?php foreach ($renkler as $renk): ?>
                                        <option value="<?php echo $renk; ?>"><?php echo $renk; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($bedenler)): ?>
                            <div class="row pb-3">
                                <div class="col-3">
                                    <h6><?php echo $beden_etiketi; ?>:</h6>
                                </div>
                                <div class="col-9">
                                    <select class="form-select" name="size">
                                        <?php foreach ($bedenler as $beden): ?>
                                        <option value="<?php echo $beden; ?>"><?php echo $beden; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="row pb-3">
                                <div class="col-3">
                                    <h6>Adet:</h6>
                                </div>
                                <div class="col-9">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                id="btn-minus">-</span></li>
                                        <li class="list-inline-item">
                                            <span class="badge bg-secondary" id="var-value">1</span>
                                            <input type="hidden" name="quantity" id="product-quanity" value="1">
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                id="btn-plus">+</span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row pb-3 gap-2 gap-md-0">
                                <div class="col-md-6 d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" name="action" value="buy">Satın
                                        Al</button>
                                </div>
                                <div class="col-md-6 d-grid">
                                    <button type="submit" class="btn btn-outline-success btn-lg" name="action"
                                        value="addtocart">Sepete Ekle</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row text-left p-2 pb-3">
            <h4 class="fw-bold mb-4 border-bottom pb-2">Benzer Ürünler</h4>
        </div>

        <div class="row">
            <?php if (count($featured_products) > 0): ?>
            <?php foreach ($featured_products as $featured_product): ?>
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm product-wap">
                    <div class="card rounded-0">
                        <img class="card-img-top card-img-custom"
                            src="assets/img/products/<?php echo $featured_product['image_url']; ?>"
                            alt="<?php echo $featured_product['name']; ?>">
                        <div
                            class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                            <ul class="list-unstyled">
                                <li><a class="btn btn-success text-white mt-2"
                                        href="shop-single.php?id=<?php echo $featured_product['id']; ?>"><i
                                            class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body text-center d-flex flex-column">
                        <a href="shop-single.php?id=<?php echo $featured_product['id']; ?>"
                            class="h3 text-decoration-none text-dark fw-bold"><?php echo $featured_product['name']; ?></a>
                        <div class="mt-auto">
                            <p class="text-center mb-0 text-success fw-bold pt-2">
                                <?php echo $featured_product['price']; ?> ₺
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12">
                <p class="text-muted">Bu kategoride başka ürün bulunamadı.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>