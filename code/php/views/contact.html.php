<?php  include 'header.html.php'; ?>

        <main id="explo">
            <section class = formul>
                <div>
                    <div>
                        <h2>Une question, une offre d'emploi, un projet ?</h2>
                        <p>Contactez-moi par mail, téléphone ou en message privé sur les réseaux sociaux !</p>
                        <div>
                            <a href="https://www.linkedin.com/in/maxime-lopes" target="_blank"><img src="../../media/image/site/linkedin.jpg" alt="logo linkedin invisible"/></a>
                            <a href="https://twitter.com/UltiDarkness" target="_blank"><img src="../../media/image/site/twitterjpg.jpg" alt="logo twitter invisible"/></a>
                        </div>
                    </div>
                </div>
                <div>
                    <form action="contact.html" method="post">
                        <h3>Me Contacter par Email</h3>
            
                        <!--Nom et Prénom-->
                        <div class="content">
                            <div class="content2">
                                <input type="text" id="lastname" name="user_lastname" placeholder="Nom (Requis)" pattern="[A-Za-z]{3,}" required/>
                            </div>
                            <div class="content3">
                                <input type="text" id="firstname" name="user_firstname" placeholder="Prénom (Requis)" pattern="[A-Za-z]{3,}" required/>
                            </div>
                        </div>

                        <!--Email-->
                        <div>
                            <input type="email" id="mail" name="user_email" placeholder="Email (Requis)" required/>
                        </div>
            
                        <div>
                            <input type="text" id="object" name="user_object" placeholder="Objet de l'email (Requis)" required/>
                        </div>

                        <!--Message-->
                        <div>
                            <label for="msg">Message :</label>
                            <textarea id="msg" name="user_message" placeholder="Commentaire (Requis)" required></textarea>
                        </div>
            
                        <!--Validation-->
                        <input type="submit" value="Envoyer"/>
                    </form>
                </div>
            </section>
        </main>

<?php  include 'footer.html.php'; ?>
