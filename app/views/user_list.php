<h1>Danh sách người dùng</h1>
<ul>
    <?php foreach ($data['users'] as $user): ?>
        <li><?php echo $user['name']; ?></li>
    <?php endforeach; ?>
</ul>

