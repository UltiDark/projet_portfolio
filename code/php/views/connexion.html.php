<?php  include 'header.html.php'; ?>

    <main id="explo">
        <section class = formul>
            <div>
                <form action="#" method="post">
                    <h3>Demande
                    <?php if ($_GET['route'] == 'inscription') { ?>d'inscription
	                <?php } else { ?>de connexion<?php } ?>
                    </h3>

                    <!--Identifiant-->
                    <div>
                        <input type="text" id="identifiant" name="user_identifiant" placeholder="identifiant (Requis)" required/>
                    </div>

                    <!--Email-->
                    <div>
                        <input type="email" id="mail" name="user_email" placeholder="Email (Requis)" required/>
                    </div>

                    <!--Mot de Passe-->
                    <div>
                        <input type="password" id="mdp" name="user_mdp" placeholder="Mot de Passe (Requis)" required/>
                    </div>
                    <?php if ($_GET['route'] == 'inscription') { ?>
                    <div>
                        <input type="password" id="mdpV" name="user_mdpV" placeholder="Vérification Mot de Passe (Requis)" required/>
                    </div>
                    <?php } ?>

                    <!--Validation-->
                    <input type="submit" value="Envoyer"/>
                    <?php if ($_GET['route'] == 'inscription') { ?>
					    <p>Déjà un compte ? <a href="<?= url('connexion') ?>">Connectez-vous !</a></p>
                    <?php } else { ?>
                        <p>Pas de compte ? <a href="<?= url('inscription') ?>">Inscrivez-vous !</a></p>
					    <label for="connect" class="form-check-label">
						    <input type="checkbox" class="form-check-input" name="connect" id="connect" value="true"> Rester connecté ?
					    </label>
                    <?php }?>
				</div>
                </form>
            </div>
        </section>
    </main>

<?php  include 'footer.html.php'; ?>
