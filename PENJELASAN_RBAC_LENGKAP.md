# 🔐 RBAC (Role-Based Access Control) untuk Website Jurnal Ilmiah
## Penjelasan Lengkap & Implementasi

**Project:** Website Jurnal Ilmiah EPTIK
**Framework:** Laravel 10.50.4
**Tanggal:** 03 November 2026

---

## 📚 APA ITU RBAC?

### Definisi:
**RBAC (Role-Based Access Control)** adalah sistem keamanan yang mengatur akses pengguna berdasarkan **ROLE (peran)** mereka dalam sistem, bukan berdasarkan identitas individual.

### Konsep Dasar:
```
USER → memiliki → ROLE → memiliki → PERMISSIONS → untuk akses → RESOURCES
```

**Contoh sederhana:**
```
John Doe (USER)
   ↓
   memiliki role: Admin
   ↓
   Admin role punya permissions:
   - Create article
   - Edit article
   - Delete article
   - Approve submission
   ↓
   Bisa akses resources:
   - /admin/articles
   - /admin/submissions
   - /admin/categories
```

---

## 🎭 3 ROLE DI WEBSITE JURNAL ANDA

### 1. **GUEST (Pengunjung)**
**Siapa:** Pengunjung yang belum login

**Permissions (Yang BOLEH):**
- ✅ Lihat homepage
- ✅ Lihat daftar artikel
- ✅ Lihat detail artikel
- ✅ Download PDF artikel
- ✅ Search artikel
- ✅ Lihat halaman About
- ✅ Akses halaman Login/Register

**Restrictions (Yang TIDAK BOLEH):**
- ❌ Submit artikel
- ❌ Comment artikel
- ❌ Bookmark artikel
- ❌ Akses dashboard
- ❌ Akses admin panel
- ❌ Akses user panel

**Routes:**
```php
// routes/web.php
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/about', [AboutController::class, 'index'])->name('about');
```

---

### 2. **USER (Penulis/Peneliti)**
**Siapa:** Registered user yang sudah login dengan `role = 'user'`

**Permissions (Yang BOLEH):**
- ✅ **Semua permissions GUEST** (inherit)
- ✅ Submit artikel baru
- ✅ Lihat artikel saya (My Submissions)
- ✅ Edit artikel saya (yang masih pending/rejected)
- ✅ Hapus artikel saya (yang masih pending)
- ✅ Lihat user dashboard
- ✅ Update profile saya
- ✅ Bookmark artikel (future)
- ✅ Comment artikel (future)

**Restrictions (Yang TIDAK BOLEH):**
- ❌ Akses admin panel
- ❌ Approve/reject artikel orang lain
- ❌ Edit artikel orang lain
- ❌ Hapus artikel yang sudah published
- ❌ Manage categories
- ❌ Manage users
- ❌ Lihat semua submissions

**Routes:**
```php
// routes/web.php - User Routes (Protected)
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::resource('submissions', UserSubmissionController::class);
});
```

**Authorization Check:**
```php
// app/Http/Middleware/UserMiddleware.php
public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'user') {
        return $next($request);
    }
    abort(403, 'Unauthorized access');
}
```

---

### 3. **ADMIN (Administrator)**
**Siapa:** User dengan `role = 'admin'`, pengelola jurnal

**Permissions (Yang BOLEH):**
- ✅ **Semua permissions USER** (inherit)
- ✅ Akses admin panel
- ✅ Manage semua artikel (Create, Read, Update, Delete)
- ✅ Approve/Reject submissions
- ✅ Manage categories (CRUD)
- ✅ Lihat semua users (future)
- ✅ Export reports (future)
- ✅ View statistics & analytics
- ✅ Manage system settings (future)
- ✅ Assign reviewers (future)

**Restrictions (Yang TIDAK BOLEH):**
- ❌ (Tidak ada, FULL ACCESS)
- ⚠️ Kecuali: Tidak boleh hapus data critical tanpa konfirmasi

**Routes:**
```php
// routes/web.php - Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('submissions', SubmissionController::class);
    Route::post('/submissions/{id}/approve', [SubmissionController::class, 'approve'])->name('submissions.approve');
    Route::post('/submissions/{id}/reject', [SubmissionController::class, 'reject'])->name('submissions.reject');
});
```

