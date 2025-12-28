<footer class="bg-dark" id="tempaltemo_footer">
    <div class="container">
        <div class="row">

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-success border-bottom pb-3 border-light logo">Zay Shop</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li>
                        <i class="fas fa-map-marker-alt fa-fw"></i>
                        Meşelik Kampüsü, Osmangazi Üniversitesi, 26040 Eskişehir
                    </li>
                    <li>
                        <i class="fa fa-phone fa-fw"></i>
                        <a class="text-decoration-none" href="tel:02121234567">0212 123 45 67</a>
                    </li>
                    <li>
                        <i class="fa fa-envelope fa-fw"></i>
                        <a class="text-decoration-none" href="mailto:info@zayshop.com">info@zayshop.com</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Ürünler</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li><a class="text-decoration-none" href="shop.php">Tüm Ürünler</a></li>
                    <li><a class="text-decoration-none" href="shop.php?category_id=1">Saatler</a></li>
                    <li><a class="text-decoration-none" href="shop.php?category_id=2">Ayakkabılar</a></li>
                    <li><a class="text-decoration-none" href="shop.php?category_id=3">Aksesuarlar</a></li>
                    <li><a class="text-decoration-none" href="shop.php">Spor Giyim</a></li>
                    <li><a class="text-decoration-none" href="shop.php">Gözlükler</a></li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Kurumsal</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li><a class="text-decoration-none" href="index.php">Ana Sayfa</a></li>
                    <li><a class="text-decoration-none" href="about.php">Hakkımızda</a></li>
                    <li><a class="text-decoration-none" href="contact.php">İletişim</a></li>
                    <li><a class="text-decoration-none" href="#">Sıkça Sorulan Sorular</a></li>
                    <li><a class="text-decoration-none" href="#">İade ve Değişim</a></li>
                </ul>
            </div>

        </div>


    </div>

    <div class="w-100 bg-black py-3">
        <div class="container">
            <div class="row pt-2">
                <div class="col-12">
                    <p class="text-left text-light">
                        Copyright &copy; 2025 Zay Shop
                        | Designed by <a rel="sponsored" href="https://templatemo.com" target="_blank">TemplateMo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</footer>
<script src="assets/js/jquery-1.11.0.min.js"></script>
<script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/templatemo.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/custom.js"></script>


<script>
    $(document).ready(function () {
        $('#inputModalSearch').keyup(function () {
            var txt = $(this).val();

            if (txt == '') {
                $('#search-results').html('');
            } else {
                $.ajax({
                    url: "ajax_search.php",
                    method: "POST",
                    data: {
                        query: txt
                    },
                    success: function (data) {
                        $('#search-results').html(data);
                    }
                });
            }
        });
    });
</script>
</body>

</html>