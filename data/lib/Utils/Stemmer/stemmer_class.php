<?php

/**

 * Russian stemming alghorithm implementation on PHP

 * (see http://snowball.sourceforge.net for detailed description).

 *

 * Copyright (c) 2005 Anton "simanyay" Kovalyov <simanyay@gmail.com>

 * All rights reserved

 *

 * This script is free software; you can redistribute it and/or modify

 * it under the terms of the GNU General Public License as published by

 * the Free Software Foundation; either version 2 of the License, or

 * (at your option) any later version.

 *

 * The GNU General Public License can be found at

 * http://www.gnu.org/copyleft/gpl.html.

 *

 * This script is distributed in the hope that it will be useful,

 * but WITHOUT ANY WARRANTY; without even the implied warranty of

 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the

 * GNU General Public License for more details.

 *

 * @author: Anton Kovalyov

 */



require_once(dirname(__FILE__)."/stringbuffer.php");

require_once(dirname(__FILE__)."/stemmerdata.php");



class RussianStemmer {

	var $data;

	var $charset;

	

	// Constructor for RussianStemmer with charset

	function RussianStemmer() {

		$this->data = new StemmerData;

		$this->charset = $this->data->charset;

	}

	

	/*

	 * Adjectival endings is and adjective ending,

	 * optionally preceded by participle ending.

	 */

	function adjectival(&$stemmingZone) {

		// Look for adjective ending in a stemming zone

		if(!$this->findAndRemoveEnding($stemmingZone, $this->data->adjectiveEndings))

			return false;

		// If adjective ending was found, try for participle ending

		$r = $this->findAndRemoveEnding($stemmingZone,

						$this->data->participleEndings1,

						$this->data->participlePredessors

			 )

				||

			 $this->findAndRemoveEnding($stemmingZone, $this->data->participleEndings2);

		return true;

	}

	

	// Derivational endings

	function derivational(&$stemmingZone) {

		$endingLength = $this->findEnding($stemmingZone, $this->data->derivationalEndings);

		if($endingLength == 0) {

			// No derivational ending found

			return false;

		} else {

			// Ensure that the ending locates in R2

			if($this->data->R2 - $this->data->RV <= $stemmingZone->getLength() - $endingLength) {

				$stemmingZone->setLength($stemmingZone->getLength() - $endingLength);

				return true;	

			} else {

				return false;

			}

		}

	}

	

	function findEnding(&$stemmingZone, $theEndingClass, $startIndex = -1) {

		if($startIndex == -1)

			$startIndex = $stemmingZone->getLength() - 1;

		

		$match = false;

		for($i = count($theEndingClass) - 1; $i >= 0; $i--) {

			$theEnding = $theEndingClass[$i];

			// Check if the ending is bigger than stemming zone

			if($startIndex < count($theEnding) - 1) {

				$match = false;

				continue;

			}

			$match = true;

			$stemmingIndex = $startIndex;

			for($j = count($theEnding) - 1; $j >= 0; $j--) {

				if($stemmingZone->charAt($stemmingIndex--) != chr($this->data->charset[$theEnding[$j]])) {

					$match = false;

					break;

				}

			}



			// Check if ending was found

			if($match) {

				return count($theEndingClass[$i]); // Cut ending

			}

		}

		return 0;

	}

	

	function findAndRemoveEnding(&$stemmingZone, $theEndingClass, $thePredessors = NULL) {

		/*

		 * Finds the ending among the given class of endings and

		 * removes it from stemming zone.

		 */

		if($thePredessors == NULL) {

			$endingLength = $this->findEnding($stemmingZone, $theEndingClass);

			

			if($endingLength == 0) { // Not found

				return false;

			} else {

				$stemmingZone->setLength($stemmingZone->getLength() - $endingLength);

				// Cut the ending found

				return true;

			}

		/*	

		 * Finds the ending among the given class of endings, then checks if this ending was

		 * preceded by any of given predessors, and if so, removes it from stemming zone.

		 */

		} else {

			$endingLength = $this->findEnding($stemmingZone, $theEndingClass);

			if($endingLength == 0) { // Not found

				return false;

			} else {

				$predessorLength = $this->findEnding($stemmingZone,

										$stemmingZone->getLength() - $endingLength - 1,

										$thePredessors);

				if($predessorLength == 0) {

					return false;

				} else {

						$stemmingZone->setLength($stemmingZone->getLength() - $endingLength);

						// Cut the ending found

						return true;

				}

			}

		}

	}

	

	// Marks positions :)

	function markPositions($word) {

		$this->data->RV = 0;

		$this->data->R1 = 0;

		$this->data->R2 = 0;

		

		$i = 0;

		

		/*

		 * Find RV

		 * RV is the region after the first vowel,

		 * or the end of the word if it contains no vowel

		 */

		while($i < strlen($word)) {

			if($this->isVowel($word{$i})) {

				break;

			}

			$i++;

		}

		

		if($i == strlen($word)) {

			$this->data->RV = $i;

		} else {

			$this->data->RV = ++$i;

		}

		

		/*

		 * Find R1

		 * R1 is the region after the first non-vowel following a vowel,

		 * or the end of the word if there is no such non-vowel.

		 */

		while($i < strlen($word) - 1) {

			if(!$this->isVowel($word{$i}) && $this->isVowel($word{$i+1})) {

				break;

			}

			$i++;

		}

			

		if($i == strlen($word)) {

			$this->data->R1 = $i;

		} else {

			$this->data->R1 = ++$i;

		}

		

		/*

		 * Find R2

		 * R2 is the region after the first non-vowel following a vowel

		 * in R1, or the end of the word if there is no such non-vowel.

		 */

		while($i < strlen($word) - 1) {

			if(!$this->isVowel($word{$i}) && $this->isVowel($word{$i+1})) {

				break;

			}

			$i++;

		}

		

		if($i == strlen($word)) {

			$this->data->R2 = $i;

		} else {

			$this->data->R2 = ++$i;

		}

	}

	

