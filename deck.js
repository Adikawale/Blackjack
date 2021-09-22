deck = new Array();
suits = ["S", "D", "C", "H"];
ranks = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
playerTotal = 0;
dealerTotal = 0;
divDealerIncrement = 1;
divPlayerIncrement = 1;
document.cookie = "user_victory=false";

function shuffle(array) {
  /*
   * https://stackoverflow.com/a/12646864
   * Randomize array element order in-place.
   * Using Durstenfeld shuffle algorithm.
   */
  for (var i = array.length - 1; i > 0; i--) {
    var j = Math.floor(Math.random() * (i + 1));
    var temp = array[i];
    array[i] = array[j];
    array[j] = temp;
  }
}

function createDeck() {
  //var img = document.createElement("img");
  for (suitsIndex = 0; suitsIndex < suits.length; suitsIndex++) {
    for (ranksIndex = 0; ranksIndex < ranks.length; ranksIndex++) {
      card = {};
      card.suit = suits[suitsIndex];
      card.rank = ranks[ranksIndex];
      card.imagePath = "Cards PNG\\" + card.rank + card.suit + ".png"; 
      card.value = setValue();
      //document.getElementById(card).className += "cards";
      deck.push(card);
    }
  }
}

function setValue() {
  if (card.rank == "J" || card.rank == "Q" || card.rank == "K") {
    return 10;
  } else if (card.rank == "A" && playerTotal < 21) {
    return 11;
  } else if (card.rank == "A" && playerTotal > 21) {
    if (playerTotal > 21)
      return 1;
    else {
      /*Ace must be either 1 or 11 */
      return 10;
    }
  } else {
    return parseInt(card.rank);
  }
}

function disableButtons(str) {
  document.getElementById("hit").style.visibility = str;
  document.getElementById("stand").style.visibility = str;
  if (str == "hidden") {
    document.getElementById("retry").style.visibility = "visible";
  } else {
    document.getElementById("retry").style.visibility = "hidden";
  }
}

function checkBustPlayer() {
  if (playerTotal > 21) {
    //document.getElementById("playerSide").innerHTML += "<BR> BUST!";
    disableButtons("hidden");
    checkVictory();
    return true;
  } else {
    return false;
  }
}

function checkBustDealer() {
  if (dealerTotal > 21) {
    //document.getElementById("playerSide").innerHTML += "<BR>DEALER BUST!";
    checkVictory();
    return true;
  } else {
    return false;
  }
}

function playerHand() {
  playerCards = {};
  if (!checkBustPlayer()) {
    playerCards = deck.pop();
    playerTotal += playerCards.value;
  }
}

function setImage(img, setDiv) {
  cardImage = document.createElement("img");
  cardImage.src = img;
  document.getElementById(setDiv).appendChild(cardImage);

}

function playerTurn() {
  playerHand();
  divPlayer = "playerSide" + divPlayerIncrement;
  setImage(playerCards.imagePath, divPlayer);
  /*document.getElementById(divPlayer).innerHTML += "<BR>";
  document.getElementById(divPlayer).innerHTML += playerCards.rank + playerCards.suit;*/
  document.getElementById('total').innerHTML = " Total : " + playerTotal;
  divPlayerIncrement++;
  checkBustPlayer();
}

function playerStand() {
  disableButtons("hidden");
  while (dealerTotal < 17) {
    dealerTurn();
  }
  checkVictory();
}

function dealerHand() {
  dealerCards = {};
  if (!checkBustDealer()) {
    dealerCards = deck.pop();
    dealerTotal += dealerCards.value;
    console.log(dealerCards.suit);
  }
}

function dealerTurn() {
  dealerHand();
  divDealer = "dealerSide" + divDealerIncrement;
  setImage(dealerCards.imagePath, divDealer);
  /*document.getElementById(divDealer).innerHTML += "<BR>";
  document.getElementById(divDealer).innerHTML += dealerCards.rank + dealerCards.suit;*/
  //document.getElementById(divDealer).innerHTML += " Total : " + dealerTotal;
  divDealerIncrement++;
  checkBustDealer();
}

function checkVictory() {
  if (playerTotal > 21) {
    document.getElementById("victory_label").innerHTML = "Dealer wins!";
  } else if (dealerTotal > 21) {
    document.cookie = "user_victory=true";
    document.getElementById("victory_label").innerHTML = "Player wins!";
  } else if (playerTotal > dealerTotal && (!checkBustPlayer())) {
    document.cookie = "user_victory=true";
    document.getElementById("victory_label").innerHTML = "Player wins!";
  } else if (dealerTotal > playerTotal && (!checkBustDealer())) {
    document.cookie = "user_victory=false";
    document.getElementById("victory_label").innerHTML = "Dealer wins!";
  } else if (playerTotal == dealerTotal) {
    document.getElementById("victory_label").innerHTML = "PUSH!";
    //Game resets -> Deal beings again with previous money added to total
  }
}

function startGame() {
  disableButtons("visible");
  document.getElementsByClassName('bets').visibility = "hidden";
  createDeck();
  shuffle(deck);
  dealerTurn();
  playerTurn();
  dealerTurn();
  playerTurn();
}