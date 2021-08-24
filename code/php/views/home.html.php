<?php include 'header.html.php'; ?>

        <!--MAIN-->
        <main class="profil" id="explo">
        <!--Introduction-->
            <article class="img-gauche">
                <img src="../../media/image/Logo.png" alt="logo invisible"/>
                <div>
                    <h2>Profil</h2>
                    <p>
                        Je m'appelle Maxime LOPES et j'ai 21 ans. J'ai terminé mon cursus Game Design dans l'école ICAN, il m'a permis d'apprendre à conceptualiser et produire des jeux vidéo.
                    </p>
                    <p>
                        Passionné par les jeux vidéos j'ai toujours voulu apprendre les rouages de leur céation et pouvoir en créer par moi-même. J'y ai appris un grand nombre de métiers différent ce qui me permet d'être polyvalent sur n'importe quel projet.
                    </p>
                    <p>
                        Aujourd'hui, étant un formation de Développeur Web et Web Mobile, je suis à la recherche d'un stage d'un mois pour la valider.
                    </p>
                    <p>
                        À long terme, j'aimerais pouvoir évoluer dans le milieu de la création de Jeu Vidéo et Web en ayant appris le plus possible sur toutes les étapes de création (programmation, conception, modélisation, level design, UI, sound design...).
                    </p>
                </div>
            </article>

            <!--Domaines-->
            <section class="domaine">
                <h2>Domaines</h2>
                <div>
                    <?php foreach ($domainesListe as $value){ ?>
                        <div class="case">
                            <h3><?=$value->titre ?></h3>
                            <div>
                                <ul>
                                    <li><?=$value->logiciels ?></li>
                                    <li><?=$value->competences ?></li>
                                    <li><?=$value->styles ?></li>
                                </ul>
                            </div>
                        </div>
                    <?php }  ?>
                </div>
            </section>

            <!--Frise-->
            <section>
                <h2>Frise Chrono</h2>
                <div class="frise">

                <ol>                    
                    <?php foreach ($frisesListe as $value){ ?>
                        <li>
                            <a href="#<?=$value->id_div ?>Info">
                                <div id="<?=$value->id_div ?>" class="<?=$value->class_div ?>">
                                    <time><?=$value->date ?></time>
                                    <?=$value->titre ?>
                                </div>
                            </a>
                        </li>
                    <?php }  ?>
                    <li>
                        <div>
                        </div>
                    </li>
                </ol>
            </div>
            </section>

            <!--FORMATIONS-->
            <?php foreach ($frisesListe as $value){ ?>
                <?php if($value-> contenu != NULL){ ?>
                    <aside id="<?=$value->id_div ?>Info" class="img-droite">
                        <div>
                            <p><?=$value->contenu ?></p>
                        </div>
                        <div><img src="<?=$value->image ?>"/></div>
                    </aside >
                <?php }  ?>
            <?php }  ?>

        </main>

<?php  include 'footer.html.php'; ?>