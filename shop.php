<?php
include 'header.php';
include './includes/db.php';

// --- 1. KATEGORİLERİ ÇEK ---
$cat_sql = "SELECT * FROM categories WHERE status = 1";
$stmt_cat = $pdo->prepare($cat_sql);
$stmt_cat->execute();
$categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

// --- 2. ÜRÜNLERİ ÇEK ---
$cat_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$page_title = 'Tüm Ürünler'; // Varsayılan başlık

if ($cat_id) {
    // Seçilen kategorinin adını bulalım
    foreach ($categories as $cat) {
        if ($cat['id'] == $cat_id) {
            $page_title = $cat['name']; // Örn: "Saatler"
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

<!-- <style>
.category-list-group {
    border-radius: 10px;
    overflow: hidden;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.category-item {
    border: none;
    border-bottom: 1px solid #f1f1f1;
    padding: 15px 20px;
    color: #555;
    font-weight: 500;
    transition: all 0.3s;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
}

.category-item:last-child {
    border-bottom: none;
}

.category-item:hover,
.category-item.active {
    background-color: #59ab6e;
    color: white !important;
    padding-left: 25px;
    text-decoration: none;
}

.category-item i {
    transition: transform 0.3s;
}

.category-item:hover i {
    transform: translateX(5px);
}

.product-wap {
    border: none;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.product-wap:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.card-img-wrap {
    height: 280px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-bottom: 1px solid #f8f9fa;
    position: relative;
    overflow: hidden;
}

.card-img-wrap img {
    max-height: 100%;
    max-width: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    padding: 15px;
    transition: transform 0.5s;
}

.product-wap:hover .card-img-wrap img {
    transform: scale(1.08);
}

.card-body {
    padding: 1.5rem;
    text-align: center;
}

.h3.text-decoration-none {
    font-size: 1.1rem;
    font-weight: 700;
    color: #333;
}

.price-tag {
    font-size: 1.25rem;
    font-weight: 800;
    color: #198754;
    display: block;
    margin-top: 10px;
}
</style> -->

<div class="container py-5">
    <div class="row">

        <div class="col-lg-3">
            <h1 class="h2 pb-4 fw-bold text-success">Kategoriler</h1>

            <div class="list-group category-list-group mb-5">
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
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100 product-wap">
                        <div class="card-img-wrap">
                            <a href="shop-single.php?id=<?php echo $product['id']; ?>">
                                <img src="assets/img/products/<?php echo $product['image_url']; ?>"
                                    alt="<?php echo $product['name']; ?>">
                            </a>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <a href="shop-single.php?id=<?php echo $product['id']; ?>" class="h3 text-decoration-none">
                                <?php echo $product['name']; ?>
                            </a>
                            <p class="description-text text-center mt-2">
                                <?php
                                        echo mb_substr($product['description'], 0, 50, 'UTF-8') . '...';
                                        ?>
                            </p>
                            <ul class="list-unstyled d-flex justify-content-center mb-2 mt-1">
                                <li>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                </li>
                            </ul>
                            <div class="mt-auto">
                                <span class="price-tag"><?php echo $product['price']; ?> ₺</span>
                                <a href="shop-single.php?id=<?php echo $product['id']; ?>"
                                    class="btn btn-outline-success rounded-pill mt-3 w-100">
                                    İncele
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning py-5 text-center">
                        <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                        <h4>Bu kategoride henüz ürün bulunamadı.</h4>
                        <a href="shop.php" class="btn btn-success mt-2">Tüm Ürünleri Gör</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>