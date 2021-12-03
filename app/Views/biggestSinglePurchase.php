<h1 class="page-title">Clientes com maior compra única (2016)</h1>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">CPF</th>
            <th scope="col">Maior compra única</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($customers as $customer) {
                print "<tr>";
                print "     <th scope='row'>$customer->id</th>";
                print "     <td>$customer->nome</td>";
                print "     <td>$customer->cpf</td>";
                print "     <td>R$ $customer->maiorCompraUnica</td>";
                print "</tr>";
            }
        ?>
    </tbody>
</table>