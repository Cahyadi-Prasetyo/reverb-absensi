# 🔧 Troubleshooting Guide

**Last Updated:** November 9, 2025

---

## ✅ Fixed Issues

### Issue 1: Database Connection Error

**Error:**
```
SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql failed: No such host is known.
```

**Root Cause:**
- `.env` menggunakan `DB_HOST=mysql` (untuk Docker internal)
- `php artisan` dijalankan di lokal (bukan di dalam container)
- Lokal tidak bisa resolve hostname `mysql`

**Solution:**
```env
# Change from:
DB_HOST=mysql

# To:
DB_HOST=127.0.0.1
```

**Steps Taken:**
1. ✅ Started Docker MySQL & Redis
2. ✅ Changed `DB_HOST` to `127.0.0.1` in `.env`
3. ✅ Cleared config cache: `php artisan config:clear`
4. ✅ Verified connection: `php artisan migrate:status`
5. ✅ Created admin user: `php artisan db:seed --class=AdminUserSeeder`

**Result:** ✅ Fixed - Database connected successfully

---

## 🐛 Common Issues & Solutions

### Database Connection Issues

#### Issue: Cannot connect to MySQL

**Check Docker status:**
```bash
docker-compose ps
```

**Expected output:**
```
NAME                    STATUS
laravel_absensi_mysql   Up (healthy)
laravel_absensi_redis   Up (healthy)
```

**If not running:**
```bash
docker-compose up -d mysql redis
```

**Wait for healthy status:**
```bash
# Wait 10-15 seconds, then check
docker-compose ps
```

#### Issue: Wrong database credentials

**Check .env:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1  # For local artisan commands
DB_PORT=3306
DB_DATABASE=laravel_absensi
DB_USERNAME=root
DB_PASSWORD=secret  # Must match docker-compose.yml
```

**Test connection:**
```bash
php artisan migrate:status
```

---

### Admin Access Issues

#### Issue: 403 Forbidden when accessing /admin

**Cause:** User doesn't have admin role

**Solution:**
```bash
php artisan tinker
>>> $user = User::where('email', 'your@email.com')->first();
>>> $user->role = 'admin';
>>> $user->save();
>>> exit
```

**Or create new admin:**
```bash
php artisan db:seed --class=AdminUserSeeder
```

**Admin credentials:**
- Email: `admin@example.com`
- Password: `password`

#### Issue: Admin routes not found

**Clear caches:**
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

**Verify routes exist:**
```bash
php artisan route:list --path=admin
```

**Expected output:**
```
GET|HEAD  admin .................. admin.dashboard
GET|HEAD  admin/users ............ admin.users.index
POST      admin/users ............ admin.users.store
...
```

---

### Frontend Issues

#### Issue: Vite manifest not found

**Solution:**
```bash
npm run build
php artisan config:clear
```

**For development:**
```bash
npm run dev
```

#### Issue: Styles not loading

**Solution:**
```bash
# Rebuild assets
npm run build

# Clear view cache
php artisan view:clear

# Hard refresh browser
# Windows: Ctrl + Shift + R
# Mac: Cmd + Shift + R
```

#### Issue: Vue components not rendering

**Check console for errors:**
1. Open browser DevTools (F12)
2. Check Console tab for JavaScript errors
3. Check Network tab for failed requests

**Common fixes:**
```bash
# Reinstall dependencies
npm install

# Rebuild
npm run build

# Clear all caches
php artisan optimize:clear
```

---

### Docker Issues

#### Issue: Docker containers not starting

**Check Docker Desktop is running**

**View logs:**
```bash
docker-compose logs mysql
docker-compose logs redis
```

**Restart containers:**
```bash
docker-compose down
docker-compose up -d mysql redis
```

#### Issue: Port already in use

**Error:**
```
Error: bind: address already in use
```

**Solution:**
```bash
# Check what's using the port
netstat -ano | findstr :3306  # Windows
lsof -i :3306                 # Mac/Linux

# Stop the process or change port in docker-compose.yml
```

---

### Migration Issues

#### Issue: Migration failed

**Check database connection:**
```bash
php artisan migrate:status
```

**Reset and re-run:**
```bash
php artisan migrate:fresh --seed
```

**⚠️ Warning:** This will delete all data!

#### Issue: Seeder failed

**Check seeder class exists:**
```bash
php artisan db:seed --class=AdminUserSeeder
```

**If class not found:**
```bash
composer dump-autoload
php artisan db:seed --class=AdminUserSeeder
```

---

### Performance Issues

#### Issue: Slow page loads

**Clear all caches:**
```bash
php artisan optimize:clear
```

**Optimize for production:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

#### Issue: High memory usage

**Check queue workers:**
```bash
# Stop all workers
php artisan queue:restart

# Start with memory limit
php artisan queue:work --memory=128
```

---

## 🔍 Debugging Commands

### Check Application Status

```bash
# Application info
php artisan about

# Check routes
php artisan route:list

# Check config
php artisan config:show database

# Check migrations
php artisan migrate:status
```

### Check Database

```bash
# Test connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check tables
>>> DB::select('SHOW TABLES');

# Check users
>>> User::count();
>>> User::where('role', 'admin')->get();
```

### Check Docker

```bash
# Container status
docker-compose ps

# View logs
docker-compose logs -f mysql

# Execute commands in container
docker-compose exec mysql mysql -uroot -psecret laravel_absensi
```

---

## 📝 Environment Configuration

### Development (.env)

```env
APP_ENV=local
APP_DEBUG=true

DB_HOST=127.0.0.1  # For local artisan
DB_PORT=3306
DB_DATABASE=laravel_absensi
DB_USERNAME=root
DB_PASSWORD=secret

CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=database

BROADCAST_CONNECTION=reverb
```

### Docker (.env.docker)

```env
APP_ENV=production
APP_DEBUG=false

DB_HOST=mysql  # Docker internal hostname
DB_PORT=3306
DB_DATABASE=laravel_absensi
DB_USERNAME=root
DB_PASSWORD=secret
```

---

## 🆘 Still Having Issues?

### Collect Information

```bash
# Laravel version
php artisan --version

# PHP version
php -v

# Composer version
composer --version

# Node version
node -v
npm -v

# Docker version
docker --version
docker-compose --version
```

### Check Logs

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Docker logs
docker-compose logs -f

# Nginx logs (if using Docker)
docker-compose logs nginx
```

### Reset Everything

**⚠️ Nuclear option - will delete all data:**

```bash
# Stop all services
docker-compose down -v

# Clear all caches
php artisan optimize:clear
rm -rf bootstrap/cache/*.php

# Reinstall dependencies
composer install
npm install

# Rebuild
npm run build

# Start fresh
docker-compose up -d
php artisan migrate:fresh --seed
php artisan db:seed --class=AdminUserSeeder
```

---

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Inertia.js Documentation](https://inertiajs.com)
- [Docker Documentation](https://docs.docker.com)
- [Project Documentation](README.md)

---

## 🎯 Quick Fix Checklist

When something breaks, try these in order:

1. ✅ Clear caches
   ```bash
   php artisan optimize:clear
   ```

2. ✅ Check Docker status
   ```bash
   docker-compose ps
   ```

3. ✅ Verify database connection
   ```bash
   php artisan migrate:status
   ```

4. ✅ Rebuild assets
   ```bash
   npm run build
   ```

5. ✅ Check logs
   ```bash
   tail -f storage/logs/laravel.log
   ```

6. ✅ Restart services
   ```bash
   docker-compose restart
   ```

---

**Last Resort:** Check [CONVERSATION-LOG.md](CONVERSATION-LOG.md) for implementation details.
