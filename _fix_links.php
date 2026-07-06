<?php
/**
 * Gagan Dental & Aesthetics Clinic — one-shot link/copy fixer for shared
 * hosting (no SSH needed).
 *
 * WHY: On cPanel/FTP the symlinks Laravel needs for images (public/storage and
 * public/assets) usually don't survive the upload, so uploaded images and theme
 * graphics 404. This script recreates them (symlink if allowed, otherwise copy).
 *
 * HOW TO USE:
 *   1. Upload this file into the SAME folder your site URL points at
 *      (the folder you see when you open your site's home page).
 *   2. Open it in your browser:  https://your-domain/_fix_links.php
 *   3. Read the output, then DELETE this file (it's a security risk if left up).
 */

header('Content-Type: text/plain; charset=utf-8');

echo "Gagan Dental & Aesthetics Clinic — link setup\n";
echo "========================\n\n";

$here = __DIR__;
echo "Running from: {$here}\n\n";

/*
 * Figure out the project layout. Two supported setups:
 *   A) This folder IS admin/public        -> it has index.php + ../storage + ../../assets
 *   B) This folder is the PROJECT ROOT     -> it has admin/ + assets/ + index.php
 */
$isProjectRoot = is_dir($here . '/admin') && is_file($here . '/admin/bootstrap/app.php');
$isPublicDir   = is_file($here . '/index.php') && is_dir($here . '/../storage');

$links = [];

if ($isProjectRoot) {
    echo "Detected layout: PROJECT ROOT is the web root.\n\n";
    $storageReal = $here . '/admin/storage/app/public';
    $assetsReal  = $here . '/assets';
    // App is served via the root index.php AND via admin/public — link both spots.
    // 'css' holds the admin panel stylesheet (admin/public/css/admin.css),
    // referenced as asset('css/admin.css') => /<base>/css/admin.css.
    $links[$here . '/storage']             = $storageReal;
    $links[$here . '/assets']              = $assetsReal;
    $links[$here . '/css']                 = $here . '/admin/public/css';
    $links[$here . '/admin/public/storage'] = $storageReal;
    $links[$here . '/admin/public/assets']  = $assetsReal;
    $envFile = $here . '/admin/.env';
} elseif ($isPublicDir) {
    echo "Detected layout: this folder is admin/public (the web root).\n\n";
    $storageReal = $here . '/../storage/app/public';
    $assetsReal  = $here . '/../../assets';
    $links[$here . '/storage'] = $storageReal;
    $links[$here . '/assets']  = $assetsReal;
    $envFile = $here . '/../.env';
} else {
    echo "!! Could not detect the layout.\n";
    echo "   Put this file either in the project root (the folder with 'admin/' and 'assets/')\n";
    echo "   or in admin/public, then reload.\n";
    exit;
}

function abspath($p) { $r = realpath($p); return $r !== false ? $r : $p; }

function makeLink($link, $target) {
    $target = abspath($target);
    if (!file_exists($target)) {
        echo "  ! SKIP — source missing: {$target}\n";
        return;
    }
    // Already linked/exists?
    if (is_link($link)) {
        $cur = readlink($link);
        echo "  = already a link: {$link}  ->  {$cur}\n";
        return;
    }
    if (file_exists($link)) {
        echo "  = already exists (real folder, left as-is): {$link}\n";
        return;
    }
    // Try a symlink first (best — auto-updates as new images are added).
    if (@symlink($target, $link)) {
        echo "  + SYMLINKED: {$link}  ->  {$target}\n";
        return;
    }
    // Host blocks symlink() — fall back to a recursive copy.
    echo "  symlink() not allowed here — copying files instead...\n";
    $n = copyDir($target, $link);
    echo "  + COPIED {$n} files: {$target}  ->  {$link}\n";
    echo "    (note: re-run this after uploading new images, since it's a copy not a link)\n";
}

function copyDir($src, $dst) {
    @mkdir($dst, 0755, true);
    $count = 0;
    foreach (scandir($src) as $i) {
        if ($i === '.' || $i === '..') continue;
        $s = $src . '/' . $i;
        $d = $dst . '/' . $i;
        if (is_dir($s)) {
            $count += copyDir($s, $d);
        } elseif (@copy($s, $d)) {
            $count++;
        }
    }
    return $count;
}

echo "Creating links:\n";
foreach ($links as $link => $target) {
    makeLink($link, $target);
}

// ---- Show the APP_URL from .env (so we can confirm image URLs are right) ----
echo "\n";
if (isset($envFile) && is_file($envFile)) {
    $env = file_get_contents($envFile);
    if (preg_match('/^APP_URL=(.*)$/m', $env, $m)) {
        echo "APP_URL in .env: " . trim($m[1]) . "\n";
        $appUrl = trim($m[1]);
        echo "Admin login URL: " . rtrim($appUrl, '/') . "/login\n";
    } else {
        echo "APP_URL not found in .env — set APP_URL to your site's base URL\n";
    }
} else {
    echo "(.env not found at expected path; make sure APP_URL is set to your site's base URL)\n";
}

echo "\nDONE.  ✅  Now:\n";
echo "  1) Reload your site and check the images.\n";
echo "  2) Log in at the Admin login URL shown above.\n";
echo "  3) DELETE this file (_fix_links.php) — it must not stay on a live server.\n";
