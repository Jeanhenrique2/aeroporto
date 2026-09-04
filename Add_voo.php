<?php

require_once __DIR__ . '/Aviao.php';
require_once __DIR__ . '/FilaDecolagem.php';

session_start();

$fila = new FilaDecolagem();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'modelo'             => trim($_POST['modelo'] ?? ''),
        'empresa_aerea'      => trim($_POST['empresa_aerea'] ?? ''),
        'origem'             => trim($_POST['origem'] ?? ''),
        'destino'            => trim($_POST['destino'] ?? ''),
        'numero_passageiros' => trim($_POST['numero_passageiros'] ?? ''),
        'numero_voo'         => trim($_POST['numero_voo'] ?? ''),
    ];

    $rotulos = [
        'modelo'             => 'Modelo',
        'empresa_aerea'      => 'Empresa',
        'origem'             => 'Origem',
        'destino'            => 'Destino',
        'numero_passageiros' => 'Passageiros',
        'numero_voo'         => 'Número do Voo',
    ];

    $campos_vazios = [];
    foreach ($dados as $chave => $valor) {
        if ($valor === '') {
            $campos_vazios[] = $rotulos[$chave];
        }
    }

    if (!empty($campos_vazios)) {
        $_SESSION['flash_erro'] = 'Voo não foi salvo. Campo(s) vazio(s): ' . implode(', ', $campos_vazios) . '.';
    } elseif (!ctype_digit($dados['numero_passageiros'])) {
        $_SESSION['flash_erro'] = 'Voo não foi salvo. "Passageiros" precisa ser um número.';
    } elseif ($fila->existeNumeroVoo($dados['numero_voo'])) {
        $_SESSION['flash_erro'] = 'Já existe um avião na fila com o voo ' . $dados['numero_voo'] . '.';
    } else {
        $aviao = new Aviao(
            $dados['modelo'],
            $dados['empresa_aerea'],
            $dados['origem'],
            $dados['destino'],
            (int) $dados['numero_passageiros'],
            $dados['numero_voo']
        );
        $fila->adicionarAviao($aviao);
        $_SESSION['flash_sucesso'] = 'Voo ' . $aviao->numeroVoo . ' cadastrado com sucesso.';
    }
}

header('Location: index.php');
exit;