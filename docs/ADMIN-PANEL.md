# 🎛️ Admin Panel Documentation

**Version:** 1.0.0  
**Status:** ✅ Phase 1 Complete  
**Last Updated:** November 9, 2025

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Quick Start](#quick-start)
3. [Features](#features)
4. [Testing Guide](#testing-guide)
5. [Development Progress](#development-progress)
6. [Troubleshooting](#troubleshooting)

---

## Overview

Admin Panel untuk mengelola sistem absensi dengan fitur lengkap user management, attendance management, dan reporting.

### Tech Stack
- **Backend:** Laravel 12 + Inertia.js
- **Frontend:** Vue 3 + TypeScript + Tailwind CSS
- **Auth:** Role-based (admin, manager, employee)

### Access
```
URL: http://localhost:8000/admin
Email: admin@example.com
Password: password
```

---

## Quick Start

### 1. Setup Database

```bash
# Start Docker services
docker-compose up -d mysql redis

# Wait for healthy status
docker-compose ps
```

### 2. Create Admin User

```bash
php artisan db:seed --class=AdminUserSeeder
```

### 3. Start Server

```bash
php artisan serve
```

### 4. Access Admin Panel

Open browser: `http://localhost:8000/admin`

---

## Features

### ✅ Phase 1: User Management (Complete)

**Dashboard:**
- Total users statistics
- Total attendances
- Today's check-ins
- On-time percentage
- Recent attendances table

**User Management:**
- List all users with pagination (15/page)
- Search by name, email, employee_id
- Filter by role (admin, manager, employee)
- Create new user
- Edit existing user
- View user details with statistics
- Delete user (with confirmation)
- Prevent self-deletion

**UI Features:**
- Responsive design
- Flash messages (success/error)
- Loading states
- Form validation
- Confirmation dialogs
- Color-coded badges

### ⏳ Phase 2: Attendance Management (Planned)

- View all attendances
- Filter by date range, user, status
- Edit/correct attendance records
- Export to Excel/PDF
- Bulk actions
- Advanced statistics

### ⏳ Phase 3: Reports & Analytics (Planned)

- Custom date range reports
- Department comparison
- Attendance trends charts
- Late/on-time analysis
- Export functionality

---

## Testing Guide

### Pre-Testing Checklist

- [ ] Docker MySQL & Redis running
- [ ] Laravel server running (`php artisan serve`)
- [ ] Admin user created
- [ ] Browser DevTools open (F12)

### Test Scenarios

#### 1. Authentication
```
✓ Login as admin
✓ Access /admin
✓ Verify dashboard loads
✓ Check statistics display
```

#### 2. User List
```
✓ View users table
✓ Search by name
✓ Filter by role
✓ Test pagination
✓ Click action buttons
```

#### 3. Create User
```
✓ Click "Add User"
✓ Fill form
✓ Submit
✓ Verify success message
✓ Check user in list
```

#### 4. Edit User
```
✓ Click edit icon
✓ Update fields
✓ Submit
✓ Verify changes saved
✓ Test password update (optional)
```

#### 5. View User
```
✓ Click view icon
✓ Check user info
✓ Verify statistics
✓ Check recent attendances
```

#### 6. Delete User
```
✓ Click delete icon
✓ Confirm deletion
✓ Verify user removed
✓ Test self-deletion (should fail)
```

#### 7. Flash Messages
```
✓ Create user → success message
✓ Validation error → error message
✓ Auto-hide after 5 seconds
✓ Manual close button works
```

### Expected Results

All tests should pass with:
- ✅ No console errors
- ✅ No PHP errors
- ✅ Flash messages display correctly
- ✅ Data persists in database
- ✅ UI responsive on all screen sizes

---

## Development Progress

### Phase 1: User Management ✅ 100%

**Backend (Complete):**
- ✅ AdminMiddleware
- ✅ Admin routes
- ✅ DashboardController
- ✅ UserController (CRUD)
- ✅ AdminUserSeeder

**Frontend (Complete):**
- ✅ AdminLayout
- ✅ Dashboard page
- ✅ Users Index (list)
- ✅ Users Create (form)
- ✅ Users Edit (form)
- ✅ Users Show (detail)
- ✅ FlashMessage component

**Files Created:** 18 files  
**Lines of Code:** ~3,700 lines  
**Development Time:** ~8 hours

### Phase 2: Attendance Management ⏳ 0%

**Planned Features:**
- Attendance list with filters
- Edit attendance records
- Export functionality
- Bulk actions
- Advanced statistics

**Estimated Time:** 1 week

### Phase 3: Reports & Analytics ⏳ 0%

**Planned Features:**
- Custom reports
- Charts & visualizations
- Department comparison
- Trend analysis
- Scheduled reports

**Estimated Time:** 1 week

---

## Troubleshooting

### Common Issues

#### Issue: 403 Forbidden

**Cause:** User doesn't have admin role

**Solution:**
```bash
php artisan tinker
>>> $user = User::where('email', 'your@email.com')->first();
>>> $user->role = 'admin';
>>> $user->save();
```

#### Issue: Database Connection Error

**Cause:** Docker not running or wrong DB_HOST

**Solution:**
```bash
# Check Docker
docker-compose ps

# Update .env
DB_HOST=127.0.0.1  # For local artisan

# Clear cache
php artisan config:clear
```

#### Issue: Routes Not Found

**Solution:**
```bash
php artisan route:clear
php artisan config:clear
php artisan route:list --path=admin
```

#### Issue: Styles Not Loading

**Solution:**
```bash
npm run build
php artisan view:clear
# Hard refresh browser (Ctrl+Shift+R)
```

#### Issue: Flash Messages Not Showing

**Check:**
1. FlashMessage component imported in AdminLayout
2. Controller returns with flash message:
   ```php
   return redirect()->route('admin.users.index')
       ->with('success', 'User created successfully.');
   ```
3. No JavaScript errors in console

### Debug Commands

```bash
# Check application status
php artisan about

# Check routes
php artisan route:list --path=admin

# Check database
php artisan migrate:status

# Check logs
tail -f storage/logs/laravel.log

# Check Docker
docker-compose logs -f mysql
```

---

## API Reference

### Admin Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | /admin | admin.dashboard | Dashboard |
| GET | /admin/users | admin.users.index | List users |
| GET | /admin/users/create | admin.users.create | Create form |
| POST | /admin/users | admin.users.store | Store user |
| GET | /admin/users/{user} | admin.users.show | Show user |
| GET | /admin/users/{user}/edit | admin.users.edit | Edit form |
| PUT | /admin/users/{user} | admin.users.update | Update user |
| DELETE | /admin/users/{user} | admin.users.destroy | Delete user |

### Middleware

All admin routes protected by:
- `auth` - Must be logged in
- `verified` - Email must be verified
- `admin` - Must have admin role

---

## File Structure

```
app/
├── Http/
│   ├── Controllers/Admin/
│   │   ├── DashboardController.php
│   │   └── UserController.php
│   └── Middleware/
│       └── AdminMiddleware.php

resources/js/
├── layouts/
│   └── AdminLayout.vue
├── pages/Admin/
│   ├── Dashboard.vue
│   └── Users/
│       ├── Index.vue
│       ├── Create.vue
│       ├── Edit.vue
│       └── Show.vue
└── components/
    └── FlashMessage.vue

routes/
├── web.php
└── admin.php

database/seeders/
└── AdminUserSeeder.php
```

---

## Best Practices

### Security
- ✅ Always use middleware for admin routes
- ✅ Validate all inputs
- ✅ Hash passwords with bcrypt
- ✅ Prevent self-deletion
- ✅ Use CSRF protection

### Performance
- ✅ Paginate large datasets
- ✅ Debounce search inputs
- ✅ Use eager loading for relationships
- ✅ Cache frequently accessed data

### UX
- ✅ Show loading states
- ✅ Display flash messages
- ✅ Confirm destructive actions
- ✅ Provide clear error messages
- ✅ Make UI responsive

---

## Next Steps

### After Phase 1 Testing

1. **Fix Bugs** - Address any issues found
2. **Gather Feedback** - Get user input
3. **Plan Phase 2** - Detail attendance management
4. **Start Development** - Begin Phase 2 implementation

### Future Enhancements

- Real-time updates via WebSocket
- Advanced search with filters
- Bulk operations
- Activity logs
- Email notifications
- Mobile app support

---

## Support

**Documentation:**
- [Getting Started](GETTING-STARTED.md)
- [Development Guide](DEVELOPMENT.md)
- [Architecture](ARCHITECTURE.md)

**Need Help?**
- Check [Troubleshooting](#troubleshooting) section
- Review [Conversation Log](CONVERSATION-LOG.md)
- Open GitHub issue

---

**Made with ❤️ using Laravel & Inertia.js**
