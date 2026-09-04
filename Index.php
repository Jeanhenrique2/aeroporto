<?php

require_once __DIR__ . '/Aviao.php';
require_once __DIR__ . '/FilaDecolagem.php';

session_start();

// Link de reset (?limpar=1) para descartar dados de teste
if (isset($_GET['limpar'])) {
    $_SESSION['voos'] = [];
    header('Location: index.php');
    exit;
}

$fila = new FilaDecolagem();

// f) Busca de posição por número do voo (via ?buscar_voo=...)
$resultado_busca = null;
$busca_numero_voo = trim($_GET['buscar_voo'] ?? '');
if ($busca_numero_voo !== '') {
    $posicao_encontrada = $fila->posicaoPorNumeroVoo($busca_numero_voo);
    $resultado_busca = $posicao_encontrada === null
        ? "Voo {$busca_numero_voo} não está na fila."
        : "O voo {$busca_numero_voo} está na posição {$posicao_encontrada} da fila.";
}

$proximo = $fila->proximo();
$fila_completa = $fila->listar();
$total = $fila->total();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Aeroporto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Aeroporto Internacional</h1>
    </div>

    <div class="pista">
        <h2>Pista de Decolagem</h2>
        <p class="total-fila">
            <?php echo $total; ?>
            <?php echo $total === 1 ? 'avião' : 'aviões'; ?> na fila
        </p>
    </div>

    <!-- e) Próximo avião a decolar + a) ação de decolar -->
    <div class="proximo-a-decolar">
        <h2>Próximo a Decolar</h2>

        <?php if (!empty($_SESSION['flash_erro'])): ?>
            <p class="flash flash-erro"><?php echo htmlspecialchars($_SESSION['flash_erro']); ?></p>
            <?php unset($_SESSION['flash_erro']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_sucesso'])): ?>
            <p class="flash flash-sucesso"><?php echo htmlspecialchars($_SESSION['flash_sucesso']); ?></p>
            <?php unset($_SESSION['flash_sucesso']); ?>
        <?php endif; ?>

        <?php if ($proximo === null): ?>
            <p>Nenhum avião na fila.</p>
        <?php else: ?>
            <div class="cartao-proximo">
                <strong>Voo <?php echo htmlspecialchars($proximo->numeroVoo); ?></strong>
                (<?php echo htmlspecialchars($proximo->empresaAerea); ?>)
                — Modelo: <?php echo htmlspecialchars($proximo->modelo); ?><br>
                Origem: <?php echo htmlspecialchars($proximo->origem); ?>
                &rarr; Destino: <?php echo htmlspecialchars($proximo->destino); ?><br>
                Passageiros: <?php echo htmlspecialchars((string) $proximo->numeroPassageiros); ?>
            </div>
            <form action="decolar.php" method="post">
                <button type="submit" class="botao-decolar">Decolar este avião</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- d) Lista completa da fila -->
    <div class="fila-lista">
        <h2>Fila de Decolagem Completa</h2>
        <p><a href="?limpar=1">Limpar lista</a></p>

        <?php if (empty($fila_completa)): ?>
            <p>Nenhum voo cadastrado ainda.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($fila_completa as $i => $aviao): ?>
                    <li>
                        <span class="posicao">Posição <?php echo $i + 1; ?></span>
                        <strong>Voo <?php echo htmlspecialchars($aviao->numeroVoo); ?></strong>
                        (<?php echo htmlspecialchars($aviao->empresaAerea); ?>)
                        — Modelo: <?php echo htmlspecialchars($aviao->modelo); ?><br>
                        Origem: <?php echo htmlspecialchars($aviao->origem); ?>
                        &rarr; Destino: <?php echo htmlspecialchars($aviao->destino); ?><br>
                        Passageiros: <?php echo htmlspecialchars((string) $aviao->numeroPassageiros); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- f) Buscar posição pelo número do voo -->
    <div class="buscar-voo">
        <h2>Buscar Posição pelo Número do Voo</h2>
        <form action="index.php" method="get">
            <input
                type="text"
                name="buscar_voo"
                placeholder="Ex: VO1234"
                value="<?php echo htmlspecialchars($busca_numero_voo); ?>"
            >
            <button type="submit">Buscar</button>
        </form>
        <?php if ($resultado_busca !== null): ?>
            <p class="resultado-busca"><?php echo htmlspecialchars($resultado_busca); ?></p>
        <?php endif; ?>
    </div>

    <!-- b) Adicionar avião na fila -->
    <div class="add-voo">
        <h2>Adicionar Voo</h2>

        <form action="add_voo.php" method="post">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required><br>

            <label for="empresa_aerea">Empresa:</label>
            <input type="text" id="empresa_aerea" name="empresa_aerea" required><br>

            <label for="origem">Origem:</label>
            <input type="text" id="origem" name="origem" required><br>

            <label for="destino">Destino:</label>
            <input type="text" id="destino" name="destino" required><br>

            <label for="numero_passageiros">Passageiros:</label>
            <input type="text" id="numero_passageiros" name="numero_passageiros" required><br>

            <label for="numero_voo">Número do Voo:</label>
            <input type="text" id="numero_voo" name="numero_voo" required><br>

            <button type="submit" name="enviar" value="Enviar">Enviar</button>
        </form>
    </div>
</body>
</html>