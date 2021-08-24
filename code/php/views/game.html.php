<?php  include 'header.html.php'; ?>

    <main id="explo">
        <div class="container">
            <section>
                <h2 id="rea">Mes réalisations</h2>
                <div class="rea" id="main">
                    <?php foreach ($projetListe as $value){ ?>
                        <?php if($value->type =="game"){ ?>
                            <div><img id="<?= $value->id -1 ?>" src="<?= $value->lien ?>" alt="<?= $value->alt ?> invisible"/></div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </section>
        </div>
    </main>

<?php  include 'footer.html.php'; ?>