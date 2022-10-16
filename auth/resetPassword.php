<?php
    require_once "../backend/localization/localizationHandler.php";
    require_once "../backend/database/usersDatabase.php";
    require_once "../backend/database/sessionsDatabase.php";

    $currentLanguage = GetLanguage();

    $currentSession = GetCurrentSession();
    if ($currentSession != null)
    {
        header("Location: https://maple.software/");
        die();
    }

    $self = explode(".", htmlspecialchars($_SERVER["PHP_SELF"]));
    $self = $self[0];

    $hashFailure = false;
    $passwordFailure = false;
    $attemptedToReset = false;
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if (isset($_GET["hash"]) && !empty($_GET["hash"]))
        {
            $user = GetUserByUniqueHash($_GET["hash"]);
            if ($user == null)
                $hashFailure = true;
        }
        else
            $hashFailure = true;
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]))
    {
        $result = resetPassword($_GET["hash"], $_POST["password"], $_POST["passwordConfirmation"]);
        if ($result == 1)
            $hashFailure = true;
        else if ($result == 2)
            $passwordFailure = true;

        $attemptedToReset = true;
    }

    function resetPassword($hash, $password, $passwordConfirmation)
    {
        $user = GetUserByUniqueHash($hash);
        if ($user == null)
            return 1;

        if ($password != $passwordConfirmation)
            return 2;

        SetPassword($user["ID"], $password);
        SetUniqueHash($user["ID"], NULL);

        return 0;
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title><?= GetLocalizedString("TITLE_PASSWORD_RESET").' - Maple' ?></title>
        <link rel="icon" href="../assets/web/images/mapleleaf.svg?v=1.6">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../assets/web/dependencies/bootstrap/css/bootstrap.min.css?v=1.6">
        <link rel="stylesheet" href="../assets/web/dependencies/aos/css/aos.css?v=1.6"/>
        <link rel="stylesheet" href="../assets/web/css/main.css?v=1.6">
        <link rel="stylesheet" href="../assets/web/css/auth.css?v=1.8">

        <script src="../assets/web/dependencies/bootstrap/js/bootstrap.min.js?v=1.6"></script>
        <script src="../assets/web/dependencies/jquery/js/jquery-3.6.0.min.js?v=1.6"></script>
        <script src="../assets/web/dependencies/aos/js/aos.js?v=1.6"></script>
        <script src="https://kit.fontawesome.com/d1269851a5.js?v=1.6" crossorigin="anonymous"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>

    <body>
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark py-3">
            <div class="container">
                <a class="navbar-brand" href="https://maple.software">
                    <div class="d-flex align-items-center">
                        <span class="navbar-brand-logo">
                            <img src="../assets/web/images/mapleleaf.svg?v=1.6" width="30" height="30" class="d-inline-block align-top" alt="">
                        </span>
                        <span class="navbar-brand-name">
                            <h2 class="fw-bold m-0">Maple</h2>
                        </span>
                    </div>
                    <p class="navbar-brand-motto m-0 text-center fw-bold">the quickest way to the top</p>
                </a>

                <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-6"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>

                <div class="collapse navbar-collapse" id="navcol-6">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="https://maple.software/"><i class="fa-solid fa-house"></i> <?= GetLocalizedString("HEADER_HOME"); ?></a></li>
                        <div class="nav-item dropdown">
                            <a href="../help" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa-solid fa-headset"></i> <?= GetLocalizedString("HEADER_HELP"); ?></a>
                            <div class="dropdown-menu">
                                <a href="../help/getting-started" class="dropdown-item"><?= GetLocalizedString("HEADER_HELP_GETTING_STARTED"); ?></a>
                                <a href="../help/features" class="dropdown-item"><?= GetLocalizedString("HEADER_HELP_FEATURES"); ?></a>
                                <a href="../help/faq" class="dropdown-item"><?= GetLocalizedString("HEADER_HELP_FAQ"); ?></a>
                                <a href="../help/payment-issues" class="dropdown-item"><?= GetLocalizedString("HEADER_HELP_PAYMENT_ISSUES"); ?></a>
                                <a href="../help/software-issues" class="dropdown-item"><?= GetLocalizedString("HEADER_HELP_SOFTWARE_ISSUES"); ?></a>
                                <a href="../help/report-a-bug" class="dropdown-item"><?= GetLocalizedString("HEADER_HELP_REPORT_A_BUG"); ?></a>
                                <a href="../help/suggest-a-feature" class="dropdown-item"><?= GetLocalizedString("HEADER_HELP_SUGGEST_A_FEATURE"); ?></a>
                                <a href="../help/contact-us" class="dropdown-item"><?= GetLocalizedString("HEADER_HELP_CONTACT_SUPPORT"); ?></a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?= $currentLanguage == "ru" ? '<img src="https://flagicons.lipis.dev/flags/4x3/ru.svg" width="22" height="22"> '.GetLocalizedString("HEADER_LANGUAGE_SELECTOR_RUSSIAN") : '<img src="https://flagicons.lipis.dev/flags/4x3/gb.svg" width="22" height="22"> '.GetLocalizedString("HEADER_LANGUAGE_SELECTOR_ENGLISH") ?></a>
                            <div class="dropdown-menu">
                                <a href="#" class="dropdown-item" onclick="location.href='../localization/change-language.php?l=en&r=' + location.href"><img src="https://flagicons.lipis.dev/flags/4x3/gb.svg" width="22" height="22"> <?= GetLocalizedString("HEADER_LANGUAGE_SELECTOR_ENGLISH"); ?></a>
                                <a href="#" class="dropdown-item" onclick="location.href='../localization/change-language.php?l=ru&r=' + location.href"><img src="https://flagicons.lipis.dev/flags/4x3/ru.svg" width="22" height="22"> <?= GetLocalizedString("HEADER_LANGUAGE_SELECTOR_RUSSIAN"); ?></a>
                            </div>
                        </div>
                    </ul>
                    <span class="ms-md-2">
                        <button type="button" onclick="location.href='login';" class="btn btn-primary"><?= GetLocalizedString("HEADER_LOG_IN"); ?></button>
                        <button type="button" onclick="location.href='signup';" class="btn btn-primary"><?= GetLocalizedString("HEADER_SIGN_UP"); ?></button>
                    </span>
                </div>
            </div>
        </nav>

        <div class="full-height-container d-flex flex-column justify-content-center align-items-center text-center" data-aos="fade" data-aos-duration="1000" data-aos-once="true">
            <h1 class="fw-bold"><?= GetLocalizedString("AUTH_PASSWORD_RESET") ?></h1>
            <?php
                if (!$hashFailure && !$passwordFailure && $attemptedToReset)
                {
                    echo(GetLocalizedString("AUTH_PASSWORD_RESET_SUCCESS"));
                }
                else if ($hashFailure)
                {
                    echo(GetLocalizedString("AUTH_PASSWORD_RESET_FAIL"));
                }
                else
                {
                    echo('<div class="auth-form mt-4">
                              <div class="p-4 text-start">
                                  <form action="'.$self.'?hash='.$_GET['hash'].'" method="post">
                                      <div>
                                          <p class="m-0">'.GetLocalizedString("AUTH_PASSWORD_RESET_NEW_PASSWORD").'</p>
                                          <input type="password" name="password" class="form-control" required>
                                      </div>
                                      
                                      <div class="mt-3">
                                          <p class="m-0">'.GetLocalizedString("AUTH_PASSWORD_RESET_NEW_PASSWORD_CONFIRM").'</p>
                                          <input type="password" name="passwordConfirmation" class="form-control" required>
                                          <p class="m-0 text-danger" '.($passwordFailure ? '' : 'hidden').'>'.GetLocalizedString("AUTH_PASSWORD_RESET_PASSWORD_MISMATCH").'</p>
                                      </div>

                                      <div class="mt-3">
                                          <button type="submit" name="submit" class="btn btn-primary w-100">'.GetLocalizedString("AUTH_PASSWORD_RESET_RECOVER").'</button>
                                      </div>
                                  </form>
                              </div>
                          </div>');
                }
            ?>
        </div>

        <footer class="text-center py-4">
            <div class="container">
                <div class="row row-cols-2 row-cols-lg-3 align-items-center">
                    <div class="col">
                        <p class="my-2">Copyright © 2022 maple.software</p>
                    </div>
                    <div class="col">
                        <ul class="list-inline my-2">
                            <li class="list-inline-item">
                                <a class="discord-icon" href="../discord"><i class="fa-brands fa-discord"></i></a>
                                <a class="youtube-icon" href="https://www.youtube.com/channel/UCzyZrNQWaF3iSdqBX4ls42g"><i class="fa-brands fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col">
                        <ul class="list-inline my-2">
                            <li class="list-inline-item"><a href="../legal/terms-of-service"><?= GetLocalizedString("FOOTER_TERMS_OF_SERVICE"); ?></a></li>
                            <li class="list-inline-item"><a href="../legal/privacy-policy"><?= GetLocalizedString("FOOTER_PRIVACY_POLICY"); ?></a></li>
                            <li class="list-inline-item"><a href="../legal/contacts"><?= GetLocalizedString("FOOTER_CONTACTS"); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </body>

    <script>
        AOS.init();
    </script>

</html>
