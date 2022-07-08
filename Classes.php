
///////////////
//
//  Class Die
//
//   Encompasses the data and actions of a single Die.
//
//     Creation: GEM 7/7/2022
//
class Die {

   var $locked = FALSE;
   var $value = rand(1,6);


   // Sets the value of die to a random integer between 1 and 6
   //   roll is inhibited if die is locked
   //
   function roll() {
       if (!this->locked) {
          this->value = rand(1,6);
       }
   }

   // Returns integer value of die
   //
   function getValue() {
       return this->value;
   }

   // Returns boolean value of if die is locked
   //
   function isLocked() {
       return this->locked;
   }

   // Locks the die
   //
   function lock();
       this->locked = TRUE;
   }

   Unlocks the die
   //
   function unlock();
       this->locked = FALSE;
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
class Dice {

   var $num_dice;            // Number of dice in cup
   var $diceCup = array();  // an array to hold the dice


   // DiceCup Constructor
   //
   //   Initializes data and structures 
   //   Parameters - $numberofDice - the number of dice in cup
   // 
   // 
   function __constructor($numberofDice) {
       this->num_dice = $numberofDice;
       for ($n = 0; $n<$numDice; $n++) {
           this->diceCup[$n] = new Die();
       }
   }

   // rollDice
   //
   //   rolls all unlocked dice
   //
   function rollDice() {
        = $numberofDice;
       for ($n = 0; $n<this->num_dice; $n++) {
           this->diceCup[$n].roll();
       }
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
   var $diceCup = array();   // an array to hold the dice


   // DiceCup Constructor
   //
   //   Initializes data and structures 
   //   Parameters - $numberofDice - the number of dice in cup
   // 
   // 
   function __constructor($numberofDice) {
       this->num_dice = $numberofDice;
       for ($n = 0; $n<$numDice; $n++) {
           this->diceCup[$n] = new Die();
       }
   }

   // rollDice
   //
   //   rolls all unlocked dice
   //   This somehow needs to communicate with chance to update chance value
   //
   function rollDice() {
        = $numberofDice;
       for ($n = 0; $n<this->num_dice; $n++) {
           this->diceCup[$n].roll();
       }
   }

   // countofValue
   //   returns how many dice are of the parameter value
   //
   function countofValue($value) {
       $val = 0;
       for ($n=0; $n< this->num_dice; $n++) {
	  if ($val == this->diceCup[$n]) {
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
   var $valUnlocked = array()  // if this value has been used (so locked)

   var $diceCup;

   // Index values
   const 3KIND = 6;
   const 4KIND = 7;
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
   function __constructor($numDice) {
       this->clearboard();
       this->diceCup($numDice);
   }

   // clearBoard() {
   //    zeros all values
   // 
   function clearboard() {
       for ($n=0; $n<self::VALCNT; $n++) {
          if ($n < 5) {
	     self->values[$n] = 0;
          }
	  else {self->values[$n] = FALSE; }

	  self->valUnlocked[$n] = TRUE;
       }
   }

   // updateBoard
   //    This updates the internal scoreboard
   //    based on the most recent roll (values in dicecup param). 
   //
   function updateBoard( $dicecup ) {
       $4kind = FALSE;
       $3kind = FALSE;
       $yahtzee = FALSE;
       $fh = FALSE;
       $strt = FALSE;
       $sstrt = FALSE;

       // Update the counts of dice/values
       for ($n=0; $n<6; $n++) {
	   $val = this->dicecup->countofValues($n);
           this->values[$n] = val;
	   if ($val >= 3) {
	      $3kind = TRUE;
              if ($val >= 4) {
                 $4kind = TRUE;          
  	         if ($val >= 5 ) {
	            $yahtzee = TRUE;
                 } 
              }
           }
          
       }      
       $lastVal = 100;
       $cnt = 0; 
       for ($n=0; $n<6; $n++) {
	   $val = this->dicecup->countofValues($n);
	   // Straight test
	   if ($lastVal + 1 == $val) {
	      $cnt++;
              if ($cnt > 3) {
                 $sstrt = TRUE;
		 if ($cnt > 4) {
		    $strt = TRUE;
                    break;
                 }
              }
	   }
           else { $cnt = 0; }
      
           // FH test
	   if ($val >= 3) {
	      if (!fh ) {
		 for ($i=0; $i<6; $i++) {
		     if ($1 != $n and this->dicecup->countofValues($i) >= 2) {
                         $fh = TRUE;
                     }
                 }
              }
           }
           $lastVal = $val;
       }      
       this->values[this::3KIND] = $3kind;
       this->values[this::4KIND] = $4kind;
       this->values[this::FULLH] = $fh;
       this->values[this::SHORTSTRT] = $sstrt;
       this->values[this::STRAIGHT] = $strt;
       this->values[this::YAHTZEE] = $yahtzee;
       this->values[this::CHANCE] = $rand(12,25);
       
   }


}