	// Checks if it's vowel

	function isVowel($letter) {

		for($i = 0; $i < count($this->data->vowels); $i++) {

			if($letter == chr($this->data->charset[$this->data->vowels[$i]]))

				return true;

		}

		return false;

	}

	

	// Remove I characters at the end of the word

	function removeI(&$stemmingZone) {

		if($stemmingZone->getLength() > 0

		   && $stemmingZone->charAt($stemmingZone->getLength() - 1) == chr($this->data->charset[I]))

		{

			$stemmingZone->setLength($stemmingZone->getLength() - 1);

			return true;

		} else {

			return false;

		}

	}

	

	// Noun endings

	function noun(&$stemmingZone) {

		return $this->findAndRemoveEnding($stemmingZone, $this->data->nounEndings);

	}

	

	// Perfective gerund endings.

	function perfectiveGerund(&$stemmingZone) {

		return $this->findAndRemoveEnding(

					$stemmingZone,

					$this->data->perfectiveGerundEndings1,

					$this->data->perfectiveGerund1Predessors

				) || $this->findAndRemoveEnding(

					$stemmingZone,

					$this->data->perfectiveGerundEndings2

				);

	}

	

	// Reflexive endings

	function reflexive(&$stemmingZone) {

		return $this->findAndRemoveEnding($stemmingZone, $this->data->reflexiveEndings);

	}

	

	// Remove SOFT characters at the end of the word

	function removeSoft(&$stemmingZone) {

		if($stemmingZone->getLength() > 0

		   && $stemmingZone->charAt($stemmingZone->getLength() - 1) == chr($this->data->charset[SOFT]))

		{

			$stemmingZone->setLength($stemmingZone->getLength() - 1);

			return true;

		} else {

			return false;

		}

	}

	

	// Sets charset :)

	function setCharset($newCharset) {

		$this->data->charset = $newCharset;

	}

	

	// Finds the stem for given Russian word

	function stem($input) {
		$input = iconv('UTF-8', 'Windows-1251', $input);
		// I have to do this because strtolower doesn't understand

		// russian words

		$lowercase = array("à", "á", "â", "ã", "ä", "å", "¸", "æ", "ç", "è",

						   "é", "ê", "ë", "ì", "í", "î", "ï", "ð", "ñ", "ò",

						   "ó", "ô", "õ", "ö", "÷", "ø", "ù", "ü", "û", "ú",

						   "ý", "þ", "ÿ");

		$uppercase = array("À", "Á", "Â", "Ã", "Ä", "Å", "¨", "Æ", "Ç", "È",

						   "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", "Ð", "Ñ", "Ò",

						   "Ó", "Ô", "Õ", "Ö", "×", "Ø", "Ù", "Ü", "Û", "Ú",

						   "Ý", "Þ", "ß");

		$input = str_replace($uppercase, $lowercase, $input);

		$input = trim($input);

		

		$this->markPositions($input);



		if($this->data->RV == 0)

			return $input; // RV wasn't detected, nothing to stem

		

		$stemmingZone = new StringBuffer(substr($input, $this->data->RV));

		// Stemming goes on in RV

		// Step 1

		if(!$this->perfectiveGerund($stemmingZone)) {

			$this->reflexive($stemmingZone);

			$r = $this->adjectival($stemmingZone) ||

				 $this->verb($stemmingZone) ||

				 $this->noun($stemmingZone);

		}

		// Step 2

		$this->removeI($stemmingZone);

		// Step 3

		$this->derivational($stemmingZone);

		// Step 4

		$this->superlative($stemmingZone);

		$this->undoubleN($stemmingZone);

		$this->removeSoft($stemmingZone);

		// Return result
		$retWord = substr($input, 0, $this->data->RV) . $stemmingZone->getString();
		$retWord = iconv('Windows-1251', 'UTF-8', $retWord);

		return $retWord;

	}

	

	// Superlative endings

	function superlative(&$stemmingZone) {

		return $this->findAndRemoveEnding($stemmingZone, $this->data->superlativeEndings);

	}

	

	// Undoubles N.

	function undoubleN(&$stemmingZone) {

		$doubleN = array(array(N, N));

		if($this->findEnding($stemmingZone, $doubleN) != 0) {

			$stemmingZone->setLength($stemmingZone->getLength() - 1);

			return true;

		} else {

			return false;

		}

	}

	

	// Checks if it's verb

	function verb(&$stemmingZone) {

		return $this->findAndRemoveEnding(

			$stemmingZone,

			$this->data->verbEndings1,

			$this->data->verb1Predessors)

			|| $this->findAndRemoveEnding($stemmingZone, $this->data->verbEndings2);

	}

	

	function &getInstance() {

		static $instance;

		

		if(!is_object($instance)) $instance = new RussianStemmer();

		return $instance;

	}

}

?>