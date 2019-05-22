<?php 
include('../views/header.php');
?>

    <header class="cd-main-header js-cd-main-header">
        <div class="cd-logo-wrapper">
            <a href="#0" class="cd-logo">
                <img src="../img/cd-logo.svg" alt="Logo">
                <!-- <img src="assets/img/cd-logo.old.svg" alt="Logo"> -->
            </a>
        </div>
        <button class="reset cd-nav-trigger js-cd-nav-trigger" aria-label="Toggle menu"><span></span></button>

        <ul class="cd-nav__list js-cd-nav__list">
            <li class="cd-nav__item cd-nav__item--has-children cd-nav__item--account js-cd-item--has-children">
                <a href="#0">
                    <i class="far fa-user-circle"></i>&nbsp;
                    <span>Mon compte</span>
                </a>

                <ul class="cd-nav__sub-list">
                    <li class="cd-nav__sub-item"><a href="../views/login.php">Se connecter</a></li>
                    <li class="cd-nav__sub-item"><a href="../controllers/c_logout.php">Se deconnecter</a></li>
                </ul>
            </li>
        </ul>
    </header> <!-- .cd-main-header -->

    <main class="cd-main-content">
        <nav class="cd-side-nav js-cd-side-nav">
            <ul class="cd-side__list js-cd-side__list">
                <li class="cd-side__label"><span>Main</span></li>
                <li class="cd-side__item cd-side__item--has-children cd-side__item--overview js-cd-item--has-children">
                    <a href="../views/login.php">Se Connecter</a>
                </li>
            </ul>

            <ul class="cd-side__list js-cd-side__list">
                <li class="cd-side__label"><span>Action</span></li>
            </ul>
        </nav>

        <div class="cd-content-wrapper">

            <div class="container">
            <h1>Accueil - NetMap</h1>
            <h2>Register</h2>
                <form action="../controllers/routes.php?action=register" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" name="username" class="form-control" id="inputEmail4" placeholder="Email" required>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="inputAddress">Pseudo</label>
                        <input type="text" name="pseudo" class="form-control" id="inputAddress" placeholder="Pseudo" required>
                    </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Verify Password</label>
                        <input type="password" name="verifypassword" class="form-control" id="inputPassword4" placeholder="Password" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Adresse</label>
                            <input type="text" name="adresse" class="form-control" id="inputCity">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputCity">Ville</label>
                            <input type="text" name="city" class="form-control" id="inputCity">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Code Postal</label>
                            <input type="text" name="CP" class="form-control" id="inputZip">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                            Check me out
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-netmap">Sign in</button>

                </form>
                <a href="../views/login.php">J'ai déjà un compte</a>
            </div>

        </div>
    </main>

<?php
include('../views/footer.php'); 
?>