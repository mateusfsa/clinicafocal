<?php

/**
 * Script de instalação remota — Clinica Focal
 *
 * ⚠️  APAGUE este arquivo imediatamente após usar!
 *
 * Acesso: https://seudominio.com.br/setup.php?token=TROQUE_ESTE_TOKEN
 */

define('TOKEN_SECRETO', 'YBiGfsQ8WGDQuErJrXBfTqaPU57rNtVk4TWFiNEwZoA12nlwUS');

// Bloqueia acesso sem token
if (($_GET['token'] ?? '') !== TOKEN_SECRETO) {
    http_response_code(403);
    die('Acesso negado.');
}

// Só roda em ambiente não-produção ou com confirmação explícita
$confirmar = ($_GET['confirmar'] ?? '') === 'sim';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Setup — Clinica Focal</title>
    <style>
        body { font-family: monospace; background: #1e1e1e; color: #d4d4d4; padding: 2rem; }
        h1   { color: #4ec9b0; }
        h2   { color: #9cdcfe; margin-top: 2rem; }
        pre  { background: #252526; padding: 1rem; border-radius: 6px; overflow-x: auto; }
        .ok  { color: #4ec9b0; }
        .err { color: #f48771; }
        .warn{ color: #dcdcaa; }
        .btn { display:inline-block; margin:.5rem; padding:.6rem 1.2rem;
               background:#0e639c; color:#fff; border-radius:4px; text-decoration:none; }
    </style>
</head>
<body>

<h1>🏠 Clinica Focal — Setup</h1>

<?php if (!$confirmar): ?>

    <p class="warn">⚠️ Este script vai executar:</p>
    <pre>
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
    </pre>

    <a class="btn" href="?token=<?= TOKEN_SECRETO ?>&confirmar=sim">
        ✅ Confirmar e executar
    </a>

<?php else: ?>

<?php

$raiz = dirname(__DIR__); // pasta acima de public/
$php  = PHP_BINARY;       // caminho do executável PHP

// Localiza o Composer — tenta os caminhos mais comuns em cPanel
$composerCandidatos = [
    '/usr/local/bin/composer',
    '/usr/bin/composer',
    '/opt/cpanel/composer/bin/composer',
    (string) shell_exec('which composer 2>/dev/null'),
];
$composer = 'composer'; // fallback
foreach ($composerCandidatos as $c) {
    if ($c && file_exists(trim($c))) {
        $composer = trim($c);
        break;
    }
}

$comandos = [
    'Composer install'   => "cd {$raiz} && {$php} {$composer} install --no-dev --optimize-autoloader 2>&1",
    'Key generate'       => "{$php} {$raiz}/artisan key:generate --force 2>&1",
    'Migrate'            => "{$php} {$raiz}/artisan migrate --force 2>&1",
    'Config cache'       => "{$php} {$raiz}/artisan config:cache 2>&1",
    'Route cache'        => "{$php} {$raiz}/artisan route:cache 2>&1",
    'View cache'         => "{$php} {$raiz}/artisan view:cache 2>&1",
    'Storage link'       => "{$php} {$raiz}/artisan storage:link 2>&1",
];

foreach ($comandos as $nome => $cmd) {
    echo "<h2>{$nome}</h2><pre>";
    $saida = [];
    $codigo = 0;
    exec($cmd, $saida, $codigo);
    $texto = htmlspecialchars(implode("\n", $saida));
    $classe = $codigo === 0 ? 'ok' : 'err';
    echo "<span class='{$classe}'>{$texto}</span>";
    echo "</pre>";
    flush();
}

?>

    <h2 class="ok">✅ Concluído!</h2>

    <p class="warn">⚠️ <strong>APAGUE este arquivo agora:</strong></p>
    <a class="btn" href="?token=<?= TOKEN_SECRETO ?>&confirmar=sim&apagar=sim" style="background:#a1260d">
        🗑️ Apagar setup.php
    </a>

<?php
    // Auto-delete
    if (($_GET['apagar'] ?? '') === 'sim') {
        unlink(__FILE__);
        echo "<p class='ok'>Arquivo apagado com sucesso.</p>";
    }
?>

<?php endif; ?>

</body>
</html>
