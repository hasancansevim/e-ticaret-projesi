<?php
include 'header.php';
include './includes/db.php';

$category_sql = "SELECT * FROM categories WHERE status=1";
$stmt_category = $pdo->prepare($category_sql);
$stmt_category->execute();
$categories = $stmt_category->fetchAll(PDO::FETCH_ASSOC);

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
                        <li><a class="text-decoration-none" href="shop.php"><strong>Tüm Ürünler</strong></a></li>
                        <?php foreach ($categories as $category): ?>
                        <li>
                            <a class="text-decoration-none" href="shop.php?category_id=<?php echo $category['id']; ?>">
                                <?php echo $category['name']; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-inline shop-top-menu pb-3 pt-1">
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none mr-3" href="shop.php">Ürünler</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <a href="shop-single.php?id=<?php echo $product['id']; ?>">
                            <img src="assets/img/products/<?php echo $product['image_url']; ?>"
                                class="card-img-top card-img-custom" alt="<?php echo $product['name']; ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <a href="shop-single.php?id=<?php echo $product['id']; ?>"
                                class="h3 text-decoration-none text-dark fw-bold text-center mt-2"><?php echo $product['name']; ?></a>



                            <div class="mt-auto text-center">
                                <p class="h4 text-success fw-bold mb-0 pt-3"><?php echo $product['price']; ?> ₺</p>
                                <a href="shop-single.php?id=<?php echo $product['id']; ?>"
                                    class="btn btn-success mt-3 w-100">İncele</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning">Bu kategoride ürün bulunamadı.</div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php include('footer.php'); ?>