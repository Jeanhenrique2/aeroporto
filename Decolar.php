<?php

require_once __DIR__ . '/Aviao.php';
require_once __DIR__ . '/FilaDecolagem.php';

session_start();

$fila = new FilaDecolagem();
$aviao = $fila->decolarPrimeiro();

if ($aviao === null) {
    $_SESSION['flash_erro'] = 'Não há aviões na fila para decolar.';
} else {
    $_SESSION['flash_sucesso'] = 'Voo ' . $aviao->numeroVoo . ' (' . $aviao->empresaAerea . ') decolou com destino a ' . $aviao->destino . '.';
}

header('Location: index.php');
exit;