**Authorization Check:**
```php
// app/Http/Middleware/AdminMiddleware.php
public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }
    abort(403, 'Unauthorized access');
}
```

---

## 🗺️ ROLE HIERARCHY (Hirarki)

```
┌─────────────────────────────────────────┐
│  GUEST (Public)                         │
│  - View articles                        │
│  - Search                               │
│  - Download PDF                         │
└─────────────────────────────────────────┘
              ↓ (Register/Login)
┌─────────────────────────────────────────┐
│  USER (Authenticated)                   │
│  + All GUEST permissions                │
│  + Submit articles                      │
│  + User dashboard                       │
│  + Edit my submissions                  │
└─────────────────────────────────────────┘
              ↓ (Admin promote)
┌─────────────────────────────────────────┐
│  ADMIN (Full Access)                    │
│  + All USER permissions                 │
│  + Admin panel                          │
│  + Approve/Reject submissions           │
│  + Manage categories                    │
│  + System management                    │
└─────────────────────────────────────────┘
```

---

## 🔐 IMPLEMENTASI RBAC DI WEBSITE ANDA

### 1. **DATABASE: Role Storage**

**Tabel `users`:**
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user', -- ⭐ RBAC FIELD
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Field penting:**
- `role`: Menyimpan role user (admin/user)
- Default: `'user'` → Semua user baru adalah USER
- Admin: Manual set atau via seeder

---

### 2. **AUTHENTICATION: Laravel Breeze**

**Login Check:**
```php
// app/Http/Controllers/Auth/LoginController.php
public function login(Request $request)
{
    // Validate credentials
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt login
    if (Auth::attempt($credentials, $request->remember)) {
        $request->session()->regenerate();
        
        // ⭐ REDIRECT BASED ON ROLE
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Kredensial tidak valid.',
    ]);
}
```

---

### 3. **AUTHORIZATION: Middleware**

**Admin Middleware:**
```php
// app/Http/Middleware/AdminMiddleware.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ⭐ CHECK: User logged in AND role = admin
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
```

**User Middleware:**
```php
// app/Http/Middleware/UserMiddleware.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ⭐ CHECK: User logged in AND role = user
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (auth()->user()->role !== 'user') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
```

**Register Middleware:**
```php
// app/Http/Kernel.php
protected $middlewareAliases = [
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'user' => \App\Http\Middleware\UserMiddleware::class,
    // ... other middleware
];
```

---

### 4. **ROUTE PROTECTION**

**Routes dengan RBAC:**
```php
// routes/web.php

// ════════════════════════════════════════
// PUBLIC ROUTES (GUEST) - No Auth Required
// ════════════════════════════════════════
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// ════════════════════════════════════════
// AUTH ROUTES (Login, Register, etc)
// ════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ════════════════════════════════════════
// USER ROUTES (ROLE = 'user') ⭐
// ════════════════════════════════════════
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Submissions Management
    Route::get('/submissions', [UserSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/create', [UserSubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [UserSubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{id}/edit', [UserSubmissionController::class, 'edit'])->name('submissions.edit');
    Route::put('/submissions/{id}', [UserSubmissionController::class, 'update'])->name('submissions.update');
    Route::delete('/submissions/{id}', [UserSubmissionController::class, 'destroy'])->name('submissions.destroy');
});

// ════════════════════════════════════════
// ADMIN ROUTES (ROLE = 'admin') ⭐
// ════════════════════════════════════════
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Categories Management
    Route::resource('categories', CategoryController::class);
    
    // Articles Management
    Route::resource('articles', ArticleController::class);
    
    // Submissions Management (Admin Review)
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{id}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{id}/approve', [SubmissionController::class, 'approve'])->name('submissions.approve');
    Route::post('/submissions/{id}/reject', [SubmissionController::class, 'reject'])->name('submissions.reject');
});
```

---

### 5. **CONTROLLER AUTHORIZATION**

**Contoh: User hanya bisa edit submission miliknya sendiri**

