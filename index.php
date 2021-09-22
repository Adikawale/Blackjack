<html>

<head>
    <title>Blackjack</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Scale window according to device-->
    <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>">
    <script src='deck.js' type='text/javascript'></script>
</head>

<body>
    <script>
        document.cookie = "new_money=0";
    </script>

    <?php
    session_start();
    $connect = mysqli_connect("localhost", "root", "", "blackjackUD"); # connection to db
    //$_SESSION = []; //Form reset debug
    ?>

    <header class="nav_bar">
        <img class="logo" src="Webphotos\logo2.png">
        <nav class="navbar">
            <ul class="nav_links">
                <li class="home"><a href="#game_section">GAME</a></li>
                <li class="tutorial"><a href="#section_rules">RULES</a></li>
                <li class="about"><a href="#section_about">SHARE</a></li>
            </ul>
        </nav>
        <?php
        if (isset($_SESSION['username'])) {
            echo "<a class='cta' href='database\\logout.php'><button class='login' style='width:auto'>";
            echo "LOGOUT";
        } else {
            echo "<a class='cta'><button class='login' onclick=\"document.getElementById('id01').style.display='block'\" style='width:auto' id='login'>";
            echo "Login";
        }
        ?>
        </button></a>

    </header>
    <div class="game_space" id="game_section">
        <div class="game_part">
            <?php
            if (isset($_SESSION['username'])) {
                echo "<button onclick=\"this.style.visibility='hidden'; startGame()\" id='game' class='play'>PLAY</Button>";
                echo "            <div>\n";
                echo "                <label class='bets_label' id='bets_label'></label>\n";
                echo "            </div>\n";
                echo "            <div class=\"bets_area\">\n";
                echo "                <button onclick=addMoney(100) class='bets'>100</button>\n";
                echo "                <button onclick=addMoney(500) class='bets'>500</button>\n";
                echo "                <button onclick=addMoney(1000) class='bets'>1000</button>\n";
                echo "            </div>\n";
                echo "            <!--<div class=\"bets_area_remove\">\n";
                echo "                <button onclick=addMoney(-100) class='bets'>-100</button>\n";
                echo "                <button onclick=addMoney(-500) class='bets'>-500</button>\n";
                echo "                <button onclick=addMoney(-1000) class='bets'>-1000</button>\n";
                echo "            </div>-->\n";
                echo "            <!--Money isn't additive, fix later-->\n";
                echo "            <script>\n";
                echo "                function addMoney(money) {\n";
                echo "                    current_money = document.getElementById('bets_label').innerHTML;\n";
                echo "                    document.getElementById('bets_label').innerHTML = '0';\n";
                echo "                    document.getElementById('bets_label').innerHTML = 'You bet ' + money;\n";
                echo "                    document.cookie = \"new_money=\" + money + \";\";\n";
                //echo "                    alert(document.cookie);\n";
                echo "                }\n";
                echo "            </script>";
            } else {
                echo "<button id='game' class='play'>LOGIN TO PLAY!</Button>";
            }
            ?>
            <label id='victory_label' class='victory_label'></label>

            <?php
            if (isset($_SESSION['username'])) {
                $new_money = 0;
                $new_money = $_COOKIE['new_money'];
                $name = $_SESSION['username'];
                $check_money = "SELECT money from user_details WHERE user_name = '$name'";
                $add_money = "UPDATE user_details SET money = money  + '$new_money' + '$new_money' WHERE user_name = '$name'";
                $remove_money = "UPDATE user_details SET money = money - '$new_money' WHERE user_name = '$name'";
                $current_money = mysqli_query($connect, $check_money);
                $result = mysqli_query($connect, $check_money);
                $row = mysqli_fetch_row($result);
                if ($row[0] > $new_money) {
                    mysqli_query($connect, $remove_money);
                    setcookie('new_money', '0', time() + 60, '/');
                } else {
                    //echo "<script> alert('You don't have enough money for that bet!'); </script>";
                }
                $user_victory = $_COOKIE['user_victory'];
                if ($user_victory == "true") {
                    mysqli_query($connect, $add_money);
                    setcookie('new_money', '0', time() + 60, '/');
                }
            }
            ?>
            <div>
                <div id=dealerSide1 class="dCards"> </div>
                <div id=dealerSide2 class="dCards"> </div>
                <div id=dealerSide3 class="dCards"> </div>
                <div id=dealerSide4 class="dCards"> </div>
                <div id=dealerSide5 class="dCards"> </div>
                <div id=dealerSide6 class="dCards"> </div>
            </div>

            <button onclick="playerTurn()" id="hit" value="HIT" class="action">HIT</button>
            <button onclick="playerStand()" id="stand" value="STAND" class="action">STAND</button>
            <button onclick="location.reload();" id="retry" value="RETRY" class="action">PLAY AGAIN</button>

            <div>
                <div id=playerSide1 class="pCards"> </div>
                <div id=playerSide2 class="pCards"> </div>
                <div id=playerSide3 class="pCards"> </div>
                <div id=playerSide4 class="pCards"> </div>
                <div id=playerSide5 class="pCards"> </div>
                <div id=playerSide6 class="pCards"> </div>
            </div>

            <div class='total' id='total'>
            </div>

        </div>
    </div>
    <div class="rule_nav">
        <span class="rulesnav ,position2, rborder">
            <ul>
                <a onclick="document.getElementById('id03').style.display='block'" style="width:auto" class="rkeys">
                    <li>Cards </li>
                </a> <br>
                <a onclick="document.getElementById('id04').style.display='block'" style="width:auto" class="rkeys">
                    <li>Hitting </li>
                </a> <br>
                <a onclick="document.getElementById('id05').style.display='block'" style="width:auto" class="rkeys">
                    <li>standing </li>
                </a> <br>
                <a onclick="document.getElementById('id06').style.display='block'" style="width:auto" class="rkeys">
                    <li>surrender</li>
                </a> <br>
            </ul>
        </span>
        <span class="rules" id="section_rules">
            <h3>THE BASIC RULES WHEN PLAYING BLACKJACK:</h3>
            <p> </p>
            <ol>
                <li>
                    <p>Blackjack starts with players making bets.</p>
                </li>
                <li>
                    <p>Dealer deals 2 cards to the players and two to himself.
                    </p>
                </li>
                <li>
                    <p>Blackjack card values: All cards count their face value in blackjack. Picture cards count as
                        10 and <br> the acecan count as either 1 or 11. Card suits have no meaning in blackjack. The
                        total of any hand <br>is the sum of the card values in the hand</p>
                </li>
                <li>
                    <p>Players must decide whether to stand or hit.</p>
                </li>
                <li>
                    <p>The dealer acts last and must hit on 16 or less and stand on 17 through 21.</p>
                </li>
                <li>
                    <p>Players win when their hand total's higher than dealer's hand, or they have 21 or less when
                        <br> the dealer busts &nbsp; (i.e., exceeds 21). <br>
                    </p>
                </li>
            </ol>
        </span>
        </section>
    </div>

    <?php
    if (isset($_SESSION['username'])) {
        echo "<form onclick='database\\logout.php' method='POST'>";
        echo "</form>";
    } else {
        echo "<div id='id01' class='modal'>";
        echo "    <form class='model-content' action='database\\validate.php' method='POST'>";
        echo "        <div class='close-sign'>";
        echo "            <span onclick=\"document.getElementById('id01').style.display='none'\" title='Close Modal' class='close'>
                    &times";
        echo "            </span> </div>";
        echo "      <br><br><br><br><br><br><br><br>";
        echo "           <label for='uname'> Username</label><br>";
        echo "            <input input type='text' name='nm' required='required' placeholder='Enter Username'><br><br>";
        echo "            <label for='password'> Password</label><br>";
        echo "           <input input type='password' name='userpassword' id='pass' required
                    placeholder='Enter your password'><br>";


        echo "            <button input type='submit' value=Login name='Login' class='loginbtn'> Login </button>";
        echo "            <p class='regi-position' onclick=\"document.getElementById('id02').style.display='block'\";>Sign up here!<p>";
        echo "        </div>";

        echo "     </form>";
        echo "</div>";
    } ?>
    <div id="id02" class="modal">
        <form class="model-content" action="database\register.php" method="POST">
            <div class="close-sign">
                <span onclick="document.getElementById('id02').style.display='none'" title="Close Modal" class="logclose">
                    &times;
                </span>
            </div>
            <div>
                <br><br><br><br><br><br><br><br>
                <label for="nm"> Username</label><br>
                <input type="text" name="nm" required><br>
                <label for="address">E-Mail</label><br>
                <input type="text" name="address" required><br>
                <label for="password"> Password</label><br>
                <input type="password" name="userpassword" id="pass" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title='Your password must contain at least one uppercase or lowercase letter, 1 number and a minimum of 6 characters'><br>
                <!--<label for="password"> Password</label><br>
                <input type="password" placeholder="Enter your password" name="password" required><br><br>  -->
            </div>
            <button type="submit" class="loginbtn"> Register </button>
        </form>
    </div>

    <div id="id03" class="cards-rules">
        <div class="cards-rules-content">
            <div class="close-sign">
                <span onclick="document.getElementById('id03').style.display='none'" title="Close Modal" class="close">
                    &times;
                </span>
                <h1 class="cardhead"> Card Rules</h1>
                <img src="WebPhotos\card-value.png" alt="card_value" class="rules_img">
                <span class="content">
                    All cards count their face value in blackjack. Picture cards count as 10 and the ace can count as either
                    1 or 11.
                    Card suits have no meaning in blackjack. The total of any hand is the sum of the card values in the
                    hand. A hand
                    containing a 4-5-8 totals 17. Another containing a queen-5 totals 15. It is always assumed that the ace
                    counts as
                    11 unless so doing would make your hand total exceed 21, in which case the ace reverts to a value of 1.
                </span>
            </div>
        </div>
    </div>

    <div id="id04" class="cards-rules">
        <div class="cards-rules-content">
            <div class="close-sign">
                <span onclick="document.getElementById('id04').style.display='none'" title="Close Modal" class="close">
                    &times;
                </span>
                <h1 class="cardhead"> Hitting Rules</h1>
                <img src="WebPhotos\Hit.png" alt="card_value" class="rules_img">
                <span class="content">
                    This means you want the dealer to give another card to your hand. In shoe games, indicate to the dealer
                    that you want a hit by making a beckoning motion with your finger or tapping the table behind your cards
                    with your finger. In hand-held games, scratch the edges of the cards in your hand lightly on the felt
                </span>
            </div>
        </div>
    </div>

    <div id="id05" class="cards-rules">
        <div class="cards-rules-content">
            <div class="close-sign">
                <span onclick="document.getElementById('id05').style.display='none'" title="Close Modal" class="close">
                    &times;
                </span>
                <h1 class="cardhead"> Standing Rules</h1>
                <img src="WebPhotos\Stand.png" alt="card_value" class="rules_img">
                <span class="content">
                    This means you are satisfied with the total of the hand and want to stand with the cards you have. In
                    shoe games, indicate that you want to stand by waving your hand over the cards, palm down. In hand-held
                    games, tuck your cards under the chips that you have in the betting box.

                </span>
            </div>
        </div>
    </div>

    <div id="id06" class="cards-rules">
        <div class="cards-rules-content">
            <div class="close-sign">
                <span onclick="document.getElementById('id06').style.display='none'" title="Close Modal" class="close">
                    &times;
                </span>
                <h1 class="cardhead"> Surrender</h1>
                <img src="WebPhotos\Surrender.png" alt="card_value" class="rules_img">
                <span class="content">
                    This playing option is sometimes permitted. It allows a player to forfeit the hand immediately with an
                    automatic loss of half the original bet. In most venues, players can surrender their initial two-card
                    hand only after the dealer has checked his cards and ascertained that he doesn’t have a blackjack (known
                    as late surrender). Once a player draws a card, the surrender option is no longer available. If the
                    dealer has a blackjack hand, then surrender is not available.
                </span>
            </div>
        </div>
    </div>
    <footer id="section_about" class="foot">
        <!--<p style="color: white; font-size: 36px">&nbsp; Contact information:</p>
        &nbsp;&nbsp;&nbsp; <a href="mailto:kanishkkargutkar123@gmail.com" class="footer-a">&nbsp; kanishkkargutkar123@gmail.com</a> 
        &nbsp; <a href="mailto:marathegaurav364@gmail.com" class="footer-a">marathegaurav364@gmail.com</a>
        &nbsp; <a href="mailto:kawaleaditya870@gmail.com" class="footer-a">kawaleaditya870@gmail.com</a> 
        &nbsp; <a href="mailto:mishradhruv072@gmail.com" class="footer-a">mishradhruv072@gmail.com</a> 
        <p></p> -->
        <br>
        <p class="share">Share </p>
        <div>
            <span class="share_icon">

                <a padding-left: 7px; href="https://www.facebook.com/"><img src="Webphotos\fbwhite.png" alt="facebook"></a> &nbsp
                <a padding-left: 7px; href="https://www.instagram.com/"><img src="Webphotos\insta1.png" alt="insta"></a> &nbsp
                <a padding-left: 7px; href="https://twitter.com/?lang=en"><img src="Webphotos\t2.png" alt="tweet"></a> &nbsp
                <a padding-left: 7px; href="https://www.whatsapp.com/\"><img src="Webphotos\whatsApp1.png" alt="Whatsapp"></a> &nbsp
            </span>
    </footer>
    <script>
        var modal1 = document.getElementById('id01');
        var modal2 = document.getElementById('id02');
        var modal3 = document.getElementById('id03');
        var modal4 = document.getElementById('id04');
        var modal5 = document.getElementById('id05');
        var modal6 = document.getElementById('id06');
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal1) {
                modal1.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == modal2) {
                    modal2.style.display = "none";
                }
                window.onclick = function(event) {
                    if (event.target == modal3) {
                        modal3.style.display = "none";
                    }
                    window.onclick = function(event) {
                        if (event.target == modal4) {
                            modal4.style.display = "none";
                        }
                        window.onclick = function(event) {
                            if (event.target == modal5) {
                                modal5.style.display = "none";
                            }
                            window.onclick = function(event) {
                                if (event.target == modal6) {
                                    modal6.style.display = "none";
                                }
                            }
                        }
                    }
                }
            }
        }
    </script>
</body>

</html>