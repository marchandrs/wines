<?php

namespace App\Models;

class Customer
{
    public $id;
    public $cpf;
    public $nome;
    public $compras;
    public $valorTotalCompras;
    public $numeroDeCompras;
    public $maiorCompraUnica = 0;

    public function __construct()
    {
        $this->compras = [];
    }
}