```php
// app/Http/Controllers/User/UserSubmissionController.php

public function edit($id)
{
    $submission = ArticleSubmission::findOrFail($id);
    
    // ⭐ AUTHORIZATION: Check ownership
    if ($submission->user_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki akses untuk mengedit submission ini.');
    }
    
    // Check status (only pending/rejected can be edited)
    if ($submission->status === 'approved') {
        return redirect()->back()->with('error', 'Submission yang sudah disetujui tidak dapat diedit.');
    }
    
    return view('user.submissions.edit', compact('submission'));
}

public function update(Request $request, $id)
{
    $submission = ArticleSubmission::findOrFail($id);
    
    // ⭐ AUTHORIZATION: Check ownership
    if ($submission->user_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki akses untuk mengupdate submission ini.');
    }
    
    // Validation & update logic...
    
    return redirect()->route('user.submissions.index')
        ->with('success', 'Submission berhasil diupdate.');
}
```

---

### 6. **BLADE AUTHORIZATION (View Level)**

**Tampilkan UI berdasarkan role:**

```blade
{{-- resources/views/layouts/public.blade.php --}}

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home.index') }}">Jurnal Ilmiah</a>
        
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home.index') }}">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('articles.index') }}">Artikel</a>
            </li>
            
            @auth
                {{-- ⭐ Show different menu based on ROLE --}}
                @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard Admin
                        </a>
                    </li>
                @elseif(auth()->user()->role === 'user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">
                            <i class="bi bi-person-circle"></i> Dashboard Saya
                        </a>
                    </li>
                @endif
                
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link">Logout</button>
                    </form>
                </li>
            @else
                {{-- ⭐ Guest menu --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                </li>
            @endauth
        </ul>
    </div>
</nav>
```

**Conditional buttons:**
```blade
{{-- resources/views/user/submissions/index.blade.php --}}

@foreach($submissions as $submission)
    <tr>
        <td>{{ $submission->title }}</td>
        <td>{{ $submission->status }}</td>
        <td>
            {{-- ⭐ User can only edit/delete their OWN pending/rejected submissions --}}
            @if($submission->status !== 'approved')
                <a href="{{ route('user.submissions.edit', $submission->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                
                <form action="{{ route('user.submissions.destroy', $submission->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus submission ini?')">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            @else
                <span class="badge bg-success">Published</span>
            @endif
        </td>
    </tr>
@endforeach
```

---

## 🛡️ SECURITY BEST PRACTICES

### 1. **Defense in Depth (Berlapis)**

**Layer 1: Route Middleware**
```php
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes
});
```

**Layer 2: Controller Authorization**
```php
public function edit($id)
{
    $article = Article::findOrFail($id);
    
    // Check ownership
    if ($article->user_id !== auth()->id()) {
        abort(403);
    }
}
```

**Layer 3: Blade Directives**
```blade
@if(auth()->user()->role === 'admin')
    <button>Delete</button>
@endif
```

**Layer 4: Form Request Validation**
```php
// app/Http/Requests/StoreArticleRequest.php
public function authorize()
{
    return auth()->check() && auth()->user()->role === 'admin';
}
```

---

### 2. **Never Trust Client Side**

❌ **WRONG (Unsafe):**
```blade
{{-- Don't rely ONLY on hiding button --}}
@if(auth()->user()->role === 'admin')
    <form action="/admin/delete-all-users" method="POST">
        <button>Delete All</button>
    </form>
@endif
```
**Problem:** Attacker bisa POST langsung ke route tanpa button!

✅ **CORRECT (Safe):**
```php
// Controller ALWAYS checks permission
public function deleteAllUsers()
{
    // ⭐ Server-side check
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized');
    }
    
    // Delete logic...
}
```

---

### 3. **Rate Limiting untuk Sensitive Actions**

```php
// routes/web.php

Route::middleware(['auth', 'admin', 'throttle:10,1'])
    ->post('/admin/submissions/{id}/approve', [SubmissionController::class, 'approve'])
    ->name('admin.submissions.approve');

// Max 10 approvals per minute per admin
```

---

### 4. **Audit Log Critical Actions**

```php
// app/Http/Controllers/Admin/SubmissionController.php

public function approve($id)
{
    $submission = ArticleSubmission::findOrFail($id);
    
    // Authorization check
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }
    
    // Approve submission
    $submission->update(['status' => 'approved']);
    
    // ⭐ LOG CRITICAL ACTION
    Log::info('Submission approved', [
        'admin_id' => auth()->id(),
        'admin_email' => auth()->user()->email,
        'submission_id' => $submission->id,
        'submission_title' => $submission->title,
        'timestamp' => now(),
        'ip_address' => request()->ip(),
    ]);
    
    return redirect()->back()->with('success', 'Submission disetujui.');
}
```

