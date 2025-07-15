<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Đăng Nhập</h2>
        
        <?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="success">
                <p>Đăng ký tài khoản thành công! Vui lòng đăng nhập.</p>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($errors)): ?>
            <div class="errors">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form action="index.php?action=login" method="post">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password">
            </div>
            
            <div class="form-group">
                <button type="submit">Đăng Nhập</button>
            </div>
            
            <div class="form-footer">
                <p>Chưa có tài khoản? <a href="index.php?action=register">Đăng ký</a></p>
            </div>
        </form>
    </div>
</body>
</html> 