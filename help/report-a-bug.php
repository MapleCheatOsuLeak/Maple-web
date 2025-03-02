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

        <title>Report a bug - Maple</title>
        <meta name="description" content="Found a bug in Maple? Help us improve our software by reporting the issue. Our dedicated team will work promptly to fix any issues.">
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
            <h1 class="fw-bold">Report a bug</h1>

            <div class="info-container text-start mt-4">
                <div class="p-4">
                    <h4 class="fw-bold">How can I report a bug?</h4>
                    <p>
                        You can report a bug by creating a new post in the <b>#bug-reports</b> channel on our <a href="../discord">discord server</a>.
                    </p>
                    <p>
                        When making a bug report, please use the following format:
                        <ul>
                            <li>A clear and concise description of what the bug is.</li>
                            <li>
                                Steps we can use to reproduce the bug, for example:
                                <ul>
                                    <li>Go to <b>X</b>.</li>
                                    <li>Enable <b>Y</b>.</li>
                                    <li>Do <b>Z</b>.</li>
                                    <li>etc.</li>
                                </ul>
                            </li>
                            <li>
                                Additional information. This can be a video and/or a screenshot showing the issue. You can also attach Maple, game and Event Viewer logs (we really appreciate that so please attach them if possible!). Of course, feel free to leave out any sensitive or personal information.
                            </li>
                        </ul>
                    </p>
                    <h4 class="fw-bold">How do I get Maple logs?</h4>
                    <p>
                        <ul>
                            <li>Open Maple menu.</li>
                            <li>Go to the <b>Misc</b> tab and click <b>Copy runtime log to clipboard</b> (or <b>Copy previous runtime log to clipboard</b> if the issue occurred in the previous session) button.</li>
                            <li>Create a new text file and paste the log into it.</li>
                            <li>Attach the file to your post.</li>
                        </ul>
                    </p>
                    <h4 class="fw-bold">How do I get the game logs? (osu!)</h4>
                    <p>
                        <b>Note: you should do all of this BEFORE restarting the game in case of a crash, because osu! clears log files on each launch.</b>
                        <ul>
                            <li>Launch osu!.</li>
                            <li>Go to the <b>Options</b> and click <b>Open osu! folder</b> button.</li>
                            <li>Find the <b>Logs</b> directory in the window that opens.</li>
                            <li><b>runtime.log</b> file is the log you need to include.</li>
                        </ul>
                    </p>
                    <h4 class="fw-bold">How do I get the Event Viewer logs? (osu!)</h4>
                    <ul class="m-0">
                        <li>After osu! has crashed, press <b>Win</b> + <b>R</b> to open the run box.</li>
                        <li>In the run box type <b><i>eventvwr</i></b> and press <b>Enter</b>. This will open the Event Viewer.</li>
                        <li>In Event Viewer, on the left, click <b>Windows Logs</b> and then <b>Application</b>.</li>
                        <li>On the right, click <b>Filter current log</b>.</li>
                        <li>On the filter window that opens, make sure you have the <b>Error</b> box checked and click <b>OK</b>.</li>
                        <li>Press <b>Ctrl</b> + <b>F</b> and type osu! in the find box. It will find the first crash log from osu!.</li>
                        <li>Go into the <b>Details</b> tab, expand <b>System</b> and <b>Event Data</b> by clicking on each of them.</li>
                        <li>Copy the text from there and paste it into your bug report.</li>
                    </ul>
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
