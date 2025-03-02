<?php
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (isset($useragent))
        if ($useragent != "mapleserver/azuki is a cutie")
            dieFake();

    define("REQUEST_TYPE_USER_INFO", 0);
    define("REQUEST_TYPE_SUBSCRIBERS", 1);
    define("REQUEST_TYPE_ANTICHEAT_INFO", 2);
    define("REQUEST_TYPE_STATUS", 3);
    define("REQUEST_TYPE_PRODUCTS", 4);

    define('INVALID_REQUEST', -1);
    define('SUCCESS', 0);
    define('USER_NOT_FOUND', 1);

    require_once "../database/usersDatabase.php";
    require_once "../database/subscriptionsDatabase.php";
    require_once "../database/productsDatabase.php";
    require_once "../database/gamesDatabase.php";
    require_once "../database/cheatsDatabase.php";
    require_once "../database/sessionsDatabase.php";
    require_once "../datetime/datetimeUtilities.php";

    if (isset($_GET["t"]))
    {
        switch ($_GET["t"])
        {
            case REQUEST_TYPE_USER_INFO:
                if (isset($_GET["u"]))
                {
                    $user = GetUserByDiscordID($_GET["u"]);
                    if ($user != null)
                    {
                        $subscriptions = array();
                        foreach (GetAllUserSubscriptions($user["ID"]) as $subscription)
                        {
                            $cheat = GetCheatByID($subscription["CheatID"]);
                            $game = GetGameByID($cheat["GameID"]);
                            $subscriptions[] = array(
                                "Name" => ($cheat["Name"] == NULL ? "unknown cheat" : $cheat["Name"])." for ".($game["Name"] == NULL ? "unknown game" : $game["Name"]),
                                "Expiration" => GetHumanReadableSubscriptionExpiration($subscription["ExpiresOn"]),
                                "ExpirationUnix" => strtotime($subscription["ExpiresOn"])
                            );
                        }

                        constructResponse(SUCCESS, array(
                            "UserID" => $user["ID"],
                            "JoinedOn" => GetHumanReadableDate($user["CreatedAt"]),
                            "Subscriptions" => $subscriptions
                        ));
                    }

                    constructResponse(USER_NOT_FOUND);
                }

                break;
            case REQUEST_TYPE_SUBSCRIBERS:
                $subscribers = array();
                foreach (GetAllSubscriptions() as $subscription)
                {
                    $user = GetUserByID($subscription["UserID"]);
                    if ($user != null && $user["DiscordID"] != null && !in_array($user["DiscordID"], $subscribers))
                        $subscribers[] = $user["DiscordID"];
                }

                constructResponse(SUCCESS, array(
                    "Subscribers" => $subscribers
                ));

                break;
            case REQUEST_TYPE_ANTICHEAT_INFO:
                $anticheats = array();
                foreach (GetAllGames() as $game)
                {
                    $anticheats[] = array(
                        "GameName" => $game["Name"] == NULL ? "unknown game" : $game["Name"],
                        "AnticheatChecksum" => $game["AnticheatFileChecksum"]
                    );
                }

                constructResponse(SUCCESS, array(
                    "Anticheats" => $anticheats
                ));
                break;
            case REQUEST_TYPE_STATUS:
                $statuses = array();
                foreach (GetAllCheats() as $cheat)
                {
                    $game = GetGameByID($cheat["ID"]);
                    $statuses[] = array(
                        "Name" => ($cheat["Name"] == NULL ? "unknown cheat" : $cheat["Name"])." for ".($game["Name"] == NULL ? "unknown game" : $game["Name"]),
                        "Status" => $cheat["Status"]
                    );
                }

                constructResponse(SUCCESS, array(
                    "OnlineCount" => count(GetAllCheatSessions()),
                    "Statuses" => $statuses
                ));
                
                break;
            case REQUEST_TYPE_PRODUCTS:
                $products = array();
                foreach (GetAllCheats() as $cheat)
                {
                    $prices = array();
                    foreach (GetProductsByCheatID($cheat["ID"]) as $product)
                    {
                        $prices[] = array(
                            "Duration" => $product["Name"],
                            "Price" => $product["Price"],
                            "IsAvailable" => $product["IsAvailable"]
                        );
                    }

                    $game = GetGameByID($cheat["ID"]);
                    $products[] = array(
                        "Name" => ($cheat["Name"] == NULL ? "unknown cheat" : $cheat["Name"])." for ".($game["Name"] == NULL ? "unknown game" : $game["Name"]),
                        "Prices" => $prices
                    );
                }

                constructResponse(SUCCESS, array(
                    "Products" => $products
                ));

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