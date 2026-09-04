<?php

require_once __DIR__ . '/Aviao.php';

/**
 * Fila de decolagem (FIFO) — controla a ordem em que os aviões decolam.
 * Os dados ficam guardados em $_SESSION['voos'] pra persistir entre
 * requisições; esta classe só organiza as operações em cima disso.
 */
class FilaDecolagem
{
    public function __construct()
    {
        if (!isset($_SESSION['voos']) || !is_array($_SESSION['voos'])) {
            $_SESSION['voos'] = [];
        }
    }

    /** b) Adiciona um avião ao final da fila. */
    public function adicionarAviao(Aviao $aviao): void
    {
        $_SESSION['voos'][] = $aviao;
    }

    /** a) Remove e retorna o avião da frente da fila (quem decola agora). */
    public function decolarPrimeiro(): ?Aviao
    {
        if (empty($_SESSION['voos'])) {
            return null;
        }
        return array_shift($_SESSION['voos']);
    }

    /** c) Total de aviões aguardando na fila. */
    public function total(): int
    {
        return count($_SESSION['voos']);
    }

    /** d) Lista todos os aviões na fila, na ordem. */
    public function listar(): array
    {
        return $_SESSION['voos'];
    }

    /** e) Avião na frente da fila (próximo a decolar), sem removê-lo. */
    public function proximo(): ?Aviao
    {
        return $_SESSION['voos'][0] ?? null;
    }

    /** f) Posição (1-based) de um avião na fila, pelo número do voo. */
    public function posicaoPorNumeroVoo(string $numeroVoo): ?int
    {
        foreach ($_SESSION['voos'] as $indice => $aviao) {
            if ($aviao->numeroVoo === $numeroVoo) {
                return $indice + 1;
            }
        }
        return null;
    }

    /** Auxiliar: impede cadastrar duas vezes o mesmo número de voo. */
    public function existeNumeroVoo(string $numeroVoo): bool
    {
        return $this->posicaoPorNumeroVoo($numeroVoo) !== null;
    }

    /** Esvazia a fila (usado no link "Limpar lista"). */
    public function limpar(): void
    {
        $_SESSION['voos'] = [];
    }
}