<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="moncms.css" rel="stylesheet" />
    <title>Mon cms - Home</title>
</head>
<body>
    <header>
        <h1>Billets pour l'alaska</h1>
    </header>
    <?php foreach ($billets as $billets): ?>
        <article>
            <h2><?php echo $billets['titre'] ?></h2>
            <p><?php echo $billets['contenu'] ?></p>
        </article>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">MonCMS</a> is a minimalistic CMS built as a showcase for modern PHP development.
    </footer>
</body>
</html>