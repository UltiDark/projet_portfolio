<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Maxime LOPES - <?= titre()?></title>
        <link rel="stylesheet" href="../css/style.css" />
        <link rel="stylesheet" href="../css/projet.css" />
        <link rel="stylesheet" href="../css/asset.css" />
        <link rel="icon" href="../../media/image/Logo.png">
    </head>

    <body>
        <!--ENTETE-->
        <header>
            <a href="<?= url('accueil')?>">
                <img src="../../media/image/picto.png" alt="logo invisible"/>
            </a>
        
            <nav>
                <ul>
                    <li><a href="<?= url('accueil')?>" class="active">Accueil</a></li>
                    <li class="menu"><a>Projet</a>
                        <ul class="sous">
                            <li><a href="<?= url('projet&id=game')?>">Game</a></li>
                            <li><a href="<?= url('projet&id=web')?>" class="notActive">Web</a></li>
                        </ul>
                    </li>
                    <li class="menu"><a>Galerie</a>
                        <ul class="sous">
                            <li><a href="<?= url('projet&id=modelisation')?>">Modèles 3D</a></li>
                            <li><a href="<?= url('projet&id=sprite')?>">Assets 2D</a></li>
                        </ul>
                    </li>
                    <li class="menu"><a href="<?= url('contact')?>">Contacts</a></li>
                </ul>
            </nav>
        </header>

        <!--Parallax-->
        <section class="parallax">
            <img src="../../media/image/Parallax/stars.png" id="stars" alt="étoile invisible"/>
            <img src="../../media/image/Parallax/moon.png" id="moon" alt="lune invisible"/>
            <img src="../../media/image/Parallax/mountains_behind.png" id="mountains_behind" alt="montagne1 invisible"/>
            <h1 id="text"><?= titre()?></h1>
            <a href="#explo" id="btn">Explore</a>
            <img src="../../media/image/Parallax/mountains_front.png" id="mountains_front" alt="montage2 invisible"/>
        </section>