---

### 5. **CSRF Protection** (Laravel default)

```blade
<form method="POST" action="{{ route('admin.submissions.approve', $submission->id) }}">
    @csrf {{-- ⭐ Always include CSRF token --}}
    <button type="submit">Approve</button>
</form>
```

Laravel otomatis check CSRF token. Jika tidak match → 419 error.

---

## 🔍 BAGIAN-BAGIAN YANG PERLU RBAC

### ✅ SUDAH DIPROTEKSI (Current Implementation):

1. **Admin Dashboard**
   - Route: `/admin/dashboard`
   - Middleware: `['auth', 'admin']`
   - ✅ Protected

2. **Admin Categories CRUD**
   - Routes: `/admin/categories/*`
   - Middleware: `['auth', 'admin']`
   - ✅ Protected

3. **Admin Articles CRUD**
   - Routes: `/admin/articles/*`
   - Middleware: `['auth', 'admin']`
   - ✅ Protected

4. **Admin Submissions Management**
   - Routes: `/admin/submissions/*`
   - Middleware: `['auth', 'admin']`
   - ✅ Protected

5. **User Dashboard**
   - Route: `/user/dashboard`
   - Middleware: `['auth', 'user']`
   - ✅ Protected

6. **User Submissions CRUD**
   - Routes: `/user/submissions/*`
   - Middleware: `['auth', 'user']`
   - ✅ Protected (+ ownership check)

---

### ⚠️ PERLU DITAMBAHKAN RBAC (Future):

1. **Profile Management**
   - Route: `/profile/edit`
   - Check: User hanya bisa edit profile sendiri
   - Code:
   ```php
   public function edit()
   {
       $user = auth()->user();
       return view('profile.edit', compact('user'));
   }
   
   public function update(Request $request)
   {
       // ⭐ User can only update their own profile
       $user = auth()->user();
       $user->update($request->validated());
   }
   ```

2. **Comment System** (jika implement Tahap 3)
   - User hanya bisa edit/delete comment sendiri
   - Admin bisa delete semua comment
   
3. **Bookmark System** (jika implement Tahap 3)
   - User hanya bisa manage bookmark sendiri

4. **Review System** (jika implement Tahap 2)
   - Reviewer hanya bisa review artikel yang di-assign
   - Admin bisa assign reviewer

5. **User Management** (Future admin feature)
   - Hanya admin yang bisa:
     - View all users
     - Ban/Unban users
     - Change user roles
     - Delete users

---

## 🔒 COMMON RBAC VULNERABILITIES & FIXES

### 1. **Insecure Direct Object Reference (IDOR)**

❌ **VULNERABLE:**
```php
// URL: /user/submissions/5/edit
public function edit($id)
{
    $submission = ArticleSubmission::findOrFail($id);
    return view('user.submissions.edit', compact('submission'));
}
```
**Problem:** User A bisa akses submission milik User B dengan ganti ID!

✅ **FIXED:**
```php
public function edit($id)
{
    $submission = ArticleSubmission::findOrFail($id);
    
    // ⭐ CHECK OWNERSHIP
    if ($submission->user_id !== auth()->id()) {
        abort(403, 'Unauthorized access');
    }
    
    return view('user.submissions.edit', compact('submission'));
}
```

---

### 2. **Missing Authorization in Delete**

❌ **VULNERABLE:**
```php
public function destroy($id)
{
    ArticleSubmission::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Deleted');
}
```
**Problem:** User bisa delete submission orang lain!

✅ **FIXED:**
```php
public function destroy($id)
{
    $submission = ArticleSubmission::findOrFail($id);
    
    // ⭐ CHECK OWNERSHIP
    if ($submission->user_id !== auth()->id()) {
        abort(403);
    }
    
    // ⭐ CHECK STATUS (can't delete approved)
    if ($submission->status === 'approved') {
        return redirect()->back()->with('error', 'Cannot delete approved submission');
    }
    
    $submission->delete();
    return redirect()->back()->with('success', 'Deleted');
}
```

---

### 3. **Role Escalation via Mass Assignment**

