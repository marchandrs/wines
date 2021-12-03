<?php

namespace App\Controllers;

class Customer extends BaseController
{
    const customersJsonUrl = "http://www.mocky.io/v2/598b16291100004705515ec5";
    const historyJsonUrl = "http://www.mocky.io/v2/598b16861100004905515ec7";

    public function listAll()
    {
        $json = file_get_contents(Customer::customersJsonUrl);
        $jsonCustomersObj = json_decode($json);
        $json = file_get_contents(Customer::historyJsonUrl);
        $jsonHistoryObj = json_decode($json);

        $customers = [];

        foreach ($jsonCustomersObj as $c) {
            $customer = new \App\Models\Customer;
            $customer->id = $c->id;
            $customer->cpf = $c->cpf;
            $customer->nome = $c->nome;
            $customer->compras = $this->filterComprasByCPF($jsonHistoryObj, $customer->cpf);

            /* $customer->compras = array_filter($jsonHistoryObj, function($v, $k) {
                return $v->cliente == $customer->cpf;
            }, ARRAY_FILTER_USE_BOTH); */

            $customer->valorTotalCompras = (float) array_sum(array_column($customer->compras, "valorTotal"));
            array_push($customers, $customer);
        }

        usort($customers, function($a, $b) {
            if ($a->valorTotalCompras == $b->valorTotalCompras) {
                return 0;
            } else if ($a->valorTotalCompras > $b->valorTotalCompras) {
                return -1;
            } else {
                return 1;
            }
        });

        $data['customers'] = $customers;
        $data['content'] = view('listAll', $data);
        return view('template/admin_template', $data);
    }

    public function biggestSinglePurchase()
    {
        $json = file_get_contents(Customer::customersJsonUrl);
        $jsonCustomersObj = json_decode($json);
        $json = file_get_contents(Customer::historyJsonUrl);
        $jsonHistoryObj = json_decode($json);

        $customers = [];

        foreach ($jsonCustomersObj as $c) {
            $customer = new \App\Models\Customer;
            $customer->id = $c->id;
            $customer->cpf = $c->cpf;
            $customer->nome = $c->nome;
            $customer->compras = $this->filterComprasByCPF($jsonHistoryObj, $customer->cpf);

            foreach($customer->compras as $compra) {
                if (\DateTime::createFromFormat("d-m-Y", $compra->data)->format("Y") == "2016"  && $compra->valorTotal > $customer->maiorCompraUnica) {
                    $customer->maiorCompraUnica = $compra->valorTotal;
                }
            }

            $customer->valorTotalCompras = (float) array_sum(array_column($customer->compras, "valorTotal"));
            array_push($customers, $customer);
        }

        usort($customers, function($a, $b) {
            if ($a->maiorCompraUnica == $b->maiorCompraUnica) {
                return 0;
            } else if ($a->maiorCompraUnica > $b->maiorCompraUnica) {
                return -1;
            } else {
                return 1;
            }
        });

        $data['customers'] = $customers;
        $data['content'] = view('biggestSinglePurchase', $data);
        return view('template/admin_template', $data);
    }

    public function listLoyalCustomers()
    {
        $json = file_get_contents(Customer::customersJsonUrl);
        $jsonCustomersObj = json_decode($json);
        $json = file_get_contents(Customer::historyJsonUrl);
        $jsonHistoryObj = json_decode($json);

        $customers = [];

        foreach ($jsonCustomersObj as $c) {
            $customer = new \App\Models\Customer;
            $customer->id = $c->id;
            $customer->cpf = $c->cpf;
            $customer->nome = $c->nome;
            $customer->compras = $this->filterComprasByCPF($jsonHistoryObj, $customer->cpf);
            $customer->valorTotalCompras = (float) array_sum(array_column($customer->compras, "valorTotal"));
            $customer->numeroDeCompras = count($customer->compras);
            array_push($customers, $customer);
        }

        usort($customers, function($a, $b) {
            if ($a->numeroDeCompras == $b->numeroDeCompras) {
                return 0;
            } else if ($a->numeroDeCompras > $b->numeroDeCompras) {
                return -1;
            } else {
                return 1;
            }
        });

        $data['customers'] = $customers;
        $data['content'] = view('listLoyalCustomers', $data);
        return view('template/admin_template', $data);
    }

