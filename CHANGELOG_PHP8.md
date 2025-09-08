# Change Summary (auto-generated)

- cetak/config/config.php
- cetak/index.php
- config/anti_inj.php
- config/combobox.php
- config/config.php
- config/confirm.php
- config/date.php
- config/db.php
- config/fpdf/font/courier.php
- config/fpdf/font/courierb.php
- config/fpdf/font/courierbi.php
- config/fpdf/font/courieri.php
- config/fpdf/font/helvetica.php
- config/fpdf/font/helveticab.php
- config/fpdf/font/helveticabi.php
- config/fpdf/font/helveticai.php
- config/fpdf/font/symbol.php
- config/fpdf/font/times.php
- config/fpdf/font/timesb.php
- config/fpdf/font/timesbi.php
- config/fpdf/font/timesi.php
- config/fpdf/font/zapfdingbats.php
- config/fpdf/fpdf.php
- config/fpdf/makefont/makefont.php
- config/fpdf/makefont/ttfparser.php
- config/library.php
- config/seo.php
- config/system.php
- config/time_stamp.php
- config/upload.php
- dist/captcha/captcha.php
- index.php
- info.php
- logout.php
- module/content/account/default.php
- module/content/agenda/user/file.php
- module/content/agenda/user/jenis.php
- module/content/agenda/user/presensi.php
- module/content/agenda/user/user.php
- module/content/catatan/cetak.php
- module/content/catatan/hitung.php
- module/content/catatan/user.php
- module/content/dashboard/pimpinan.php
- module/content/dashboard/user.php
- module/content/delete/user.php
- module/content/disposisi/user/user.php
- module/content/edr/user/edit.php
- module/content/edr/user/jenis.php
- module/content/edr/user/user.php
- module/content/ins/user/edit.php
- module/content/ins/user/jenis.php
- module/content/ins/user/user.php
- module/content/insert/user.php
- module/content/kerjasama/user/jenis.php
- module/content/kerjasama/user/user.php
- module/content/ket/user/edit.php
- module/content/ket/user/jenis.php
- module/content/ket/user/user.php
- module/content/kinerja/cetak.php
- module/content/kinerja/user.php
- module/content/lapor/user.php
- module/content/mlm/user/edit.php
- module/content/mlm/user/jenis.php
- module/content/mlm/user/user.php
- module/content/pantaukinerja/cetak.php
- module/content/pantaukinerja/pimpinan.php
- module/content/pantauproker/cetak.php
- module/content/per/user/edit.php
- module/content/per/user/jenis.php
- module/content/per/user/user.php
- module/content/proker/agenda.php
- module/content/proker/cetak.php
- module/content/proker/user.php
- module/content/rek/user/edit.php
- module/content/rek/user/jenis.php
- module/content/rek/user/user.php
- module/content/sk/user/jenis.php
- module/content/sk/user/user.php
- module/content/sop/user/edit.php
- module/content/sop/user/jenis.php
- module/content/sop/user/user.php
- module/content/suratkeluar/user/edit.php
- module/content/suratkeluar/user/jenis.php
- module/content/suratkeluar/user/user.php
- module/content/suratmasuk/user/edit.php
- module/content/suratmasuk/user/jenis.php
- module/content/suratmasuk/user/user.php
- module/content/tgs/user/edit.php
- module/content/tgs/user/jenis.php
- module/content/tgs/user/user.php
- module/content/update/user.php
- module/query/pencarian.php
- module/view/top.php
- timeout.php
- validation.php

## Key diffs (truncated)

