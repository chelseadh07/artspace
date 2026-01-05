# 🔧 FIX UNTUK PRODUCTION - IMAGES NOT SHOWING

## DIAGNOSA MASALAH

Gambar di production (https://artspace-production.up.railway.app/artworks) tidak muncul.

**Kemungkinan penyebab:**
1. ❌ Symlink `public/storage` tidak ada di production
2. ❌ Storage directory kosong (files tidak ter-upload)
3. ❌ Path stored di database tidak match dengan file location
4. ❌ Permissions issue di production server

---

## SOLUSI - STEP BY STEP

### STEP 1: SSH ke Production Server (Railway)

```bash
# Login ke Railway dashboard
https://railway.app

# Find your project
# Go to "Settings" → "Environment" → View variables
# Look for DATABASE_URL dan app variables

# Untuk direct access (jika Railway support SSH):
# Biasanya tidak bisa direct SSH di Railway
# Tapi bisa run commands via deployment
```

### STEP 2: Check File Storage on Production

**Option A: Via Laravel Tinker (Recommended)**

Jika bisa akses production artisan:

```bash
# SSH/Connect ke production container
# (Check Railway documentation)

# Atau via Procfile/Deployment commands

# Run tinker
php artisan tinker

# Check artworks
>>> $artwork = App\Models\Artwork::first();
>>> $artwork->image_url;  // Output: "artworks/uuid-hash.jpg" atau "/storage/artworks/..."

# Check if file exists
>>> Storage::disk('public')->exists($artwork->image_url);
>>> // true = file ada, false = file hilang
```

### STEP 3: Create/Verify Symlink on Production

**Di dalam production deployment (via deployment script atau .railwayrc):**

```bash
# Run this after deployment
php artisan storage:link

# This creates: public/storage → storage/app/public
```

### STEP 4: Verify File Paths

**Check what's stored in database:**

```php
// Via tinker
>>> Artwork::all()->pluck('image_url');
// Output: Collection {"artworks/uuid1.jpg", "artworks/uuid2.jpg", ...}
```

**If output shows:**
- ✅ `artworks/uuid.jpg` → Good, just need symlink
- ❌ `/storage/artworks/uuid.jpg` → Path stored wrong, need to fix
- ❌ Full URL → Path stored wrong, need to fix

---

## QUICK FIX - UPDATE database.php

**Kemungkinan isu: Artworks stored dengan path yang salah**

Mari kita update agar **selalu store path saja (relatif ke storage/app/public)**

### Artwork Controller:

Sudah diperbaiki:
```php
$path = $r->file('image')->store('artworks', 'public');
$artwork->image_url = $path;  // Store path, not full URL
```

### Views:

Sudah diperbaiki:
```php
<img src="{{ asset('storage/' . $artwork->image_url) }}">
```

---

## DEPLOYMENT CHECKLIST

Pastikan di production:

```bash
☐ Run migrations: php artisan migrate
☐ Create symlink: php artisan storage:link
☐ Check permissions: chmod 755 storage/
☐ Check storage dir exists: storage/app/public/
☐ Check web server can read files
☐ Clear cache: php artisan config:clear
☐ Test image upload → check storage/app/public/artworks/
```

---

## RAILWAY-SPECIFIC FIX

Jika pakai Railway:

### Via Procfile:

```
release: php artisan migrate --force && php artisan storage:link
web: vendor/bin/heroku-php-apache2 public/
```

### Via nixpacks.toml:

```toml
[phases.setup]
cmds = ["php artisan storage:link"]

[phases.build]
cmds = ["php artisan migrate --force"]
```

### Via GitHub Actions (if deploying via webhook):

Create `.github/workflows/deploy.yml`:

```yaml
name: Deploy to Production
on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Deploy to Railway
        run: |
          # Railway CLI commands
          railway run php artisan migrate --force
          railway run php artisan storage:link
```

---

## DATABASE CLEANUP (if needed)

**Jika ada artwork di database dengan path yang salah:**

```php
// Via tinker
>>> Artwork::whereNotNull('image_url')->get()->each(function($art) {
    // Check if path starts with /storage/ or http
    if (str_starts_with($art->image_url, '/storage/')) {
        // Remove /storage/ prefix
        $art->image_url = str_replace('/storage/', '', $art->image_url);
        $art->save();
    } elseif (str_starts_with($art->image_url, 'http')) {
        // Remove domain part
        $art->image_url = str_replace(config('app.url') . '/storage/', '', $art->image_url);
        $art->save();
    }
});
```

---

## VERIFICATION

Setelah fix, test:

```
1. Go to https://artspace-production.up.railway.app/artworks
2. Scroll through artworks
3. Images harus visible
4. Click artwork detail → image harus jelas

5. Test upload artwork baru:
   - Login as artist
   - Upload artwork with image
   - Check database image_url (should be: artworks/uuid.jpg)
   - Check if file exists in storage/app/public/artworks/
   - Verify image displays
```

---

## JIKA MASIH TIDAK JALAN

**Kemungkinan lain:**

1. **Web server config issue**
   - nginx/apache tidak serve /storage/ correctly
   - Need to configure web server rules

2. **Symlink tidak support di hosting**
   - Some hosting (shared hosting) tidak support symlink
   - Alternative: Copy files to public/images/ directly

3. **Storage directory mounting issue**
   - Container restart → storage files lost
   - Need persistent volume mounting di Docker

4. **File permissions**
   ```bash
   chmod -R 755 storage/app/public
   chmod -R 755 public/storage
   ```

---

## ALTERNATIVE FIX - If Symlink Doesn't Work

**Store files di public/ directly:**

```php
// ArtworkController.php
public function store(Request $r) {
    $path = $r->file('image')->store('artworks', 'public');
    
    // Instead of storing path, store full URL
    $url = asset('storage/' . $path);
    
    Artwork::create([
        'image_url' => $url,  // Full URL, not path
    ]);
}
```

**Then in view:**
```php
<img src="{{ $artwork->image_url }}">  // Use directly
```

**But this is less flexible. Better to fix symlink.**

---

## NEXT STEPS

1. ✅ Code changes sudah di-commit
2. 🔄 Wait for Railway auto-deployment
3. 🧪 Test images on production
4. 🐛 If still not working, check:
   - Railway build logs
   - Storage directory contents
   - Web server error logs

---

## CONTACT RAILWAY SUPPORT

Jika masih stuck:

- Check Railway logs: `railway logs`
- Check if persistent storage is configured
- Contact Railway support team

---

**Last Updated:** January 5, 2026