    public function recommendation()
    {
        $json = file_get_contents(Customer::customersJsonUrl);
        $jsonCustomersObj = json_decode($json);
        $customers = [];
        foreach ($jsonCustomersObj as $c) {
            $customer = new \App\Models\Customer;
            $customer->id = $c->id;
            $customer->cpf = $c->cpf;
            $customer->nome = $c->nome;
            array_push($customers, $customer);
        }

        $data['customers'] = $customers;
        $data['content'] = view('recommendation', $data);
        return view('template/admin_template', $data);
    }

    public function recommendationResult($id) {
        $json = file_get_contents(Customer::customersJsonUrl);
        $jsonCustomersObj = json_decode($json);
        $json = file_get_contents(Customer::historyJsonUrl);
        $jsonHistoryObj = json_decode($json);

        $customer = $this->getCustomerById($jsonCustomersObj, $id);        
        $customer->compras = $this->filterComprasByCPF($jsonHistoryObj, $customer->cpf);
        $vinhosComprados = [];

        foreach ($customer->compras as $compra) {
            foreach($compra->itens as $item) {
                $summed = false;
                foreach ($vinhosComprados as $v) {
                    if (property_exists($v, "produto") && $v->produto === $item->produto) {
                        $v->quantidade = $v->quantidade + 1;
                        $summed = true;
                    }
                }
                if (!$summed) {
                    $vinhoComprado = new \App\Models\VinhoComprado;
                    $vinhoComprado->produto = $item->produto;
                    $vinhoComprado->variedade = $item->variedade;
                    $vinhoComprado->quantidade = 1;
                    array_push($vinhosComprados, $vinhoComprado);
                }
            }
        }        
        usort($vinhosComprados, function($a, $b) {
            if ($a->quantidade == $b->quantidade) {
                return 0;
            } else if ($a->quantidade > $b->quantidade) {
                return -1;
            } else {
                return 1;
            }
        });
        $vinhoPreferido = $vinhosComprados[0]->produto;
        $variedadePreferida = $vinhosComprados[0]->variedade;
        $vinhosMesmaVariedade = $this->filterVinhosByVariedade($jsonHistoryObj, $variedadePreferida);
        if (($key = array_search($vinhoPreferido, $vinhosMesmaVariedade)) !== false) {
            unset($vinhosMesmaVariedade[$key]);
        }

        $data['customer'] = $customer;
        $data['vinhosComprados'] = $vinhosComprados;
        $data['variedadePreferida'] = $variedadePreferida;
        $data['vinhoPreferido'] = $vinhoPreferido;
        $data['vinhosMesmaVariedade'] = implode(', ', $vinhosMesmaVariedade);
        /* $data['vinhosMesmaVariedade'] = $vinhosMesmaVariedade; */
        $data['content'] = view('recommendationResult', $data);
        return view('template/admin_template', $data);
    }

    private function filterComprasByCPF($jsonHistoryObj, $cpf)
    {
        $compras = [];
        foreach ($jsonHistoryObj as $compra) {
            $cpf_compra_sanitizado = preg_replace('/[^0-9]/', '', $compra->cliente);
            $cpf_sanitizado = preg_replace('/[^0-9]/', '', $cpf);
            if ($cpf_compra_sanitizado == $cpf_sanitizado) {
                array_push($compras, $compra);
            }
        }
        return $compras;
    }

    private function getCustomerById($jsonCustomersObj, $id) {
        $customer = new \App\Models\Customer;

        foreach($jsonCustomersObj as $c) {
            if ($c->id == $id) {
                $customer->id = $c->id;
                $customer->cpf = $c->cpf;
                $customer->nome = $c->nome;
            }
        }

        return $customer;
    }

    /* retorna um array de string com nomes de vinhos da respectiva variedade */
    private function filterVinhosByVariedade($jsonHistoryObj, $variedade) {
        $vinhos = [];
        foreach($jsonHistoryObj as $compra) {
            foreach($compra->itens as $item) {
                if ($item->variedade == $variedade && !in_array($item->produto, $vinhos)) {
                    array_push($vinhos, $item->produto);
                }
            }
        }
        return $vinhos;
    }
}
