<?php  include 'header.html.php'; ?>

    <main id="explo">
        <section>
            <h2> Mes Réalisations 
                <?php if($tri == "modelisation"){ ?> 3D <?php }else{ ?> 2D <?php } ?>
            </h2>

            <div id="main">
                <?php foreach ($projetListe as $value){ ?>
                    <?php if($value->type == $tri){ ?>
                        <div><img src="<?= $value->lien ?>" alt="<?= $value->alt ?> invisible"/></div>
                    <?php } ?>
                <?php } ?>
            </div>
        </section>

        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <div>
                <img id="selectedImg" src="../../media/image/Logo.png" alt="Retour Invisible"/>
                <div id="com">
                    <h3>Commentaire</h3>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px"           iewBox="0 0 24 24" width="30px" fill="white"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="white"><path d="M0 0h24v24H0V0z" fill="none" opacity=".87"/><path d="M15 3H6c-.83 0-1.54.5-1.84 1.22l-3.02 7.05c-.09.23-.14.47-.14.73v2c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .41.17.79.44 1.06L9.83 23l6.58-6.59c.37-.36.59-.86.59-1.41V5c0-1.1-.9-2-2-2zm0 12l-4.34 4.34L11.77 14H3v-2l3-7h9v10zm4-12h4v12h-4z"/></svg>
                    </div>
                    <label for="msg">Message :</label>
                    <textarea id="msg" name="user_message" placeholder="..." rows="5"></textarea>
                    <input type="button" value="Envoyer"/>
                </div>
            </div>
        </div>

    </main>

<?php  include 'footer.html.php'; ?>