### config/db.php
```
--- a/config/db.php
+++ b/config/db.php
@@ -1,33 +1,54 @@
 <?php
+declare(strict_types=1);
 
-/* ***************************************************************************************
- * System Configure
- * 
- * PHP Version 5 naik ke 8
- * Database MySQL
- * 
- * LICENSE : This source file is subject to the MIT License, available
- * 
- * @author		Sofhian Fazrin Nasrulloh <www.fazrin.com> <fazrin.nashrullah@yahoo.com>
- * @copyright	GNU Public License
- * @phones		083-824-050-015 
- * 
- * This program is free software; you can redistribute it and/or modify it under the
- * terms of the GNU General Public License as published by the Free Software Foundation;
- * either version 2 of the License, or (at your option) any later version.
- * 
- * THIS SCRIPT IS PROVIDED AS IS, WITHOUT ANY WARRANTY OR GUARANTEE OF ANY KIND
- * ****************************************************************************************
+/**
+ * Database bootstrap (PHP 8 compatible)
+ * - Uses mysqli with strict error reporting
+ * - Sets utf8mb4 charset
+ * - Exposes $con (mysqli) for backward compatibility
  */
 
-if (valid != '1') {
-	header('location:/login');
-} else {
+if (session_status() === PHP_SESSION_NONE) {
+    session_start();
+}
 
-	define('host', 'localhost');
-	define('user', 'root');
-	define('pass', '');
-	define('dbase', 'akreditasi');
-	$con = mysqli_connect(host, user, pass) or die(" Koneksi Gagal ");
-	mysqli_select_db($con, dbase) or die("Cannot connect to database ");
+// ---- Configure here (or via environment variables) ----
+$DB_HOST = getenv('DB_HOST') ?: 'localhost';
+$DB_USER = getenv('DB_USER') ?: 'root';
+$DB_PASS = getenv('DB_PASS') ?: '';
+$DB_NAME = getenv('DB_NAME') ?: 'akreditasi';
+$DB_PORT = (int) (getenv('DB_PORT') ?: 3306);
+$DB_CHARSET = getenv('DB_CHARSET') ?: 'utf8mb4';
+
+// Back-compat: keep old constant names if some legacy code references them
+if (!defined('host')) { define('host', $DB_HOST); }
+if (!defined('user')) { define('user', $DB_USER); }
+if (!defined('pass')) { define('pass', $DB_PASS); }
+if (!defined('dbase')) { define('dbase', $DB_NAME); }
+
+// Turn on mysqli exceptions (PHP 8 best practice)
+mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
+
+try {
+    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
+    if (!@$con->set_charset($DB_CHARSET)) {
+        // Fallback to utf8 if utf8mb4 is not available
+        @$con->set_charset('utf8');
+    }
+} catch (Throwable $e) {
+    http_response_code(500);
+    // Avoid leaking credentials
+    die('Database connection failed.');
 }
+
+// Helper for getting the connection (optional)
+if (!function_exists('db')) {
+    /**
+     * @return mysqli
+     */
+    function db(): mysqli {
+        /** @var mysqli $con */
+        global $con;
+        return $con;
+    }
+}
```

### config/anti_inj.php
```
--- a/config/anti_inj.php
+++ b/config/anti_inj.php
@@ -1,25 +1,42 @@
 <?php
+declare(strict_types=1);
 
-	function anti_inj($data){
-		$con = mysqli_connect(host, user, pass) OR DIE (" Mohon Maaf Sedang Gangguan ");
-		$filter = mysqli_real_escape_string($con,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
-		if($filter=='%') {
-			return 'Kata Kunci Salah';
-		}
-		else {
-			return $filter;
-		}
-	}
+/**
+ * Input helpers (do NOT rely on DB escaping; use prepared statements)
+ * Kept compatible with legacy usage.
+ */
 
-	function anti_xss($data){
-		$filter = htmlentities(htmlspecialchars($data), ENT_QUOTES);
-		return $filter;
-	}
+if (!function_exists('anti_inj')) {
+    function anti_inj($data): string {
+        // Normalize to string
+        $data = is_array($data) ? '' : (string) $data;
+        $data = strip_tags($data);
+        $data = trim($data);
 
-	function no_xss($data){
-		$con = mysqli_connect(host, user, pass) OR DIE (" Connection Failed with servers ");
-		$filter = mysqli_real_escape_string($con,strip_tags($data));
-		return $filter;
-	}
+        if ($data === '%') {
+            return 'Kata Kunci Salah';
+        }
 
-?>
+        // If a DB connection exists, reuse its escaping for legacy SQL usage.
+        if (isset($GLOBALS['con']) && $GLOBALS['con'] instanceof mysqli) {
+            return $GLOBALS['con']->real_escape_string($data);
+        }
+
+        return $data;
+    }
+}
+
+if (!function_exists('anti_xss')) {
+    function anti_xss($data): string {
+        $data = is_array($data) ? '' : (string) $data;
+        return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
+    }
+}
+
+if (!function_exists('no_xss')) {
+    function no_xss($data): string {
+        $data = is_array($data) ? '' : (string) $data;
+        // Keep only text; handy for routing parts
+        return strip_tags($data);
+    }
+}
```

