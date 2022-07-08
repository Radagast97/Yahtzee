
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
//     Creation: GEM 7/7/2022
//
class DiceCup {

    var $num_dice;            // Number of dice in cup
    var $diceCup = array();  // an array to hold the dice


    // DiceCup Constructor
    //
    //   Initializes data and structures 
    //   Parameters - $numberofDice - the number of dice in cup
    // 
    // 
    function __construct($numberofDice) {
        $this->num_dice = $numberofDice;
        for ($n = 0; $n<$numDice; $n++) {
           $this->diceCup[$n] = new Dice();
       }
    }

    // rollDice
    //
    //   rolls all unlocked dice
    //
    function rollDice() {
       for ($n = 0; $n<$this->num_dice; $n++) {
           $this->diceCup[$n].roll();
       }
    }

    // countofValue
    //   returns how many dice are of the parameter value
    //
    function countofValue($value) {
        $val = 0;
        for ($n=0; $n< $this->num_dice; $n++) {
	        if ($val == $this->diceCup[$n]) {
               $val++;
            }
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
//
class ScoreBoard {

    var $values = array();      // Values of dice
    var $points = array();      // Points to be earned by this roll of dice
    var $valUnlocked = array(); // if this value has been used (so locked)


    var $diceCup;

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
       $this->clearboard();
       $this->diceCup($numDice);
    }

    // clearBoard() {
    //    zeros all values
    // 
    function clearboard() {
       for ($n=0; $n<self::VALCNT; $n++) {
           if ($n < 5) {
	         $this->values[$n] = 0;
           }
	       else {$this->values[$n] = FALSE; }

	       $this->valUnlocked[$n] = TRUE;
           $this->points[$n] = 0;
        }
    }

    // updateBoard
    //    This updates the internal scoreboard
    //    based on the most recent roll (values in dicecup param). 
    //
    function updateBoard( $dicecup ) {
       $fourkind = FALSE;
       $threekind = FALSE;
       $yahtzee = FALSE;
       $fh = FALSE;
       $strt = FALSE;
       $sstrt = FALSE;

       // Update the counts of dice/values
       for ($n=0; $n<6; $n++) {
	       $val = $this->dicecup->countofValues($n);
           $this->values[$n] = val;
           $this->points[$n] = val*$n;
	       if ($val >= 3) {
	           $threekind = TRUE;
               if ($val >= 4) {
                  $fourkind = TRUE;          
  	              if ($val >= 5 ) {
	                  $yahtzee = TRUE;
	                  $this->points[self::YAHTZEE] = 50;
                      $this->points[$n] = 50;
                  } 
                  $this->points[self::FOURKIND] = 4*$n;
               }
               $this->points[self::THREEKIND] = 3*$n;
            }
        }      
        $lastVal = 100;
        $cnt = 0; 
        for ($n=0; $n<6; $n++) {
	        $val = $this->dicecup->countofValues($n);
	        // Straight test
	        if ($lastVal + 1 == $val) {
	            $cnt++;
                if ($cnt > 3) {
                    $sstrt = TRUE;
                    $this->points[self::SHORTSTRT] = 30;
		            if ($cnt > 4) {
		                $strt = TRUE;
                        $this->points[self::STRAIGHT] = 40;
                        break;
                    }
                }
	        }
            else { $cnt = 0; }
      
            // FH test
	        if ($val >= 3) {
	            if (!fh ) {
		            for ($i=0; $i<6; $i++) {
		                if ($i != $n and $this->dicecup->countofValues($i) >= 2) {
                            $this->points[self::FULLH] = 25;
                            $fh = TRUE;
                        }
                    }
                }
            }
            $lastVal = $val;
        }      
        $this->values[self::THREEKIND] = $threekind;
        $this->values[self::FOURKIND] = $fourkind;
        $this->values[self::FULLH] = $fh;
        $this->values[self::SHORTSTRT] = $sstrt;
        $this->values[self::STRAIGHT] = $strt;
        $this->values[self::YAHTZEE] = $yahtzee;
        $this->values[self::CHANCE] = $rand(12,25);
       
   }


}



