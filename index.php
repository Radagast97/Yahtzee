
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homework 03 inde</title>
    <meta name="author" content="Glenn Murray">
    <meta http-equiv="Content-Type"
      content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="signup.css"/>
</head>
<body>

  <header class="center">
     <div class="center">
        <h1>Testbed</h1>
   </div>
  </header>
<div class="center">

  <section id="boxed" class="centered">
<p> top of page</p>

<?php


///////////////
//
//  Class Dice
//
//   Encompasses the data and actions of a single Die.
//
//     Creation: GEM 7/7/2022
//
class Dice {

    var $locked = FALSE;
    var $value;

    function __construct() {
        $this->locked = FALSE;
        $this->value = rand(1,6);
        
    }

    // Sets the value of die to a random integer between 1 and 6
    //   roll is inhibited if die is locked
    //
    function roll() {
        $lock = $this->locked;
        if (!lock) {
            $this->value = rand(1,6);
        }
    }

    // Returns integer value of die
    //
    function getValue() {
       return $this->value;
    }

    // Returns boolean value of if die is locked
    //
    function isLocked() {
        return $this->locked;
    }

    // Locks the die
    //
    function lock() {
       $this->locked = TRUE;
    }

    //Unlocks the die
    //
    function unlock() {
       $this->locked = FALSE;
    }

}


///////////////
//
//  Class DiceCup
//
//   Encompasses the data and actions of a set of Dice.
//     The indexing of dice is zero to the dicecount
//     Creation:       GEM 7/7/2022
//     Modifications:  GEM 7/8/2022   pulled out complex data structures
//
class DiceCup {

    var $num_dice;

    // DiceCup Constructor
    //
    //   Initializes data and structures 
    //   Parameters - $numberofDice - the number of dice in cup
    // 
    // 
    function __construct($numberofDice) {
        global $diceArr;        // an array to hold the dice
        global $diceCuplocked;  // an array to hold the dice

        $diceArr = array();
        $diceCuplocked = array();
        $this->num_dice = $numberofDice;
        for ($n = 0; $n<$this->num_dice; $n++) {
           $diceArr[$n] = rand(1,6);
           $diceCuplocked[$n] = FALSE;
        }
    }


    function diceCount() {
        return $this->num_dice;
    }

    // rollDice
    //
    //   rolls all unlocked dice
    //
    function rollDice() {
        global $diceArr;
        global $diceCuplocked;

        for ($n = 0; $n<$this->num_dice; $n++) {
            if (!$diceCuplocked[$n]) { 
                $diceArr[$n] = rand(1,6);
            }
        }
    }

    function setDieVal($ndx,$val) {
       global $diceArr;

       $diceArr[$ndx] = $val;
    } 

//    function getDieVal($ndx) {
//       global $diceArr;

//       $val = $diceArr[$ndx];
//       return $val;
//    } 

    // countofValue
    //   returns how many dice are of the parameter value
    //
    function countofValue($value) {
        global $diceArr;

        $val = 0;
        for ($n=0; $n< $this->num_dice; $n++) {
            //echo "checking $n for val $value : which has value $diceArr[$n]<br>";
	        if ($value == $diceArr[$n]) {
                    $val++;
            }
        }
        return $val;
    }

    // printDice
    //   Prints all dice to page
    //
    function printDice() {
        global $diceArr;

        for ($n=0; $n< $this->num_dice; $n++) {
            $d = $diceArr[$n];
            //$d->getValue(); 
            $val = $n+1;
            echo "Die: $val value $d  <br>"; 
        }
    }
}



///////////////
//
//  Class ScoreBoard
//
//   Encompasses the data and actions of the scoreboard.
//     
//     Creation: GEM 7/7/2022
//     Modified: GEM 7/8/2022  Removed non-scalar variables to external
//               GEM 7/8/2022  Added chooseEntry function
//
class ScoreBoard {

    // Index values
    const THREEKIND = 6;
    const FOURKIND = 7;
    const FULLH = 8;
    const SHORTSTRT = 9;
    const STRT = 10;
    const YAHTZEE = 11;
    const CHANCE = 12;

    const VALCNT = 13;

    // ScoreBoard Constructor
    //
    //   Initializes Scoreboard data and structures 
    //   Parameters - none
    // 
    function __construct($numDice) {
        global $values;      // Values of dice
        global $points;      // Points to be earned by this roll of dice
        global $valUnlocked; // if this value has been used (so locked)
        global $diceCup;     // Cup of dice
        global $labels;      // Text labels for each cell in table
        
        // Corrosponding external scoreboard values
        global $prvalues;      // Values of dice
        global $prpoints;      // Points chosen from a turn

        // Initialize
        $values = array(); 
        $points = array(); 
        $valUnlocked = array();
        $diceCup = new DiceCup($numDice);
        $labels = array();
        $this->clearboard();

        // debug Straight testing
        //for($n=0;$n<$numDice;$n++) {
        //   if ($n != 3) { $diceCup->setDieVal($n, $n+1); }
        //}
       
        // Set label array
        for ($n=0; $n<self::VALCNT; $n++) {
            if ($n < 6) {
	            $labels[$n] = strval($n+1);
            }
	        else {
	            switch ($n) {
                    case self::THREEKIND:
                        $labels[$n] = "Three of a kind";
                        break;
                    case self::FOURKIND:
                        $labels[$n] = "Four of a kind";
                        break;
                    case self::FULLH:
                        $labels[$n] = "Full House";
                        break;
                    case self::SHORTSTRT:
                        $labels[$n] = "Short Straight";
                        break;
                    case self::STRT:
                        $labels[$n] = "Straight";
                        break;
                    case self::YAHTZEE:
                        $labels[$n] = "Yahtzee";
                        break;
                    case self::CHANCE:
                        $labels[$n] = "Chance";
                        break;
                    default:
                        $labels[$n] = "Unknown";
                        break;
	            }
	        }
        }       
    }