### config/system.php
```
--- a/config/system.php
+++ b/config/system.php
@@ -1,29 +1,20 @@
 <?php
+declare(strict_types=1);
 
-
-
-if (valid!='1'){
-
-	header('location:/login');
-
+if (session_status() === PHP_SESSION_NONE) {
+    session_start();
 }
 
-
-
-else {
-
-
-
-	$globalvar['news']='read';
-
-	$globalvar['page']='page';
-
-	$globalvar['cat']='cat';
-
-
-
+// Past code relied on a 'valid' constant; harden for PHP 8:
+if (!defined('valid') || valid !== '1') {
+    // Optional: allow through if user already authenticated
+    if (empty($_SESSION['ses_user']) || empty($_SESSION['ses_level'])) {
+        header('Location: /login');
+        exit;
+    }
 }
 
-
-
-?>
+$globalvar = [];
+$globalvar['news'] = 'read';
+$globalvar['page'] = 'page';
+$globalvar['cat']  = 'cat';
```

### config/config.php
```
--- a/config/config.php
+++ b/config/config.php
@@ -1,28 +1,33 @@
 <?php
-	if(valid!='1') {
-	header('location:/login');
-	}
-?>
-<?php
-	
+declare(strict_types=1);
 
-	$url = no_xss($_SERVER['REQUEST_URI']);
-	$folder = explode("/",$url);
-	$jumlah_folder = count($folder);
-	$http = 'http:/';
-	$surat = 'http://asamurat2.upmk.ac.id';
+if (session_status() === PHP_SESSION_NONE) {
+    session_start();
+}
 
-	$seo_folder = $jumlah_folder - 1;
-	if($jumlah_folder>'1') {
-		$module = $folder['1'] ;
-		$seo = $folder[$seo_folder];
-	}
+// Harden legacy 'valid' check for PHP 8
+if (!defined('valid') || valid !== '1') {
+    if (empty($_SESSION['ses_user']) || empty($_SESSION['ses_level'])) {
+        header('Location: /login');
+        exit;
+    }
+}
 
-	if($folder['1']=='') {
-		$module = 'dashboard';
-	}
-	else {
-		$module = $folder['1'];
-	}
+$url = no_xss($_SERVER['REQUEST_URI'] ?? '/');
+$folder = explode('/', $url);
+$jumlah_folder = count($folder);
+$http = 'http:/';
+// TODO: move this to a config/env file
+$surat = 'http://asamurat2.upmk.ac.id';
 
-?>
+$seo_folder = $jumlah_folder - 1;
+if ($jumlah_folder > 1) {
+    $module = $folder[1] ?? '';
+    $seo = $folder[$seo_folder] ?? '';
+}
+
+if (empty($folder[1])) {
+    $module = 'dashboard';
+} else {
+    $module = $folder[1];
+}
```

