<?php include 'header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8 m-auto text-center">
            <h1 class="h1 fw-bold text-success">Proje Raporu ve Dökümantasyon</h1>
            <p class="lead text-muted">
                E-Ticaret Projesi Geliştirme Süreci, Teknik Detaylar ve Veritabanı Yapısı
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i> 1. Projenin Amacı ve Kapsamı</h5>
                </div>
                <div class="card-body">
                    <p>
                        Bu projenin temel amacı, <strong>PHP</strong> programlama dili ve <strong>MySQL</strong>
                        veritabanı yönetim sistemi kullanılarak, dinamik, yönetilebilir bir
                        <strong>E-Ticaret</strong> platformu geliştirmektir.
                    </p>
                    <p>
                        Proje kapsamında, statik bir HTML şablonu (Zay Shop) parçalanarak dinamik hale getirilmiş,
                        veritabanı mimarisi kurgulanmış ve temel e-ticaret fonksiyonları (ürün listeleme, detay
                        görüntüleme, varyasyon seçimi, sepet yönetimi, sipariş oluşturma) backend tarafında
                        kodlanmıştır.
                    </p>
                    <hr>
                    <h6 class="fw-bold">Kullanılan Teknolojiler:</h6>
                    <ul class="list-inline">
                        <li class="list-inline-item"><span class="badge bg-secondary">PHP</span></li>
                        <li class="list-inline-item"><span class="badge bg-secondary">MySQL</span></li>
                        <li class="list-inline-item"><span class="badge bg-secondary">HTML5 & CSS3</span></li>
                        <li class="list-inline-item"><span class="badge bg-secondary">Bootstrap</span></li>
                        <li class="list-inline-item"><span class="badge bg-secondary">jQuery / AJAX</span></li>
                        <li class="list-inline-item"><span class="badge bg-secondary">Apache (XAMPP)</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-code-branch me-2"></i> 2. Arayüz Entegrasyonu ve Geliştirme</h5>
                </div>
                <div class="card-body">
                    <p>Projede "Zay Shop" HTML şablon kullanılmıştır. Şablonun statik yapısı, PHP
                        include yapısı ile (header, footer, db.php) modüler hale getirilmiştir.</p>


                    <div class="row text-center mt-4">
                        <div class="col-md-12 mb-3">
                            <div class="border p-2 rounded h-100">
                                <a href="https://templatemo.com/tm-559-zay-shop" target="_blank"
                                    title="Orijinal Temayı Görüntüle">
                                    <img src="assets/img/rapor/tema_ilk_hali.jpg" alt="Temanın İlk Hali"
                                        class="img-fluid" style="max-height: 250px;">
                                </a>
                                <p class="mt-2 fw-bold text-muted mb-0">Temanın İlk Hali (Live)</p>
                                <a href="https://templatemo.com/live/templatemo_559_zay_shop" target="_blank"
                                    class="small text-secondary text-decoration-none">
                                    <i class="fas fa-external-link-alt"></i> Kaynağı Gör (TemplateMo)
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-database me-2"></i> 3. Veritabanı Mimarisi (E-R Diyagramı)</h5>
                </div>
                <div class="card-body">
                    <p>Projede <strong>İlişkisel Veritabanı (Relational Database)</strong> yapısı kullanılmıştır.
                        Ürünler, kategoriler ve varyasyonlar (renk/beden) ayrı tablolarda tutularak veri tekrarı
                        önlenmiştir.</p>

                    <div class="text-center my-4">
                        <img src="assets/img/rapor/db_sema.png" alt="Veritabanı Şeması"
                            class="img-fluid border shadow-sm" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i> 4. Proje Özellikleri ve Kaynak Kod</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Geliştirilen Fonksiyonlar:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> PDO ile
                                    güvenli Veritabanı Bağlantısı</li>
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Dinamik Ürün
                                    Listeleme ve Kategori Filtreleme</li>
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Ürün Detay
                                    Sayfası ve Varyasyon (Renk/Beden) Sistemi</li>
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Session
                                    Tabanlı Sepet Uygulaması (Ekle/Sil/Onayla)</li>
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> AJAX ile
                                    Canlı Ürün Arama (Live Search)</li>
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> İletişim
                                    Formu Validasyonu ve DB Kaydı</li>
                            </ul>
                        </div>
                        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center border-start">
                            <i class="fab fa-github fa-5x text-dark mb-3"></i>
                            <h5 class="fw-bold">Kaynak Kodlar</h5>
                            <p class="text-center">Projenin tüm kaynak kodlarına
                                aşağıdaki GitHub linkinden ulaşabilirsiniz.</p>
                            <a href="https://github.com/hasancansevim/e-ticaret-projesi" target="_blank"
                                class="btn btn-dark btn-lg">
                                <i class="fab fa-github me-2"></i> GitHub Reposuna Git
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>