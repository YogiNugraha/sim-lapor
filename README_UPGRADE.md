# Upgrade to PHP 8 — SIM Lapor (Refactor Snapshot)

This snapshot modernizes the project to run on PHP 8 with safer defaults. Key changes:

## ✅ What was done

- **PHP 8 compatibility**
  - Added `declare(strict_types=1);` to PHP files.
  - Replaced fragile `if (valid != '1')` checks with a PHP 8–safe pattern: `if (!defined('valid') || valid !== '1')`.
  - Normalized redirects to `header('Location: …')` and added `exit;` after redirection.

- **Database bootstrap (`config/db.php`)**
  - Uses **mysqli** with exception mode (`MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT`).
  - Sets charset to **utf8mb4**.
  - Reads credentials from environment variables when available (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, `DB_PORT`, `DB_CHARSET`).
  - Exposes `$con` and a `db()` helper for backward compatibility.
  - Keeps old constants (`host`, `user`, `pass`, `dbase`) to avoid breakage.

- **Input helpers (`config/anti_inj.php`)**
  - No longer opens a new DB connection per call.
  - Sanitizes inputs predictably (trims, strips tags).
  - If a global `$con` exists, uses `$con->real_escape_string()` to preserve legacy behavior.
  - Adds `anti_xss()` and `no_xss()` with proper `htmlspecialchars` flags.

- **Login flow (`validation.php`)**
  - Uses **prepared statements** to look up the user.
  - Compares password using legacy `md5` hash (to match existing data) but wraps with `hash_equals`.
  - Validates CAPTCHA and starts an inactivity timer via `timeout.php`.
  - Sets the same session keys used across the app.

- **Config hardening (`config/system.php`, `config/config.php`)**
  - Avoids undefined-constant notices by guarding `valid`.
  - Falls back to session-based authentication for access control.

## 🧪 How to test locally

1. **Set environment variables** (optional):

   ```bash
   export DB_HOST=localhost
   export DB_USER=root
   export DB_PASS=yourpassword
   export DB_NAME=akreditasi
   export DB_PORT=3306
   ```

2. **Run under PHP 8+**:

   ```bash
   php -S 127.0.0.1:8000 -t .
   ```

3. Open `http://127.0.0.1:8000/login` and sign in.

## 🔐 Security recommendations (next steps)

- **Migrate passwords** from `md5` to modern hashing:

  1. Add a new column `password_new` (VARCHAR 255).
  2. On successful login with the legacy hash, rehash with `password_hash($plain, PASSWORD_DEFAULT)` and store into `password_new`.
  3. On next login, prefer `password_verify` against `password_new`, falling back to MD5 once for migration.
  4. After all users migrate, drop the old MD5 column.

- **Stop manual escaping** (`anti_inj`) and switch **all queries** to prepared statements.
- Centralize routing and access control (avoid using a magic `valid` constant).
- Consider PSR-12 code style and a lightweight front controller.

## 📁 Notes

This refactor is conservative and focuses on compatibility and safety. Some files in the original archive appeared truncated (containing literal `...` sequences); these lines were left untouched. If any feature misbehaves, check those files and replace the ellipses with the intended code.

— Generated on 2025-09-01 08:47 by an automated refactor script.
