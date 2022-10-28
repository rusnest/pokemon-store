### Ý tưởng:
Một project lưu trữ các pokemon trong phim Pokemon tuổi thơ.
Các tính năng:
- Auth bằng JWT

### Hướng dẫn chạy:
1. Chạy docker
```
cp .env.example .env
docker-compose up -d
```

### Hướng dẫn tạo jwt
```
php artisan jwt:secret
```
