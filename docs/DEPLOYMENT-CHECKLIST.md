# ✅ Deployment Checklist - v2.0

> Use this checklist before deploying to production

---

## 📋 Pre-Deployment

### Code Quality
- [ ] All tests passing (`php artisan test`)
- [ ] No console errors in browser
- [ ] No PHP errors in logs
- [ ] Code reviewed and approved
- [ ] Git committed and pushed

### Dependencies
- [ ] `composer install --optimize-autoloader --no-dev`
- [ ] `npm install --production`
- [ ] `npm run build`
- [ ] All dependencies up to date

### Configuration
- [ ] `.env` file configured for production
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` generated and set
- [ ] Database credentials correct
- [ ] Redis credentials correct
- [ ] Reverb credentials configured

### Security
- [ ] Strong passwords set
- [ ] 2FA enabled for admin accounts
- [ ] HTTPS/SSL configured
- [ ] CORS configured properly
- [ ] Rate limiting enabled
- [ ] `.env` file NOT in git
- [ ] Sensitive data encrypted

### Database
- [ ] Migrations run successfully
- [ ] Seeders run (if needed)
- [ ] Database backup created
- [ ] Indexes optimized
- [ ] Foreign keys validated

---

## 🚀 Deployment Steps

### 1. Server Setup
- [ ] PHP 8.2+ installed
- [ ] Composer installed
- [ ] Node.js 18+ installed
- [ ] MySQL 8.0+ installed
- [ ] Redis 7+ installed
- [ ] Nginx/Apache configured
- [ ] SSL certificate installed

### 2. Application Deployment
```bash
# Clone repository
git clone <repo> /var/www/laravel-absensi
cd /var/www/laravel-absensi

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install --production
npm run build

# Setup environment
cp .env.example .env
php artisan key:generate
php artisan reverb:install

# Configure database
php artisan migrate --force
php artisan db:seed --force

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Set permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### 3. Services Setup
- [ ] Nginx/Apache configured and running
- [ ] PHP-FPM configured and running
- [ ] MySQL configured and running
- [ ] Redis configured and running
- [ ] Reverb WebSocket server running
- [ ] Queue worker running
- [ ] Supervisor configured (for queue/reverb)

### 4. Supervisor Configuration
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/laravel-absensi/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/laravel-absensi/storage/logs/worker.log

