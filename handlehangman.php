<?php
    require("database.php");
    session_start();
    $hangmanLocation = "Location: " . $_SESSION["Base"] . "/hangman.php";

    if(isset($_SESSION["Stage"]) && $_SESSION["Stage"] === "guess") {
        if(!isset($_POST["Letter"])) {
            $_SESSION["Error"] = "There was no letter guessed";
        }
        $_SESSION["Guesses"] = $_SESSION["Guesses"] + 1;
        $explodedWord = str_split($_SESSION["FinalWord"]);
        if(in_array($_POST["Letter"], $explodedWord)) {
            $_SESSION["GuessString"] = getGuessString($explodedWord, $_POST["Letter"]);
            if(checkIfUserWon($explodedWord, explode(" ", $_SESSION["GuessString"]))) {
                addUserToLeaderboard();
                header("Location: " . $_SESSION["Base"] . "/leaderboard.php");
                return;
            }
        } else {
            $_SESSION["WrongLettersGuessed"] = $_SESSION["WrongLettersGuessed"] . " " . $_POST["Letter"];
            $_SESSION["Lives"] = $_SESSION["Lives"] - 1;
            if($_SESSION["Lives"] === 0) {
                header("Location: " . $_SESSION["Base"] . "/lost.php");
                return;
            }
        }
        header($hangmanLocation);
    } else {
        $_SESSION["WordLength"] = $_POST["WordLength"];
        $_SESSION["FinalWord"] = getWord($_SESSION["WordLength"]);
        $_SESSION["GuessString"] = getGuessStringFromWord($_SESSION["FinalWord"]);
        $_SESSION["Lives"] = 12;
        $_SESSION["Stage"] = "guess";
        $_SESSION["Guesses"] = 0;

        header($hangmanLocation);
    }


    function getGuessString($finalWord, $letter) {
        $space = "";
        $finalString = "";
        $explodedGuesses = explode(" ", $_SESSION["GuessString"]);
        for ($i = 0; $i < count($finalWord); $i++) {
            if($finalWord[$i] === $letter) {
                $finalString = $finalString . $space . $letter;
            } else {
                $finalString = $finalString . $space . $explodedGuesses[$i];
            }
            $space = " ";
        }
        return $finalString;
    }

    function checkIfUserWon($finalWord, $guessString) {
        for ($i = 0; $i < count($finalWord); $i++) {
            if($finalWord[$i] !== $guessString[$i]) {
                return FALSE;
            }
        }
        return TRUE;
    }

    function getWord($wordLength) {
        $getWordQuery = "SELECT word FROM Words WHERE length = ". $wordLength . " ORDER BY RAND() LIMIT 1";
        $conn = get_connection();
        $result = $conn->query($getWordQuery);
        $row = $result->fetch_assoc();
        return $row["word"];
    }

    function getGuessStringFromWord($finalWord) {
        $result = "";
        $space = "";
        for ($i = 0; $i < strlen($finalWord); $i++) {
            $result = $result . $space . "_";
            $space = " ";
        }
        return $result;
    }

    function addUserToLeaderboard() {
        $addUser = "INSERT INTO Leaderboard (username, guesses, lives_left, word_length) VALUES(\"" . $_SESSION["Username"] . "\", \"" . $_SESSION["Guesses"] . "\", \"" . $_SESSION["Lives"] . "\", \"" . $_SESSION["WordLength"] . "\")";
        $conn = get_connection();
        $result = $conn->query($addUser);
        if($result->rows_affected > 0) {
            return;
        } else {
            echo "there was an issue with submitting your score";
        }
    }

?>