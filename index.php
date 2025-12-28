<?php
include('header.php');
include('./includes/db.php');

// Kategoriler
$cat_sql = "SELECT * FROM categories WHERE status = 1 LIMIT 3";
$stmt_cat = $pdo->prepare($cat_sql);
$stmt_cat->execute();
$categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

// Öne Çıkan Ürünler
$feat_sql = "SELECT * FROM products WHERE is_featured = 1 LIMIT 3";
$stmt_feat = $pdo->prepare($feat_sql);
$stmt_feat->execute();
$featured_products = $stmt_feat->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="./assets/img/banner_img_01.jpg" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left align-self-center">
                            <h1 class="h1 text-success"><b>Zay</b> E-Ticaret</h1>
                            <h3 class="h2">Kaliteli ve Güvenli Alışveriş</h3>
                            <p>Yüzlerce kategori ve binlerce ürün seçeneğiyle Zay Shop hizmetinizde.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="./assets/img/banner_img_02.jpg" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class="h1">Özel Koleksiyon</h1>
                            <h3 class="h2">Tarzını Yansıt</h3>
                            <p>Yeni sezon ürünlerimizle modayı yakından takip edin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="./assets/img/banner_img_03.jpg" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class="h1">Fırsat Ürünleri</h1>
                            <h3 class="h2">%50'ye Varan İndirimler</h3>
                            <p>Seçili ürünlerde geçerli indirimleri keşfetmek için hemen alışverişe başlayın.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel"
        role="button" data-bs-slide="prev">
        <i class="fas fa-chevron-left"></i>
    </a>
    <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel"
        role="button" data-bs-slide="next">
        <i class="fas fa-chevron-right"></i>
    </a>
</div>

<!-- Popüler Kategoriler -->
<section class="container py-5">
    <div class="row text-center pt-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">Popüler Kategoriler</h1>
            <p>En çok tercih edilen kategorilerimize göz atın.</p>
        </div>
    </div>
    <div class="row">
        <?php foreach ($categories as $category): ?>
        <div class="col-12 col-md-4 p-5 mt-3">
            <a href="shop.php?category_id=<?php echo $category['id']; ?>">
                <img src="./assets/img/<?php echo $category['image_url'] ?>" class="rounded-circle img-fluid border">
            </a>
            <h5 class="text-center mt-3 mb-3"><?php echo $category['name'] ?></h5>
            <p class="text-center"><a class="btn btn-success"
                    href="shop.php?category_id=<?php echo $category['id']; ?>">Alışverişe Başla</a></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Öne Çıkan Ürünler -->
<section class="bg-light py-5">
    <div class="container py-5">

        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1 fw-bold text-success">Öne Çıkan Fırsatlar</h1>
                <p class="text-muted">
                    Sizin için seçtiğimiz en özel ürünlere göz atın.
                </p>
            </div>
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

        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="shop.php" class="btn btn-success btn-lg px-5 py-3 rounded-pill shadow">
                    <i class="fas fa-shopping-bag me-2"></i> Tüm Ürünleri İncele
                </a>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>