    // clearBoard
    //    zeros all values
    // 
    function clearboard() {
       global $values;
       global $points;
       global $valUnlocked;
       
       for ($n=0; $n<self::VALCNT; $n++) {
           if ($n < 6) {
	         $values[$n] = 0;
           }
	       else {$values[$n] = FALSE; }

	       $valUnlocked[$n] = TRUE;
           $points[$n] = 0;
        }
    }
    
    // printBoard() {
    //    print all values
    // 
    function printboard() {

        global $values;      // Values of dice
        global $points;      // Points to be earned by this roll of dice
        global $valUnlocked; // if this value has been used (so locked)
        global $diceCup;     // Cup of dice
        global $labels;

        $diceCup->printDice();

        for ($n=0; $n<self::VALCNT; $n++) {
            if ($n < 6 ) {
                $cval = "dice cnt $values[$n]";
            }
            else {
                $cval = "";
            }
            echo "$labels[$n]  &emsp;  $cval  pnts $points[$n]  <br>";
        }
    }

    // chooseEntry
    //   This allows choice of an value in table. No action will occur
    //  if entry is locked. Choice of this entry will return the points of 
    //  that choice and result in the locking of that entry for this game
    //  and moving of the values the the external value tables
    //
    function chooseEntry($choice) {
        global $values;      // Values of dice
        global $points;      // Points to be earned by this roll of dice
        global $valUnlocked; // if this value has been used (so locked)
        
        // Corrosponding external scoreboard values
        global $prvalues;      // Values of dice
        global $prpoints;      // Points chosen from a turn
        
        switch ($choice) {
            case "One":
                $ndx = 0;
                break;
            case "Two":
                $ndx = 1;
                break;
            case "Three":
                $ndx = 2;
                break;
            case "Four":
                $ndx = 3;
                break;
            case "Five":
                $ndx = 4;
                break;
            case "Six":
                $ndx = 5;
                break;
            case "ThreeOfAKind":                  
                $ndx = self::THREEKIND;
                break;
            case "FourOfAKind":                  
                $ndx = self::FOURKIND;
                break;
            case "FullHouse":                  
                $ndx = self::FULLH;
                break;
            case "ShortStraight":                  
                $ndx = self::SHORTSTRT;
                break;
            case "Straight":                  
                $ndx = self::STRT;
                break;
            case "Yahtzee":                  
                $ndx = self::YAHTZEE;
                break;
            case "Chance":                  
                $ndx = self::CHANCE;
                break;
            default:
                echo "Error: $choice incorrect type<br>";
                return 0;
	    }
        
        $valUnlocked[$ndx] = FALSE;
        $prpoints[$ndx] = $points[$ndx];
        
        return $points[$ndx];
        
    }

    // updateBoard
    //    This updates the internal scoreboard
    //    based on the most recent roll (values in dicecup param). 
    //
    function updateBoard() {
       global $values;
       global $points;
       global $valUnlocked;
       global $diceCup;     // Cup of dice
       
       $fourkind = FALSE;
       $threekind = FALSE;
       $yahtzee = FALSE;
       $fh = FALSE;
       $strt = FALSE;
       $sstrt = FALSE;
       

       // Update the counts of dice/values
       for ($n=0; $n<6; $n++) {
           $dieval = $n+1;
	       $val = $diceCup->countofValue($dieval);
           $values[$n] = $val;
           $points[$n] = $val*$dieval;
	       if ($val >= 3) {
	           $threekind = TRUE;
               if ($val >= 4) {
                  $fourkind = TRUE;          
  	              if ($val >= 5 ) {
	                  $yahtzee = TRUE;
	                  $points[self::YAHTZEE] = 50;
                      $points[$n] = 50;
                  } 
                  $points[self::FOURKIND] = 4*$dieval;
               }
               $points[self::THREEKIND] = 3*$dieval;
            }
        }      
        $lastVal = 100;
        $cnt = 0; 
        for ($n=0; $n<6; $n++) {
            $dieval = $n+1;
	        $val = $diceCup->countofValue($dieval);
	        // Straight test
	        if ($val > 0) {
	            $cnt++;
                if ($cnt > 3) {
                    $sstrt = TRUE;
                    $points[self::SHORTSTRT] = 30;
		            if ($cnt > 4) {
		                $strt = TRUE;
                        $points[self::STRT] = 40;
                        break;
                    }
                }
	        }
            else { $cnt = 0; }
      
            // FH test
	        if ($val >= 3) {
	            if (!$fh ) {
		            for ($i=0; $i<6; $i++) {
		                $dieval2 = $i+1;
		                if ($i != $n and $diceCup->countofValue($dieval2) >= 2) {
                            $points[self::FULLH] = 25;
                            $fh = TRUE;
                        }
                    }
                }
            }
            $lastVal = $val;
        }      
        $values[self::THREEKIND] = $threekind;
        $values[self::FOURKIND] = $fourkind;
        $values[self::FULLH] = $fh;
        $values[self::SHORTSTRT] = $sstrt;
        $values[self::STRT] = $strt;
        $values[self::YAHTZEE] = $yahtzee;
        $values[self::CHANCE] = FALSE;
        $points[self::CHANCE] = rand(12,25);
   }


}


echo "before<br>";
$scoreboard = new ScoreBoard(5);
$scoreboard->printboard();
$scoreboard->updateboard();
$scoreboard->printboard();

echo "after<br>";

?>
  </section>
</div>
  <footer class="center">
     <div class="center">
        <h2 class="italic"> php.</h2>
   </div>
  </footer>


</body>
</html>

