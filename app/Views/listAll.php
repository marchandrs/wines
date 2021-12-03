<h1 class="page-title">Clientes com maior valor total em compras</h1>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">CPF</th>
            <th scope="col">Valor total compras</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($customers as $customer) {
                print "<tr>";
                print "     <th scope='row'>$customer->id</th>";
                print "     <td>$customer->nome</td>";
                print "     <td>$customer->cpf</td>";
                print "     <td>R$ $customer->valorTotalCompras</td>";
                print "</tr>";
            }
        ?>
    </tbody>
</table>