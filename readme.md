Cách setup:

B1: Clone project về

Lưu ý thư mục mysql_data phải rỗng

B2: Tại thư mục chứa docker-compose

Mở terminal, paste: docker compose -f 'docker-compose.yml' up -d --build 
  
B3: Truy cập http://localhost:8000/ 

Nếu thấy giao diện base index là đã setup thành công

B4: Truy cập http://localhost:8000/admin

Để vào giao diện django admin quản lý database

Tk:admin

mk:admin123

B5:Dùng postman gọi thử các api trong doc hoặc dùng frontend

Dòng command bên dưới để tạo bản sao lưu datasbase khi thay đổi dữ liệu database, nhớ commit nó đúng vị trí

docker-compose exec db sh -c 'mysqldump -uroot -p"root1234" qtdl_database' > db_init.sql

Có lỗi thì nhắn zalo
