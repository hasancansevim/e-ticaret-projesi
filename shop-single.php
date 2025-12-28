<?php
include("header.php");
include("./includes/db.php");
?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<div class='container py-5'><div class='alert alert-danger'>Ürün bulunamadı.</div></div>";
        include 'includes/footer.php';
        exit;
    }

    $featured_sql = "SELECT * FROM products WHERE is_featured = 1";
    $stmt_featured = $pdo->prepare($featured_sql);
    $stmt_featured->execute();
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

                        <form action="cart.php" method="GET">
                            <input type="hidden" name="add" value="<?php echo $product['id']; ?>">
                            <div class="row">
                                <div class="col-auto">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item text-right">
                                            Adet
                                            <input type="hidden" name="quantity" id="product-quanity" value="1">
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                id="btn-minus">-</span></li>
                                        <li class="list-inline-item"><span class="badge bg-secondary"
                                                id="var-value">1</span></li>
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                id="btn-plus">+</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row pb-3 gap-2 gap-md-0">
                                <div class="col-md-6 d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">Satın
                                        Al</button>
                                </div>
                                <div class="col-md-6 d-grid">
                                    <button type="submit" class="btn btn-outline-success btn-lg" name="submit"
                                        value="addtocard">Sepete Ekle</button>
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
            <h4 class="fw-bold mb-4 border-bottom pb-2">Öne Çıkan Ürünler</h4>
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