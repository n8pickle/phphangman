<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <body>
        <h1>
            You Lost!
        </h1>
        <form action="playagain.php">
            <input type="submit" value="Play Again?"/>
        </form>
        <?php
            echo "<form action=\"" . $_SESSION["Base"] . "/leaderboard.php\">
                <input type=\"submit\" value=\"Go to Leaderboard\"/>
            </form>";
        ?>
    </body>
</html>