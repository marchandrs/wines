<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="/css/admin.css" rel="stylesheet" type="text/css">

    <title>Wines</title>
</head>

<body>
    <div class="mobile-navbar text-center d-block d-md-none">
        <h1><a href="/admin/" class="mobile-menu-link">Wines</a></h1>
        <!-- <a href="">Clientes</a> -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 col-md-2 nav-menu-container d-none d-md-block">
                <div class="nav-menu">
                    <h1 class="nav-menu-brand">Wines</h1>
                    <p class="nav-menu-item"><a href="#" class="my-nav-link">Início</a></p>
                    <p class="nav-menu-item"><a href="/admin/" class="my-nav-link">Clientes</a></p>
                    <p class="nav-menu-item"><a href="#" class="my-nav-link">Produtos</a></p>
                    <p class="nav-menu-item"><a href="#" class="my-nav-link">Relatórios</a></p>
                    <p class="nav-menu-item"><a href="#" class="my-nav-link">Configurações</a></p>
                    <p class="nav-menu-item"><a href="/" class="my-nav-link">Sair</a></p>
                </div>
            </div>
            <div class="col-12 col-md-10 admin-container">
                <?php echo $content; ?>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>