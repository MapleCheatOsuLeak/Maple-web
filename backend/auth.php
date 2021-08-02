<?php
    define('INVALID_REQUEST', -1);
    define('SUCCESS', 0);
    define('INVALID_CREDENTIALS', 1);
    define('HWID_MISMATCH', 2);
    define('USER_BANNED', 3);
    define('INVALID_SESSION', 4);

    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (isset($useragent))
        if ($useragent != "mapleserver/azuki is a cutie")
            dieFake();

    require_once "../backend/Database/databaseHandler.php";
    require_once "../backend/Sessions/sessionHandler.php";

    if (isset($_POST["t"])) //request type
    {
        switch ($_POST["t"])
        {
            case 0: //login
                if (isset($_POST["h"]) && isset($_POST["u"]) && isset($_POST["p"])) //hwid, username and password
                {
                    $user = getUserByName($dbConn, $_POST["u"]);
                    if ($user == null || !password_verify($_POST["p"], $user["Password"]))
                        constructResponse(INVALID_CREDENTIALS);

                    if ($user["HWID"] == null)
                        setHWID($dbConn, $user["ID"], $_POST["h"]);
                    else if ($user["HWID"] != $_POST["h"])
                        constructResponse(HWID_MISMATCH);
                    else if ($user["Permissions"] & perm_banned)
                        constructResponse(USER_BANNED);

                    $sessionID = createCheatSession($dbConn, $user["ID"]);

                    $games = array();
                    foreach(getAllGames($dbConn) as $game)
                    {
                        $games[] = array(
                            'ID' => $game[0],
                            'Name' => $game[1],
                            'ModuleName' => $game[2]
                        );
                    }

                    $cheats = array();
                    foreach(getAllCheats($dbConn) as $cheat)
                    {
                        $cheats[] = array(
                            'ID' => $cheat[0],
                            'GameID' => $cheat[1],
                            'Name' => $cheat[2],
                            'Price' => $cheat[3],
                            'Status' => $cheat[4],
                            'Features' => $cheat[5],
                            'ExpiresAt' => getSubscriptionExpiry($dbConn, $user["ID"], $cheat[0])
                        );
                    }

                    constructResponse(SUCCESS, array(
                        'sessionID' => $sessionID,
                        'games' => $games,
                        'cheats' => $cheats
                        )
                    );
                }

                break;
            case 1: //heartbeat
                if (isset($_POST["s"])) //session
                {
                    $session = getCheatSession($dbConn, $_POST["s"]);
                    if ($session != null)
                    {
                        setCheatSessionExpiry($dbConn, $session["SessionID"], date('Y-m-d H:i:s', strtotime($session["ExpiresAt"]. ' + 20 minutes')));
                        setCheatSessionLastHeartbeat($dbConn, $session["SessionID"], gmdate('Y-m-d H:i:s'));
                        constructResponse(SUCCESS);
                    }

                    constructResponse(INVALID_SESSION);
                }
                break;
        }
    }

    constructResponse(INVALID_REQUEST);

    function dieFake()
    {
        die("<!DOCTYPE HTML PUBLIC '-//IETF//DTD HTML 2.0//EN'><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p></body></html>");
    }

    function constructResponse($code, $params = array())
    {
        $response = array('code' => $code);
        $response = array_merge($response, $params);

        echo json_encode($response);
        die();
    }
?>