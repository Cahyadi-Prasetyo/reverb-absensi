# ⚡ Quick Start Guide

> Get Laravel Reverb Absensi running in 5 minutes!

---

## 🎯 For New Users

### Option 1: Docker (Recommended)

```bash
# 1. Clone repository
git clone https://github.com/yourusername/laravel-reverb-absensi.git
cd laravel-reverb-absensi

# 2. Copy environment
copy .env.docker.example .env.docker

# 3. Start Docker
docker-compose up -d

# 4. Setup database
docker exec laravel_absensi_app_1 php artisan migrate --seed

# 5. Open browser
# http://localhost
# Login: user1@example.com / password
```

### Option 2: Local Development

```bash
# 1. Clone repository
git clone https://github.com/yourusername/laravel-reverb-absensi.git
cd laravel-reverb-absensi

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
copy .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_absensi
DB_USERNAME=root
DB_PASSWORD=

# 5. Setup Reverb
php artisan reverb:install

# 6. Run migrations
php artisan migrate --seed

# 7. Build assets
npm run build

# 8. Start servers (3 terminals)
# Terminal 1:
php artisan serve

# Terminal 2:
php artisan reverb:start

# Terminal 3:
php artisan queue:work

# 9. Open browser
# http://localhost:8000
# Login: user1@example.com / password
```

---

## 🔄 For Existing Users (Upgrading from v1.0)

```bash
# 1. Backup
git add .
git commit -m "Backup before upgrade"

# 2. Pull latest
git pull origin main

# 3. Install new dependencies
composer install
npm install

# 4. Build assets
npm run build

# 5. Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 6. Restart servers
# Ctrl+C to stop old servers, then:
php artisan serve
php artisan reverb:start
php artisan queue:work
```

**Full upgrade guide:** [UPGRADE-GUIDE.md](UPGRADE-GUIDE.md)

---

## 🧪 Test Real-Time Features

### Test 1: Check-In
1. Open http://localhost:8000
2. Login as `user1@example.com` / `password`
3. Click "Check In/Out" menu
4. Click "Check In" button
5. ✅ Should see success message

### Test 2: Real-Time Dashboard
1. Open 2 browser tabs
2. **Tab 1:** Login as `user1@example.com`
3. **Tab 2:** Login as `user2@example.com`
4. **Tab 2:** Go to Dashboard
5. **Tab 1:** Click "Check In"
6. ✅ **Tab 2 should auto-update** without refresh!

### Test 3: History
1. Go to "History" menu
2. Filter by status or month
3. ✅ Should see paginated results

---

## 📊 Performance Check

### Expected Metrics (v2.0)

```bash
# Page Load Speed
Initial Load: < 1 second
Dashboard Update: < 100ms

# Bundle Size
npm run build
# Should see: app-livewire-*.js ~45-50KB

# WebSocket Connection
# Open DevTools → Network → WS
# Should see: ws://localhost:8080 (connected)
```

---

## 🐛 Common Issues

### Issue: "Connection refused"

**Solution:**
```bash
# Check if Reverb is running
php artisan reverb:start

# Check .env
REVERB_HOST=localhost
REVERB_PORT=8080
```

### Issue: "Vite manifest not found"

**Solution:**
```bash
npm run build
php artisan config:clear
```

### Issue: "Class Livewire not found"

**Solution:**
```bash
composer dump-autoload
php artisan config:clear
```

### Issue: "Styles not loading"

**Solution:**
```bash
npm run build
php artisan view:clear
# Hard refresh browser (Ctrl+Shift+R)
```

---

## 🎯 Next Steps

After successful setup:

1. **Explore Features**
   - Dashboard (real-time stats)
   - Check-In/Out (attendance tracking)
   - History (filtered records)

2. **Customize**
   - Update `.env` settings
   - Modify `config/attendance.php`
   - Customize Livewire components

3. **Deploy**
   - See [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md)
   - Configure production `.env`
   - Setup SSL certificates

---

## 📚 Documentation

- [README.md](README.md) - Project overview
- [UPGRADE-GUIDE.md](UPGRADE-GUIDE.md) - Upgrade from v1.0
- [docs/GETTING-STARTED.md](docs/GETTING-STARTED.md) - Detailed setup
- [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md) - System architecture
- [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md) - Development guide
- [docs/MIGRATION-TO-LIVEWIRE.md](docs/MIGRATION-TO-LIVEWIRE.md) - Migration details

---

## 🆘 Need Help?

- **Documentation:** [docs/](docs/)
- **Issues:** [GitHub Issues](https://github.com/yourusername/laravel-reverb-absensi/issues)
- **Email:** support@example.com

---

**Ready to go? Start with Option 1 (Docker) for the fastest setup! 🚀**
