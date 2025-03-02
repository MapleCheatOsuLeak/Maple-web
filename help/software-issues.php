<?php
    require_once "../backend/database/sessionsDatabase.php";

    $loggedIn = false;
    $currentSession = GetCurrentSession();
    if ($currentSession != null)
    {
        $loggedIn = true;
        SetSessionActivity($currentSession["SessionToken"], gmdate('Y-m-d H:i:s', time()));
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Software issues - Maple</title>
        <meta name="description" content="Troubleshoot and resolve software-related issues with Maple using our comprehensive guides and expert tips. Get back in the game quickly!">
        <link rel="icon" href="../assets/web/images/mapleleaf.svg?v=1.4">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../assets/web/dependencies/bootstrap/css/bootstrap.min.css?v=1.4">
        <link rel="stylesheet" href="../assets/web/dependencies/aos/css/aos.css?v=1.4"/>
        <link rel="stylesheet" href="../assets/web/dependencies/fontawesome/css/all.css">
        <link rel="stylesheet" href="../assets/web/css/main.css?v=1.6">
        <link rel="stylesheet" href="../assets/web/css/info.css?v=1.5">

        <script src="../assets/web/dependencies/bootstrap/js/bootstrap.min.js?v=1.4"></script>
        <script src="../assets/web/dependencies/jquery/js/jquery-3.6.0.min.js?v=1.4"></script>
        <script src="../assets/web/dependencies/aos/js/aos.js?v=1.4"></script>
    </head>

    <body>
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark py-3">
            <div class="container">
                <a class="navbar-brand" href="https://maple.software">
                    <div class="d-flex align-items-center">
                        <span class="navbar-brand-logo">
                            <img src="../assets/web/images/mapleleaf.svg?v=1.4" width="30" height="30" class="d-inline-block align-top" alt="">
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
                        <li class="nav-item"><a class="nav-link" href="https://maple.software/"><i class="fa-solid fa-house"></i> Home</a></li>
                        <div class="nav-item dropdown">
                            <a href="../help" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa-solid fa-headset"></i> Help</a>
                            <div class="dropdown-menu">
                                <a href="getting-started" class="dropdown-item">Getting started</a>
                                <a href="features" class="dropdown-item">Features</a>
                                <a href="faq" class="dropdown-item">FAQ</a>
                                <a href="payment-issues" class="dropdown-item">Payment issues</a>
                                <a href="software-issues" class="dropdown-item">Software issues</a>
                                <a href="report-a-bug" class="dropdown-item">Report a bug</a>
                                <a href="suggest-a-feature" class="dropdown-item">Suggest a feature</a>
                                <a href="https://maple-software.gitbook.io/maple.software" class="dropdown-item">Maple Mega-Guide</a>
                                <a href="contact-us" class="dropdown-item">No, really, I need help!</a>
                            </div>
                        </div>
                    </ul>
                    <span class="ms-md-2">
                        <button type="button" onclick="location.href='<?= $loggedIn ? "../dashboard" : "../auth/login" ?>';" class="btn btn-primary"><?= $loggedIn ? "Dashboard" : "Log in" ?></button>
                        <button type="button" onclick="location.href='<?= $loggedIn ? "../auth/logout" : "../auth/signup" ?>';" class="btn btn-primary"><?= $loggedIn ? "Log out" : "Sign up" ?></button>
                    </span>
                </div>
            </div>
        </nav>

        <div class="full-height-container d-flex flex-column justify-content-center align-items-center text-center" data-aos="fade" data-aos-duration="1000" data-aos-once="true">
            <h1 class="fw-bold">Software issues</h1>

            <div class="info-container text-start mt-4">
                <div class="p-4">
                    <h4 class="fw-bold">MSVCP140.dll was not found</h4>
                    <p>Install <a href="https://aka.ms/vs/17/release/vc_redist.x64.exe">Visual C++ Redistributable x64</a> and <a href="https://aka.ms/vs/17/release/vc_redist.x86.exe">Visual C++ Redistributable x86</a>. Reboot and try again.</p>
                    <h4 class="fw-bold">The DLL "D3DX9_34.DLL" cannot be loaded</h4>
                    <p>Install <a href="https://www.microsoft.com/en-us/download/details.aspx?id=35">DirectX End-User Runtime</a>. Reboot and try again.</p>
                    <h4 class="fw-bold">Loader is stuck on "Loading..."</h4>
                    <p>
                        This can be caused by any of the following:
                        <ul>
                            <li>Antivirus software</li>
                            <li>Firewall</li>
                            <li>VPN</li>
                            <li>Slow internet connection</li>
                        </ul>
                    </p>
                    <h4 class="fw-bold">The game crashes on injection</h4>
                    <p>
                        <ul>
                            <li>Disable your antivirus.</li>
                            <li>Disable <b>all</b> 3rd-party overlays (e.g. <b>Discord</b>, <b>Steam</b>, <b>Overwolf</b>, <b>RivaTuner (MSI Afterburner overlay)</b>, <b>Xbox Game Bar</b>, <b>Geforce Experience overlay</b>).</li>
                            <li>Disable kernel-level anticheats if you have any installed (e.g. <b>Vanguard</b>).</li>
                            <li>Reboot and try again.</li>
                        </ul>
                    </p>
                    <h4 class="fw-bold">The menu doesnt show up after injection</h4>
                    <ul>
                        <li>Disable <b>all</b> 3rd-party overlays (e.g. <b>Discord</b>, <b>Steam</b>, <b>Overwolf</b>, <b>RivaTuner (MSI Afterburner overlay)</b>, <b>Xbox Game Bar</b>, <b>Geforce Experience overlay</b>).</li>
                        <li>Disable kernel-level anticheats if you have any installed (e.g. <b>Vanguard</b>).</li>
                        <li>Install <a href="https://www.microsoft.com/en-us/download/details.aspx?id=35">DirectX End-User Runtime</a>.</li>
                    </ul>
                    <h4 class="fw-bold">The game crashes while playing</h4>
                    <p>Disable kernel-level anticheats (e.g. <b>Vanguard</b>).</p>
                    <h4 class="fw-bold">It still doesn't work!</h4>
                    <p class="mb-0">In that case, please <a href="contact-us">contact us</a>. We'll try to help you as fast as we can!</p>
                </div>
            </div>
        </div>

        <footer class="text-center py-4">
            <div class="container">
                <div class="row row-cols-2 row-cols-lg-3">
                    <div class="col">
                        <p class="my-2">Copyright © 2024 maple.software</p>
                    </div>
                    <div class="col">
                        <ul class="list-inline my-2">
                            <li class="list-inline-item">
                                <a class="discord-icon" href="../discord"><i class="fa-brands fa-discord"></i></a>
                                <a class="youtube-icon" href="https://twitter.com/maple_software"><i class="fa-brands fa-x-twitter"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col">
                        <ul class="list-inline my-2">
                            <li class="list-inline-item"><a href="../legal/terms-of-service">Terms of Service</a></li>
                            <li class="list-inline-item"><a href="../legal/privacy-policy">Privacy Policy</a></li>
                            <li class="list-inline-item"><a href="../legal/contacts">Contacts</a></li>
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
