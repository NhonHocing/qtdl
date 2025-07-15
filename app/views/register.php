<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Đăng Ký Tài Khoản</h2>
        
        <?php if(!empty($errors)): ?>
            <div class="errors">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form action="index.php?action=register" method="post">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu:</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>
            

            <div class="form-group">
                <label for="fullname">Họ và tên:</label>
                <input type="text" name="fullname" id="fullname" required>
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" name="address" id="address" required>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            
            <div class="form-group">
                <button type="submit">Đăng Ký</button>
            </div>
            
            <div class="form-footer">
                <p>Đã có tài khoản? <a href="index.php?action=login">Đăng nhập</a></p>
            </div>
        </form>
    </div>
</body>
</html> 