❌ **VULNERABLE:**
```php
// User registration
public function register(Request $request)
{
    User::create($request->all()); // ⚠️ DANGER!
}
```
**Problem:** Attacker bisa kirim `role=admin` di form!

✅ **FIXED:**
```php
public function register(Request $request)
{
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'user', // ⭐ HARD-CODED, never from request
    ]);
}

// OR use $fillable in model
// app/Models/User.php
protected $fillable = ['name', 'email', 'password'];
protected $guarded = ['role', 'email_verified_at']; // ⭐ Protect role field
```

---

### 4. **Missing Middleware on API Routes**

❌ **VULNERABLE:**
```php
// routes/api.php
Route::post('/articles', [ArticleController::class, 'store']);
// No auth check!
```

✅ **FIXED:**
```php
Route::middleware(['auth:sanctum', 'admin'])
    ->post('/articles', [ArticleController::class, 'store']);
```

---

## 📋 RBAC SECURITY CHECKLIST

### Pre-Deployment Check:

- [ ] **Middleware registered di Kernel.php**
- [ ] **Semua admin routes pakai `middleware(['auth', 'admin'])`**
- [ ] **Semua user routes pakai `middleware(['auth', 'user'])`**
- [ ] **Controller punya ownership check (user edit sendiri)**
- [ ] **Form Request punya `authorize()` method**
- [ ] **Model punya `$guarded = ['role']` untuk protect role field**
- [ ] **Blade hide/show UI based on role (`@if(auth()->user()->role)`)**
- [ ] **CSRF protection aktif (`@csrf` di semua form)**
- [ ] **Rate limiting di sensitive routes**
- [ ] **Audit log untuk critical actions**
- [ ] **403 error page custom (sudah ada)**
- [ ] **Test: User tidak bisa akses admin routes**
- [ ] **Test: User tidak bisa edit submission orang lain**
- [ ] **Test: Guest redirect ke login jika akses protected route**

---

## 🧪 TESTING RBAC

### Manual Testing Steps:

**1. Test GUEST access:**
```
✅ Visit /
✅ Visit /articles
✅ Visit /articles/{slug}
✅ Visit /about
❌ Visit /admin/dashboard → Should redirect to login
❌ Visit /user/dashboard → Should redirect to login
```

**2. Test USER access:**
```
Login as: user@jurnal.com / password123

✅ Visit /user/dashboard
✅ Visit /user/submissions
✅ Create new submission
✅ Edit OWN submission (pending/rejected)
❌ Visit /admin/dashboard → Should show 403 error
❌ Edit OTHER user's submission → Should show 403
❌ Delete approved submission → Should show error
```

**3. Test ADMIN access:**
```
Login as: admin@jurnal.com / password123

✅ Visit /admin/dashboard
✅ Visit /admin/categories
✅ Visit /admin/articles
✅ Visit /admin/submissions
✅ Approve submission
✅ Reject submission
✅ Create/Edit/Delete any article
✅ Create/Edit/Delete category
```

---

## 📊 RBAC MATRIX (Permission Table)

| Feature / Resource | Guest | User | Admin |
|-------------------|-------|------|-------|
| **Public Pages** |
| View Homepage | ✅ | ✅ | ✅ |
| View Articles List | ✅ | ✅ | ✅ |
| View Article Detail | ✅ | ✅ | ✅ |
| Download PDF | ✅ | ✅ | ✅ |
| Search Articles | ✅ | ✅ | ✅ |
| View About Page | ✅ | ✅ | ✅ |
| **Authentication** |
| Login | ✅ | - | - |
| Register | ✅ | - | - |
| Logout | - | ✅ | ✅ |
| **User Dashboard** |
| Access User Dashboard | ❌ | ✅ | ✅ |
| Submit New Article | ❌ | ✅ | ✅ |
| View My Submissions | ❌ | ✅ | ✅ |
| Edit My Submission (pending) | ❌ | ✅ | ✅ |
| Delete My Submission (pending) | ❌ | ✅ | ✅ |
| Edit Other's Submission | ❌ | ❌ | ✅ |
| **Admin Panel** |
| Access Admin Dashboard | ❌ | ❌ | ✅ |
| Manage Categories | ❌ | ❌ | ✅ |
| Create Article (Direct) | ❌ | ❌ | ✅ |
| Edit Any Article | ❌ | ❌ | ✅ |
| Delete Any Article | ❌ | ❌ | ✅ |
| View All Submissions | ❌ | ❌ | ✅ |
| Approve Submission | ❌ | ❌ | ✅ |
| Reject Submission | ❌ | ❌ | ✅ |
| Export Reports | ❌ | ❌ | ✅ |
| View Statistics | ❌ | ❌ | ✅ |

