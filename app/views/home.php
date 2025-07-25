<?php $title = 'Trang chủ'; ?>
<?php include 'layouts/header.php'; ?>

<link rel="stylesheet" href="public/css/style_home.css">

<section class="hero">
    <div class="hero-content">
        <h2>Hệ thống đặt vé ghe chợ nổi Cái Răng</h2>
        <p>Đặt vé ghe nhanh chóng, an toàn, tiện lợi</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?view=booking" class="btn">Đặt vé ngay</a>
        <?php else: ?>
            <a href="index.php?action=login" class="btn">Đăng nhập để đặt vé</a>
        <?php endif; ?>
    </div>
</section>

<section class="features">
    <h3>Lý do chọn chúng tôi</h3>
    <div class="feature-grid">
        <div class="feature-box">
            <img src="public/images/icon1.png" alt="Icon" />
            <h4>Tiện lợi</h4>
            <p>Đặt vé mọi lúc mọi nơi chỉ với vài bước.</p>
        </div>
        <div class="feature-box">
            <img src="public/images/icon2.png" alt="Icon" />
            <h4>Minh bạch</h4>
            <p>Thông tin ghe và giá vé rõ ràng, không phát sinh.</p>
        </div>
        <div class="feature-box">
            <img src="public/images/icon3.png" alt="Icon" />
            <h4>Hỗ trợ 24/7</h4>
            <p>Đội ngũ chăm sóc khách hàng luôn sẵn sàng giúp bạn.</p>
        </div>
    </div>
</section>

<section class="contact">
    <h3>Liên hệ</h3>
    <p>📍 Bến Ninh Kiều, TP. Cần Thơ</p>
    <p>📞 0909 123 456</p>
</section>

<?php include 'layouts/footer.php'; ?>
