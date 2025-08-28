# MD Dashboard 2

Dashboard aplikasi dengan template Tabler yang lengkap dengan sistem autorisasi menu menggunakan Laravel dan Spatie Laravel Permission.

## Features

- 🎨 **Template Tabler** - Modern dan responsive dashboard template
- 🔐 **Authentication System** - Login/logout dengan username
- 👥 **Role & Permission Management** - Menggunakan Spatie Laravel Permission
- 🧭 **Authorized Menu System** - Menu yang muncul berdasarkan permission user
- 📱 **Responsive Design** - Mobile friendly
- 🌙 **Dark/Light Theme** - Toggle theme support

## Roles & Permissions

### Default Roles:
1. **Administrator** - Full access to all features
2. **Foreman** - Production management access
3. **Supervisor** - Limited production access
4. **Quality** - Quality control specific access

### Default Users:
- Username: `admin` / Password: `admin123` (Administrator)
- Username: `foreman` / Password: `foreman123` (Foreman)
- Username: `supervisor` / Password: `supervisor123` (Supervisor)
- Username: `quality` / Password: `quality123` (Quality)

## Installation

1. Clone repository dan install dependencies:
```bash
composer install
npm install
```

2. Copy environment file:
```bash
cp .env.example .env
```

3. Generate application key:
```bash
php artisan key:generate
```

4. Configure database di file `.env`

5. Run migrations dan seeders:
```bash
php artisan migrate:fresh --seed
```

6. Build assets:
```bash
npm run build
# atau untuk development:
npm run dev
```

7. Start development server:
```bash
php artisan serve
```

## Menu System

Menu sistem secara otomatis menampilkan menu berdasarkan permission yang dimiliki user. Menu dikonfigurasi di `App\Service\MenuService`.

### Menu Structure:
- **Dashboard** - Home dashboard
- **User Management** - Users, Roles, Permissions management
- **Production** - Shifts, Devices, Products, Records management  
- **Reports** - Activities, Verifications reports

### Adding New Menu:

Edit file `app/Service/MenuService.php` dan tambahkan menu baru:

```php
[
    'title' => 'New Menu',
    'icon' => 'icon-name', // Tabler icon name
    'route' => 'route.name',
    'permissions' => ['permission-name'],
    'children' => [] // untuk sub menu
]
```

### Creating New Permissions:

```bash
php artisan tinker
```

```php
use Spatie\Permission\Models\Permission;

Permission::create(['name' => 'new-permission']);
```

## File Structure

```
app/
├── Http/Controllers/
│   ├── Auth/AuthController.php      # Authentication controller
│   └── DashboardController.php     # Dashboard controller
├── Service/
│   └── MenuService.php              # Menu authorization service
└── Models/User.php                  # User model dengan HasRoles trait

resources/views/
├── layouts/
│   ├── app.blade.php               # Main dashboard layout
│   └── auth.blade.php              # Authentication layout
├── dashboard/
│   ├── index.blade.php             # Dashboard page
│   └── profile.blade.php           # User profile page
├── auth/
│   └── login.blade.php             # Login page
└── partials/
    ├── menu.blade.php              # Menu dengan authorization
    └── footer.blade.php            # Footer partial
```

## Customization

### Theme Customization:
Edit file `resources/css/app.css` untuk custom styles.

### Menu Icons:
Menggunakan [Tabler Icons](https://tabler.io/icons). Gunakan nama icon tanpa prefix `ti ti-`.

### Dashboard Widgets:
Edit file `resources/views/dashboard/index.blade.php` untuk mengubah widgets dashboard.

## Security

- Password di-hash menggunakan bcrypt
- CSRF protection enabled
- Permission-based menu visibility
- Route protection dengan middleware permission

## License

MIT License
