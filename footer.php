<footer class="bg-dark" id="tempaltemo_footer">
    <div class="container">
        <div class="row">

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-success border-bottom pb-3 border-light logo">Zay Shop</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li>
                        <i class="fas fa-map-marker-alt fa-fw"></i>
                        Maslak Mah. Büyükdere Cad. No: 123<br> Sarıyer / İstanbul
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
                    <li><a class="text-decoration-none" href="index.php">Anasayfa</a></li>
                    <li><a class="text-decoration-none" href="about.php">Hakkımızda</a></li>
                    <li><a class="text-decoration-none" href="contact.php">İletişim</a></li>
                    <li><a class="text-decoration-none" href="#">Sıkça Sorulan Sorular</a></li>
                    <li><a class="text-decoration-none" href="#">İade ve Değişim</a></li>
                </ul>
            </div>

        </div>

        <div class="row text-light mb-4">
            <div class="col-12 mb-3">
                <div class="w-100 my-3 border-top border-light"></div>
            </div>

            <div class="col-auto me-auto">
                <ul class="list-inline text-left footer-icons">
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="http://facebook.com/"><i
                                class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/"><i
                                class="fab fa-instagram fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/"><i
                                class="fab fa-twitter fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.linkedin.com/"><i
                                class="fab fa-linkedin fa-lg fa-fw"></i></a>
                    </li>
                </ul>
            </div>

            <div class="col-auto">
                <label class="sr-only" for="subscribeEmail">E-Posta Adresi</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control bg-dark border-light" id="subscribeEmail"
                        placeholder="E-Posta Adresiniz">
                    <div class="input-group-text btn-success text-light">Abone Ol</div>
                </div>
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
                        | Developer: <strong>Hasan Can Sevim</strong>
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
$(document).ready(function() {
    $('#inputModalSearch').keyup(function() {
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
                success: function(data) {
                    $('#search-results').html(data);
                }
            });
        }
    });
});
</script>
</body>

</html>