<?php
include 'header.php';
include './includes/db.php';

// Kategoriler
$cat_sql = "SELECT * FROM categories WHERE status = 1";
$stmt_cat = $pdo->prepare($cat_sql);
$stmt_cat->execute();
$categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

// Ürünler
$cat_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$page_title = 'Tüm Ürünler';

if ($cat_id) {
    foreach ($categories as $cat) {
        if ($cat['id'] == $cat_id) {
            $page_title = $cat['name'];
            break;
        }
    }
    $prod_sql = "SELECT * FROM products WHERE category_id = :cat_id";
    $stmt_prod = $pdo->prepare($prod_sql);
    $stmt_prod->execute(['cat_id' => $cat_id]);
} else {
    $prod_sql = "SELECT * FROM products";
    $stmt_prod = $pdo->prepare($prod_sql);
    $stmt_prod->execute();
}
$products = $stmt_prod->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="row">

        <div class="col-lg-3">
            <h1 class="h2 pb-4 fw-bold text-success">Kategoriler</h1>
            <div class="list-group category-list-group mb-5 shadow-sm">
                <a href="shop.php" class="list-group-item category-item <?php echo !$cat_id ? 'active' : ''; ?>">
                    <span>Tüm Ürünler</span>
                    <i class="fas fa-chevron-right fa-sm"></i>
                </a>
                <?php foreach ($categories as $category): ?>
                <a href="shop.php?category_id=<?php echo $category['id']; ?>"
                    class="list-group-item category-item <?php echo $cat_id == $category['id'] ? 'active' : ''; ?>">
                    <span><?php echo $category['name']; ?></span>
                    <i class="fas fa-chevron-right fa-sm"></i>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="h3 fw-bold text-dark">
                        <?php echo $page_title; ?>
                        <span class="text-muted fs-6 fw-normal ms-2">(<?php echo count($products); ?> ürün)</span>
                    </h2>
                </div>
            </div>

            <div class="row">
                <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>

                <?php
                        $stmt_v = $pdo->prepare("SELECT * FROM product_variants WHERE product_id = :id");
                        $stmt_v->execute(['id' => $product['id']]);
                        $variants = $stmt_v->fetchAll(PDO::FETCH_ASSOC);

                        $renkler = [];
                        $bedenler = [];

                        foreach ($variants as $v) {
                            if ($v['variant_type'] == 'renk') {
                                $renkler[] = $v['variant_value'];
                            } else {
                                $bedenler[] = $v['variant_value'];
                            }
                        }
                        ?>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 product-wap rounded-0 border-0 shadow-sm">

                        <div class="card-img-wrap rounded-0">
                            <img class="card-img rounded-0 img-fluid"
                                src="assets/img/products/<?php echo $product['image_url']; ?>">

                            <div
                                class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="btn btn-success text-white mt-2"
                                            href="shop-single.php?id=<?php echo $product['id']; ?>">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <a href="shop-single.php?id=<?php echo $product['id']; ?>"
                                class="h3 text-decoration-none text-dark fw-bold product-title">
                                <?php echo $product['name']; ?>
                            </a>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">Zay Shop</span>
                                <div class="text-warning">
                                    <?php
                                            $puan = $product['rating'] ? $product['rating'] : 0;
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $puan)
                                                    echo '<i class="fa fa-star"></i>';
                                                else
                                                    echo '<i class="fa fa-star text-secondary" style="opacity:0.3"></i>';
                                            }
                                            ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <?php if (!empty($renkler)): ?>
                                <div class="d-flex flex-wrap gap-1 mb-1 justify-content-center">
                                    <?php foreach ($renkler as $r): ?>
                                    <span class="badge bg-light text-dark border"><?php echo $r; ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($bedenler)): ?>
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <?php foreach ($bedenler as $b): ?>
                                    <span class="badge bg-success" style="font-size: 0.7em;"><?php echo $b; ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="mt-auto">
                                <p class="text-center mb-0 price-tag"><?php echo $product['price']; ?> ₺</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning py-5 text-center shadow-sm border-0">
                        <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                        <h4>Bu kategoride henüz ürün bulunamadı.</h4>
                        <a href="shop.php" class="btn btn-success mt-3">Tüm Ürünleri Gör</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>