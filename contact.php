<?php
include("header.php");
include './includes/db.php';
$message_sent = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    if (!empty($name) && !empty($email) && empty($$message)) {
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
        <p>
            Sorularınız, önerileriniz veya işbirlikleri için bize her zaman ulaşabilirsiniz.
        </p>
    </div>
</div>

<div id="mapid" style="width: 100%; height: 300px;"></div>

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
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById('mapid')) {
        // İstanbul Koordinatları (41.0082, 28.9784)
        var mymap = L.map('mapid').setView([41.0082, 28.9784], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(mymap);

        L.marker([41.0082, 28.9784]).addTo(mymap)
            .bindPopup("<b>Zay Shop</b><br />Merkez Ofisimiz.").openPopup();
    }
});
</script>

<?php include("footer.php"); ?>