**Legend:**
- ✅ = Allowed
- ❌ = Denied
- - = Not Applicable

---

## 💡 ADVANCED RBAC (Future Upgrade)

### 1. **Permission-Based (Instead of Role-Based)**

**Current:** Simple RBAC (3 roles: guest, user, admin)

**Upgrade:** ACL (Access Control List) - Granular permissions

```php
// Database
CREATE TABLE permissions (
    id BIGINT PRIMARY KEY,
    name VARCHAR(50), -- 'create-article', 'delete-article'
    description TEXT
);

CREATE TABLE role_permissions (
    role_id BIGINT,
    permission_id BIGINT
);

// Usage
if (auth()->user()->hasPermission('delete-article')) {
    // Allow delete
}
```

**Package:** Spatie Laravel Permission
```bash
composer require spatie/laravel-permission
```

---

### 2. **Dynamic Roles (User-defined)**

Admin bisa create custom roles:
- Editor: Can edit articles, cannot delete
- Moderator: Can approve submissions, cannot create categories
- Reviewer: Can review articles, cannot publish

---

### 3. **Resource-Level Permissions**

```php
// User can only edit articles in category "Computer Science"
if (auth()->user()->canEditCategory($article->category_id)) {
    // Allow
}
```

---

## 🎯 KESIMPULAN

### RBAC di Website Jurnal Anda:

**✅ SUDAH BAGUS:**
1. Ada 3 role: Guest, User, Admin
2. Middleware protection di semua protected routes
3. Authorization check di controller (ownership)
4. Blade directives untuk UI conditional
5. CSRF protection aktif
6. Custom 403 error page

**⚠️ PERLU IMPROVEMENT:**
1. Ownership check di beberapa controller (pastikan semua)
2. Rate limiting di semua sensitive actions
3. Audit log untuk critical operations
4. Unit tests untuk RBAC
5. Documentation RBAC di README

**🚀 UPGRADE FUTURE:**
1. Add role "Reviewer" (Tahap 2)
2. Permission-based access (Spatie Permission)
3. Activity log (Spatie Activity Log)
4. Dynamic roles (Admin create roles)

---

## 📁 FILE YANG TERKAIT RBAC

```
app/Http/Middleware/
├── AdminMiddleware.php          ⭐ Check admin role
├── UserMiddleware.php           ⭐ Check user role
└── Authenticate.php             ⭐ Check if logged in

app/Http/Controllers/
├── Auth/
│   ├── LoginController.php      ⭐ Login + redirect by role
│   └── RegisterController.php   ⭐ Register new user (role='user')
├── Admin/
│   ├── DashboardController.php  ⭐ Admin only
│   ├── CategoryController.php   ⭐ Admin only
│   ├── ArticleController.php    ⭐ Admin only
│   └── SubmissionController.php ⭐ Admin only (approve/reject)
└── User/
    ├── DashboardController.php  ⭐ User only
    └── SubmissionController.php ⭐ User only + ownership check

app/Http/Requests/
├── StoreArticleRequest.php      ⭐ authorize() method
└── StoreSubmissionRequest.php   ⭐ authorize() method

routes/web.php                   ⭐ Route protection with middleware

database/migrations/
└── create_users_table.php       ⭐ role ENUM field

database/seeders/
└── UserSeeder.php               ⭐ Create admin user

resources/views/layouts/
├── admin.blade.php              ⭐ Admin-only layout
├── user.blade.php               ⭐ User-only layout
└── public.blade.php             ⭐ Public layout (role-based navbar)

app/Models/User.php              ⭐ $guarded = ['role']
```

---

**STATUS:** ✅ RBAC EXPLAINED COMPLETELY!

Sudah jelas tentang RBAC di website Anda? Ada yang mau ditanyakan atau perlu contoh implementasi spesifik? 🔐
