<?php
    session_start();

    if(!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
        header("Location: " .$_SESSION["Base"]);
        return;
    }

    function renderGameStage($stage) {
        switch ($stage) {
            case "start":
                return getGameStart();
            case "guess":
                return getGuess();
            default:
                return getGameStart();
                break;
        }
    }

    function getGameStart() {
        return "
                <div>
                    <form method=\"post\" action=\"handlehangman.php\">
                        <p>Word Length: 
                        <select name=\"WordLength\">
                            <option value=\"5\" />5</option>
                            <option value=\"6\" />6</option>
                            <option value=\"7\" />7</option>
                            <option value=\"8\" />8</option>
                        </select></p>
                        <input type=\"submit\" value=\"start game\" name=\"Start\" />
                    </form>
                </div>
        ";
    }

    function getGuess() {
        return "
            <div>
                <div>Remaining Lives:   " . $_SESSION["Lives"] . "</div>
                <div>Guessed Letters:   " . $_SESSION["WrongLettersGuessed"] . "</div>
                <div>Word:              " . $_SESSION["GuessString"] . "</div>
            <div>
            <form method=\"post\" action=\"handlehangman.php\">
                <p>Guess a Letter: <input type=\"text\" name=\"Letter\" maxlength=\"1\"/></p>
                <input type=\"submit\" value=\"Guess\"/>
            </form>
        ";
    }
?>

<!DOCTYPE html>
<html>
    <body>
        <div>
            <form action="logout.php">
                <input type="submit" value="Logout" />
            </form>
            <?php
                $stage = $_SESSION["Stage"];
                echo renderGameStage($stage);
            ?>
        </div>
    </body>
</html>