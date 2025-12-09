<?php
include('header.php');
include('./includes/db.php');

$cat_sql = "SELECT * FROM categories WHERE status = 1 LIMIT 3";
$stmt_cat = $pdo->prepare($cat_sql);
$stmt_cat->execute();
$categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

$feat_sql = "SELECT * FROM products WHERE is_featured = 1 LIMIT 3";
$stmt_feat = $pdo->prepare($feat_sql);
$stmt_feat->execute();
$featured_products = $stmt_feat->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Start Banner Hero -->
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
                            <p>
                                Yüzlerce kategori ve binlerce ürün seçeneğiyle Zay Shop hizmetinizde.
                                Keyifli alışverişler dileriz.
                            </p>
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
                            <p>
                                Yeni sezon ürünlerimizle modayı yakından takip edin.
                                <strong>Sınırlı sayıdaki ürünleri kaçırmayın.</strong>
                            </p>
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
                            <p>
                                Seçili ürünlerde geçerli indirimleri keşfetmek için hemen alışverişe başlayın.
                            </p>
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
<!-- End Banner Hero -->


<!-- Start Categories of The Month -->
<section class="container py-5">
    <div class="row text-center pt-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">Popüler Kategoriler</h1>
            <p>
                En çok tercih edilen kategorilerimize göz atın.
            </p>
        </div>
    </div>
    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-12 col-md-4 p-5 mt-3">
                <a href="#"><img src="./assets/img/<?php echo $category['id'] ?>"
                        class="rounded-circle img-fluid border"></a>
                <h5 class="text-center mt-3 mb-3"><?php echo $category['name'] ?></h5>
                <p class="text-center"><a class="btn btn-success" href="shop.php?<?php echo $category['id']; ?>">Alışverişe
                        Başla</a></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<!-- End Categories of The Month -->


<!-- Start Featured Product -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Öne Çıkan Ürünler</h1>
                <p>
                    Sizin için seçtiğimiz en özel ürünler.
                </p>
            </div>
        </div>
        <div class="row">
            <?php foreach ($featured_products as $feat): ?>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="shop-single.php?id=<?php echo $feat['id']; ?>">
                            <img src="./assets/img/<?php echo $feat['image_url']; ?>" class="card-img-top" alt="...">
                        </a>
                        <div class="card-body">

                            <a href="shop-single.php?id=<?php echo $feat['id']; ?>"
                                class="h2 text-decoration-none text-dark">
                                <?php echo $feat['name']; ?>
                            </a>
                            <p class="card-text">
                                <?php echo substr($feat['description'], 0, 80) . '...'; ?>
                            </p>
                            <strong>
                                <li class="text-muted text-right"><?php echo $feat['price']; ?> ₺</li>
                            </strong>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>