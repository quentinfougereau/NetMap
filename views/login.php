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
                <h2>Login</h2>
                    <form action="../controllers/routes.php?action=login" method="POST">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="conditions" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Je certifie avoir lu et accepté les <a href="../views/ConditionUtilisation.html">Conditions Générales d'Utilisation</a></label>
                        </div>
                        <button type="submit" class="btn btn-netmap">Submit</button>
                    </form>
                <a href="../views/register.php">Créer un compte</a>
                <?php
                if (isset($error_msg)) {
                    $html = '<div>';
                    $html .= '<p class="display_error">' . $error_msg . '</p>';
                    $html .= '</div>';
                    echo $html;
                }
                ?>
            </div>
        </div>
    </main>
<?php
include('../views/footer.php'); 
?>