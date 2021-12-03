<h1 class="page-title">Recomendação de vinho</h1>

<p>
    Sugerimos um vinho para um determinado cliente a partir de seu histórico de compras.
</p>

<table class="table mt-5">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">CPF</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($customers as $customer) {
            print "<tr>";            
            print "     <th scope='row'>$customer->id</th>";
            print "     <td><a class='link' href='/customer/recommendationResult/$customer->id'>$customer->nome</a></td>";
            print "     <td>$customer->cpf</td>";
            print "</tr>";
        }
        ?>
    </tbody>
</table>