<?php
include("header.php");
include './includes/db.php';
$message_sent = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    if (!empty($name) && !empty($email) && empty($message)) {
        $sql = "INSERT INTO messages (name,email,subject,message) VALUES (:name,:email,:subject,:message)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]);

        if ($result) {
            $message_sent = true;
        }
    }
}
?>

<div class="container-fluid bg-light py-5">
    <div class="col-md-6 m-auto text-center">
        <h1 class="h1">İletişim</h1>
        <p>Sorularınız, önerileriniz veya işbirlikleri için bize her zaman ulaşabilirsiniz.</p>
    </div>
</div>

<div class="position-relative w-100" style="height: 300px;">

    <div id="map-loader"
        class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-light"
        style="z-index: 1000; transition: opacity 0.5s ease;">
        <div class="text-center">
            <div class="spinner-border text-success" role="status"></div>
            <p class="mt-2 text-muted small fw-bold">Harita Yükleniyor...</p>
        </div>
    </div>

    <div id="mapid" class="w-100 h-100"></div>

</div>

<div class="container py-5">
    <div class="row py-5">
        <?php if ($message_sent): ?>
            <div class="col-12 mb-4">
                <div class="alert alert-success text-center">
                    <i class="fa fa-check-circle fa-2x"></i><br>
                    Mesajınız başarıyla bize ulaştı! En kısa sürede dönüş yapacağız.
                </div>
            </div>
        <?php endif; ?>

        <form class="col-md-9 m-auto" method="post" role="form">
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <label for="inputname">Adınız Soyadınız</label>
                    <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Adınız" required>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label for="inputemail">E-posta Adresiniz</label>
                    <input type="email" class="form-control mt-1" id="email" name="email" placeholder="E-posta"
                        required>
                </div>
            </div>
            <div class="mb-3">
                <label for="inputsubject">Konu</label>
                <input type="text" class="form-control mt-1" id="subject" name="subject" placeholder="Konu" required>
            </div>
            <div class="mb-3">
                <label for="inputmessage">Mesajınız</label>
                <textarea class="form-control mt-1" id="message" name="message" placeholder="Mesajınız" rows="8"
                    required></textarea>
            </div>
            <div class="row">
                <div class="col text-end mt-2">
                    <button type="submit" class="btn btn-success btn-lg px-3">Mesajı Gönder</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (document.getElementById('mapid')) {
            // Konum : Eskişehir Osmangazi Üniversitesi
            var mymap = L.map('mapid').setView([39.7505, 30.4950], 13);
            var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            });

            tiles.addTo(mymap);

            L.marker([39.7505, 30.4950]).addTo(mymap)
                .bindPopup("<b>Zay Shop</b><br />Eskişehir Merkez Ofis").openPopup();

            // Yükleme bitince loader da bitecek
            tiles.on('load', function () {
                var loader = document.getElementById('map-loader');
                if (loader) {
                    loader.style.opacity = '0';
                    setTimeout(function () {
                        loader.style.display = 'none';
                    }, 500);
                }
            });
        }
    });
</script>

<?php include("footer.php"); ?>