[program:laravel-reverb]
process_name=%(program_name)s
command=php /var/www/laravel-absensi/artisan reverb:start
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/laravel-absensi/storage/logs/reverb.log
```

---

## 🧪 Post-Deployment Testing

### Functional Tests
- [ ] Homepage loads correctly
- [ ] Login works
- [ ] Registration works (if enabled)
- [ ] Check-in creates record
- [ ] Check-out updates record
- [ ] Dashboard shows data
- [ ] History page loads
- [ ] Filters work
- [ ] Pagination works

### Real-Time Tests
- [ ] WebSocket connects successfully
- [ ] Check-in triggers real-time update
- [ ] Dashboard updates without refresh
- [ ] Multiple tabs update simultaneously
- [ ] Reconnection works after disconnect

### Performance Tests
- [ ] Page load < 1 second
- [ ] Real-time update < 100ms
- [ ] No memory leaks
- [ ] No console errors
- [ ] Bundle size < 100KB

### Security Tests
- [ ] HTTPS working
- [ ] CSRF protection working
- [ ] XSS protection working
- [ ] SQL injection protected
- [ ] Rate limiting working
- [ ] Authentication working
- [ ] Authorization working

### Browser Tests
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile browsers

---

## 📊 Monitoring Setup

### Application Monitoring
- [ ] Error logging configured
- [ ] Performance monitoring enabled
- [ ] Uptime monitoring enabled
- [ ] Alert notifications configured

### Server Monitoring
- [ ] CPU usage monitoring
- [ ] Memory usage monitoring
- [ ] Disk space monitoring
- [ ] Network monitoring
- [ ] Database monitoring

### Log Files
- [ ] Laravel logs: `storage/logs/laravel.log`
- [ ] Nginx logs: `/var/log/nginx/`
- [ ] PHP-FPM logs: `/var/log/php-fpm/`
- [ ] Queue logs: `storage/logs/worker.log`
- [ ] Reverb logs: `storage/logs/reverb.log`

---

## 🔄 Backup Strategy

### Daily Backups
- [ ] Database backup automated
- [ ] File backup automated
- [ ] Backup verification automated
- [ ] Backup retention policy set

### Backup Locations
- [ ] Local backup: `/backups/`
- [ ] Remote backup: S3/Cloud Storage
- [ ] Offsite backup: Different datacenter

### Recovery Testing
- [ ] Restore procedure documented
- [ ] Recovery tested successfully
- [ ] RTO (Recovery Time Objective) defined
- [ ] RPO (Recovery Point Objective) defined

---

## 📈 Performance Optimization

### Caching
- [ ] Config cached
- [ ] Routes cached
- [ ] Views cached
- [ ] Events cached
- [ ] Redis cache working
- [ ] OPcache enabled

### Database
- [ ] Indexes optimized
- [ ] Queries optimized
- [ ] Connection pooling enabled
- [ ] Query caching enabled

### Assets
- [ ] Assets minified
- [ ] Assets compressed (gzip/brotli)
- [ ] CDN configured (optional)
- [ ] Browser caching enabled

---

## 🔒 Security Hardening

### Server Security
- [ ] Firewall configured
- [ ] SSH key-only access
- [ ] Fail2ban installed
- [ ] Security updates automated
- [ ] Unnecessary services disabled

### Application Security
- [ ] Debug mode disabled
- [ ] Error reporting disabled
- [ ] Directory listing disabled
- [ ] File permissions correct
- [ ] Sensitive files protected

### SSL/TLS
- [ ] SSL certificate valid
- [ ] HTTPS redirect enabled
- [ ] HSTS header enabled
- [ ] TLS 1.2+ only
- [ ] Strong cipher suites

---

## 📞 Support Setup

### Documentation
- [ ] Deployment docs updated
- [ ] API docs updated (if any)
- [ ] User guide updated
- [ ] Admin guide created

### Team Training
- [ ] Team trained on new features
- [ ] Support team briefed
- [ ] Escalation process defined
- [ ] Contact list updated

### Incident Response
- [ ] Incident response plan created
- [ ] On-call schedule defined
- [ ] Communication channels set
- [ ] Rollback procedure documented

---

## 🎯 Go-Live Checklist

### Final Checks (1 hour before)
- [ ] All tests passing
- [ ] Backup created
- [ ] Team notified
- [ ] Monitoring active
- [ ] Rollback plan ready

### Go-Live (T-0)
- [ ] Deploy code
- [ ] Run migrations
- [ ] Clear caches
- [ ] Restart services
- [ ] Verify deployment

### Post Go-Live (1 hour after)
- [ ] Monitor logs
- [ ] Check performance
- [ ] Test critical features
- [ ] Monitor user feedback
- [ ] Document issues

### Post Go-Live (24 hours after)
- [ ] Review metrics
- [ ] Check error rates
- [ ] Verify backups
- [ ] Team retrospective
- [ ] Update documentation

---

## 🚨 Rollback Plan

### If Issues Occur
1. **Stop deployment**
2. **Assess severity**
3. **Decide: Fix forward or rollback**

### Rollback Steps
```bash
# 1. Switch to previous version
git checkout <previous-tag>

# 2. Restore database (if needed)
mysql laravel_absensi < backup.sql

# 3. Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 4. Restart services
sudo supervisorctl restart all
sudo systemctl restart nginx
```

### Post-Rollback
- [ ] Verify system working
- [ ] Notify team
- [ ] Document issues
- [ ] Plan fix
- [ ] Schedule re-deployment

---

## 📊 Success Metrics

### Performance Targets
- [ ] Page load < 1s
- [ ] Real-time update < 100ms
- [ ] Uptime > 99.9%
- [ ] Error rate < 0.1%

### Business Metrics
- [ ] User adoption rate
- [ ] Feature usage rate
- [ ] User satisfaction score
- [ ] Support ticket volume

---

## ✅ Deployment Complete!

**Congratulations! Your application is now live! 🎉**

### Next Steps
1. Monitor for 24 hours
2. Gather user feedback
3. Plan next iteration
4. Celebrate success! 🎊

---

**Need help?** See [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md) or contact support@example.com
