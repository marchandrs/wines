<h1 class="page-title">Recomendação de vinho</h1>

<?php
    print "<p>O vinho preferido de <strong>$customer->nome</strong> parece ser o <strong>$vinhoPreferido</strong>, de acordo com seu histórico de compras.</p>";
    print "<p>Sua variedade preferida é $variedadePreferida.</p>";
    if (strlen($vinhosMesmaVariedade) > 0) {
        print "<p>Estes são outros vinhos da mesma variedade: $vinhosMesmaVariedade.</p>";
    }
?>