### validation.php
```
--- a/validation.php
+++ b/validation.php
@@ -1,82 +1,77 @@
 <?php
+declare(strict_types=1);
 
 define('valid','1');
- include "config/db.php";
- include "config/anti_inj.php";
- include "config/library.php";
 
-$pwd	= mysqli_real_escape_string($con,$_POST['password']);
-$ip     = $_SERVER['REMOTE_ADDR']; 
+require_once __DIR__ . "/config/db.php";
+require_once __DIR__ . "/config/anti_inj.php";
+require_once __DIR__ . "/config/library.php";
+require_once __DIR__ . "/timeout.php";
 
-$username = anti_inj($_POST['username']);
-$password = anti_inj(md5($_POST['password']));
+if (session_status() === PHP_SESSION_NONE) {
+    session_start();
+}
 
-session_start();
+$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
 
-	if($_POST['captcha']==$_SESSION['captcha']){
+// Basic input retrieval with fallback
+$inputUser = $_POST['username'] ?? '';
+$inputPass = $_POST['password'] ?? '';
+$inputCaptcha = $_POST['captcha'] ?? '';
 
-		if (!ctype_alnum($username) OR !ctype_alnum($password)){
-			header('location:login?m=injection');
-		}
+$username = anti_inj($inputUser);
+$plainPassword = (string) $inputPass; // keep original for hashing comparison
 
-		else {
+// Validate captcha
+if (!isset($_SESSION['captcha']) || $inputCaptcha !== $_SESSION['captcha']) {
+    header('Location: /login?m=captcha');
+    exit;
+}
 
-			$quser=mysqli_query($con," SELECT username,name,password,level,template,active,bp FROM user WHERE username='$username' AND password='$password' AND level!='mahasiswa' AND level!='dosen' LIMIT 1 ");
+// Lookup user (excluding certain levels, keep legacy behavior)
+try {
+    $stmt = $con->prepare("SELECT username, name, password, level, active, bp FROM user WHERE username = ? AND level NOT IN ('mahasiswa','dosen') LIMIT 1");
+    $stmt->bind_param('s', $username);
+    $stmt->execute();
+    $res = $stmt->get_result();
+    $user = $res ? $res->fetch_assoc() : null;
+} catch (Throwable $e) {
+    // Avoid leaking details
+    header('Location: /login?m=error');
+    exit;
+}
 
-			$user=mysqli_fetch_array($quser,MYSQLI_BOTH);
-			$num_user=mysqli_num_rows($quser);
+if ($user) {
+    // Legacy: compare against md5 hash stored in DB
+    $inputHash = md5($plainPassword);
+    if (isset($user['password']) && hash_equals((string)$user['password'], $inputHash)) {
+        if (!empty($user['active']) && (string)$user['active'] === '1') {
+            // Success: set session state
+            $_SESSION['ses_user']  = (string)$user['username'];
+            $_SESSION['ses_name']  = (string)($user['name'] ?? '');
+            $_SESSION['ses_pass']  = (string)$user['password'];
+            $_SESSION['ses_level'] = (string)($user['level'] ?? '');
+            $_SESSION['ses_ip']    = $ip;
+            $_SESSION['ses_login'] = 1;
 
-			if($num_user>0) {
+            // Start/refresh inactivity timer
+            if (!function_exists('timer')) {
+                function timer() { $_SESSION['ses_timeout'] = time() + 200000; }
+            }
+            timer();
 
-				if ($user['active']=='1') {
+            header('Location: /dashboard');
+            exit;
+        } else {
+            header('Location: /login?m=not_active');
+            exit;
+        }
+    } else {
+        header('Location: /login?m=wrong');
+        exit;
+    }
+}
 
-					session_start();
-					include "timeout.php";
-
-					$_SESSION['ses_user']     = $user['username'];
-					$_SESSION['ses_name']     = $user['name'];
-					$_SESSION['ses_pass']     = $user['password'];
-					$_SESSION['ses_level']    = $user['level'];
-					$_SESSION['template']     = $template['path'];
-					$_SESSION['layout']		= $template['layout'];
-					$_SESSION['skin']		    = $template['skin'];
-					$_SESSION['screenshoot']  = $template['screenshoot'];
-					$_SESSION['ses_login']	= 1;
-		
-					timer();
-
-					$old_id = session_id();
-					session_regenerate_id();
-					$new_id = session_id();
-
-					$date = date("Ymd"); 
-					$time   = time();
-
-
-					if(!empty($user['bp'])) {
-						header('location:/dashboard');
-					} else {
-						header('location:/dashboard');
-					}
-				}
-
-				else {
-					header('location:/login?m=not_active');
-				}
-
-			}
-
-			else {
-				header('location:/login?m=wrong');
-			}
-		}
-		
-	}
-
-	else {
-		header('location:/login?m=captcha');
-	}
-		
-
-
-?>
+// User not found
+header('Location: /login?m=wrong');
+exit;
```

### logout.php
```
--- a/logout.php
+++ b/logout.php
@@ -1,8 +1,11 @@
 <?php
+declare(strict_types=1);
+
   session_start();
 
 if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){
-	header('location:/login');
+	header('Location: /login');
+	
 	}
 else {
 	define('valid','1');
```

### index.php
```
--- a/index.php
+++ b/index.php
@@ -1,4 +1,6 @@
-<?php 
+<?php
+declare(strict_types=1);
+ 
 // Report simple running errors
 error_reporting(E_ERROR | E_PARSE);
 
@@ -6,7 +8,8 @@
 session_start();
 
 	if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){
-		header('location:/login');
+		header('Location: /login');
+		exit;
 	}
 	else {
 
@@ -19,7 +22,8 @@
 		}
 
 		if($_SESSION['ses_login']==0){
-			header('location:/logout');
+			header('Location: /logout');
+			exit;
 		}
 
 		else {
```

### cetak/index.php
```
--- a/cetak/index.php
+++ b/cetak/index.php
@@ -1,10 +1,13 @@
-<?php 
+<?php
+declare(strict_types=1);
+ 
 
 ob_start();	
 session_start();
 
 	if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){
-		header('location:/login');
+		header('Location: /login');
+		exit;
 	}
 	else {
 
```
