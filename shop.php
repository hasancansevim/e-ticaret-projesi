<?php
include 'header.php';
include './includes/db.php';

// Kategorileri Çek
$category_sql = "SELECT * FROM categories WHERE status=1";
$stmt_category = $pdo->prepare($category_sql);
$stmt_category->execute();
$categories = $stmt_category->fetchAll(PDO::FETCH_ASSOC);

// Ürünleri Çek
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $product_sql = "SELECT * FROM products WHERE category_id = :category_id";
    $stmt_product = $pdo->prepare($product_sql);
    $stmt_product->execute(['category_id' => $category_id]);
} else {
    $product_sql = "SELECT * FROM products";
    $stmt_product = $pdo->prepare($product_sql);
    $stmt_product->execute();
}
$products = $stmt_product->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Start Content -->
<div class="container py-5">
    <div class="row">

        <div class="col-lg-3">
            <h1 class="h2 pb-4">Kategoriler</h1>
            <ul class="list-unstyled templatemo-accordion">
                <li class="pb-3">
                    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                        Ürün Grupları
                        <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul class="collapse show list-unstyled pl-3">
                        <li><a class="text-decoration-none" href="#">Tüm Ürünler</a></li>
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a class="text-decoration-none" href="shop.php?category_id=<?php echo $category['id'] ?>">
                                    <?php echo $category['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </li>

                <!-- <li class="pb-3">
                    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                        Sale
                        <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul id="collapseTwo" class="collapse list-unstyled pl-3">
                        <li><a class="text-decoration-none" href="#">Sport</a></li>
                        <li><a class="text-decoration-none" href="#">Luxury</a></li>
                    </ul>
                </li>
                <li class="pb-3">
                    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                        Ürün
                        <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul id="collapseThree" class="collapse list-unstyled pl-3">
                        <li><a class="text-decoration-none" href="#">Çanta</a></li>
                        <li><a class="text-decoration-none" href="#">Kazak</a></li>
                        <li><a class="text-decoration-none" href="#">Sweat</a></li>
                    </ul>
                </li> -->
            </ul>
        </div>

        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-inline shop-top-menu pb-3 pt-1">
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none mr-3" href="#">Tümü</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none mr-3" href="#">Erkek</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none" href="#">Kadın</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 pb-4">
                    <div class="d-flex">
                        <select class="form-control">
                            <option>Öne Çıkanlar</option>
                            <option>A dan Z ye</option>
                            <option>Z den A ya</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">
                                <img class="card-img rounded-0 img-fluid"
                                    src="assets/img/<?php echo $product['image_url']; ?>">
                                <div
                                    class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white mt-2"
                                                href="shop-single.php?id=<?php echo $product['id']; ?>"><i
                                                    class="far fa-eye"></i></a></li>
                                        <li><a class="btn btn-success text-white mt-2"
                                                href="cart.php?add=<?php echo $product['id']; ?>"><i
                                                    class="fas fa-cart-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <a href="shop-single.php?id=<?php echo $product['id']; ?>"
                                    class="h3 text-decoration-none"><?php echo $product['name']; ?></a>

                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                    <!-- <li>M/L/X/XL</li> -->
                                    <li class="pt-2">
                                        <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                        <span
                                            class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                        <span
                                            class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                        <span
                                            class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                    </li>
                                </ul>

                                <ul class="list-unstyled d-flex justify-content-center mb-1">
                                    <li>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                    </li>
                                </ul>

                                <p class="text-center mb-0"><?php echo $product['price']; ?> TL</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <div div="row">
            <ul class="pagination pagination-lg justify-content-end">
                <li class="page-item disabled">
                    <a class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0" href="#"
                        tabindex="-1">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link rounded-0 shadow-sm border-top-0 border-left-0 text-dark" href="#">3</a>
                </li>
            </ul>
        </div>
    </div>

</div>
</div>
<!-- End Content -->

<?php include('footer.php'); ?>