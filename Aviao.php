<?php

/**
 * Representa um avião aguardando decolagem.
 */
class Aviao
{
    public string $modelo;
    public string $empresaAerea;
    public string $origem;
    public string $destino;
    public int $numeroPassageiros;
    public string $numeroVoo;

    public function __construct(
        string $modelo,
        string $empresaAerea,
        string $origem,
        string $destino,
        int $numeroPassageiros,
        string $numeroVoo
    ) {
        $this->modelo = $modelo;
        $this->empresaAerea = $empresaAerea;
        $this->origem = $origem;
        $this->destino = $destino;
        $this->numeroPassageiros = $numeroPassageiros;
        $this->numeroVoo = $numeroVoo;
    }
}