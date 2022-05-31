<?php
    require("database.php");
    session_start();
?>

<!DOCTYPE html>
<html>
    <body>
        <h1>This is the Leaderboard!</h1> 
        <!--leaderboard stuffz-->
        <table>
            <tr>
                <td>Username</td>
                <td>Guesses</td>
                <td>Lives Left</td>
            </tr>
            <?php
                $leaderboardQuery = "SELECT username, guesses, lives_left FROM Leaderboard WHERE word_length = " . $_SESSION["WordLength"] . " order by lives_left desc, guesses asc LIMIT 10";
                $conn = get_connection();

                $result = $conn->query($leaderboardQuery);
                while($row = $result->fetch_assoc()) {
                    $leaderboard = $leaderboard . "<tr>
                        <td>" . $row["username"] . "</td>
                        <td>" . $row["guesses"] . "</td>
                        <td>" . $row["lives_left"] . "</td>
                    </tr>";
                }

                echo $leaderboard;
            ?>
        </table>
        <form action="playagain.php" method="post">
            <input type="submit" value="Play Again?"/>
        </form>
    </body>
</html>