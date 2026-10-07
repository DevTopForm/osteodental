<?php
/**
 * Data for russian stemmer
 * 
 * Copyright (c) 2005 eSector Solutions <info@esectorsolutions.com>
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

 
// Letters
define("A", "0");
define("B", "1");
define("V", "2");
define("G", "3");
define("D", "4");
define("E", "5");
define("ZH", "6");
define("Z", "7");
define("I", "8");
define("I_", "9");
define("K", "10");
define("L", "11");
define("M", "12");
define("N", "13");
define("O", "14");
define("P", "15");
define("R", "16");
define("S", "17");
define("T", "18");
define("U", "19");
define("F", "20");
define("X", "21");
define("TS", "22");
define("CH", "23");
define("SH", "24");
define("SHCH", "25");
define("HARD", "26");
define("Y", "27");
define("SOFT", "28");
define("AE", "29");
define("IU", "30");
define("IA", "31");

class StemmerData {
	var $charset;
	// Positions of RV, R1 and R2 respectively
	var $RV, $R1, $R2;
	var $vowels, $perfectiveGerundEndings1, $perfectiveGerund1Predessors;
	var $perfectiveGerundEndings2, $adjectiveEndings;
	var $participleEndings1, $participleEndings2;
	var $participlePredessors, $reflexiveEndings;
	var $verbEndings1, $verbEndings2, $verb1Predessors;
	var $nounEndings, $superlativeEndings, $derivationalEndings;
	
	function StemmerData() {
		$this->RV = "";
		$this->R1 = "";
		$this->R2 = "";
		$this->vowels = array(A, E, I, O, U, Y, AE, IU, IA);
		$this->perfectiveGerundEndings1 = array(
					array(V),
					array(V, SH, I),
					array(V, SH, I, S, SOFT)
		);
		$this->perfectiveGerund1Predessors = array(
					array(A),
					array(IA)
		);
		$this->perfectiveGerundEndings2 = array(
					array(I, V),
					array(Y, V),
					array(I, V, SH, I),
					array(Y, V, SH, I),
					array(I, V, SH, I, S, SOFT),
					array(Y, V, SH, I, S, SOFT)
		);
		$this->adjectiveEndings = array(
					array(E, E),
					array(I, E),
					array(Y, E),
					array(O, E),
					array(E, I_),
					array(I, I_),
					array(Y, I_),
					array(O, I_),
					array(E, M),
					array(I, M),
					array(Y, M),
					array(O, M),
					array(I, X),
					array(Y, X),
					array(U, IU),
					array(IU, IU),
					array(A, IA),
					array(IA, IA),
					array(O, IU),
					array(E, IU),
					array(I, M, I),
					array(Y, M, I),
					array(E, G, O),
					array(O, G, O),
					array(E, M, U),
					array(O, M, U)
		);
		$this->participleEndings1 = array(
					array(SHCH),
					array(E, M),
					array(N, N),
					array(V, SH),
					array(IU, SHCH)
		);
		$this->participleEndings2 = array(
					array(I, V, SH),
					array(Y, V, SH),
					array(U, IU, SHCH)
		);
		$this->participlePredessors = array(
					array(A),
					array(IA)
		);
		$this->reflexiveEndings = array(
					array(S, IA),
					array(S, SOFT)
		);
		$this->verbEndings1 = array(
					array(I_),
					array(L),
					array(N),
					array(L, O),
					array(N, O),
					array(E, T),
					array(IU, T),
					array(L, A),
					array(N, A),
					array(L, I),
					array(E, M),
					array(N, Y),
					array(E, T, E),
					array(I_, T, E),
					array(T, SOFT),
					array(E, SH, SOFT),
					array(N, N, O)
		);
		$this->verbEndings2 = array(
					array(IU),
					array(U, IU),
					array(E, N),
					array(E, I_),
					array(IA, T),
					array(U, I_),
					array(I, L),
					array(Y, L),
					array(I, M),
					array(Y, M),
					array(I, T),
					array(Y, T),
					array(I, L, A),
					array(Y, L, A),
					array(E, N, A),
					array(I, T, E),
					array(I, L, I),
					array(Y, L, I),
					array(I, L, O),
					array(Y, L, O),
					array(E, N, O),
					array(U, E, T),
					array(U, IU, T),
					array(E, N, Y),
					array(I, T, SOFT),
					array(Y, T, SOFT),
					array(I, SH, SOFT),
					array(E, I_, T, E),
					array(U, I_, T, E)
		);
		$this->verb1Predessors = array(
			        array(A),
			        array(IA)
    	);
		$this->nounEndings = array(
			        array(A),
			        array(U),
			        array(I_),
			        array(O),
			        array(U),
			        array(E),
			        array(Y),
			        array(I),
			        array(SOFT),
			        array(IA),
			        array(E, V),
			        array(O, V),
			        array(I, E),
			        array(SOFT, E),
			        array(IA, X),
			        array(I, IU),
			        array(E, I),
			        array(I, I),
			        array(E, I_),
			        array(O, I_),
			        array(E, M),
			        array(A, M),
			        array(O, M),
			        array(A, X),
			        array(SOFT, IU),
			        array(I, IA),
			        array(SOFT, IA),
			        array(I, I_),
			        array(IA, M),
			        array(IA, M, I),
			        array(A, M, I),
			        array(I, E, I_),
			        array(I, IA, M),
			        array(I, E, M),
			        array(I, IA, X),
			        array(I, IA, M, I)
		);
		
		$this->superlativeEndings = array (
        			array(E, I_, SH),
        			array(E, I_, SH, E)
    	);
		
		$this->derivationalEndings = array (
			        array(O, S, T),
			        array(O, S, T, SOFT)
    	);
		
		$this->charset = array (
		    0xE0,
		    0xE1,
		    0xE2,
		    0xE3,
		    0xE4,
		    0xE5,
		    0xE6,
		    0xE7,
		    0xE8,
		    0xE9,
		    0xEA,
		    0xEB,
		    0xEC,
		    0xED,
		    0xEE,
		    0xEF,
		    0xF0,
		    0xF1,
		    0xF2,
		    0xF3,
		    0xF4,
		    0xF5,
		    0xF6,
		    0xF7,
		    0xF8,
		    0xF9,
		    0xFA,
		    0xFB,
		    0xFC,
		    0xFD,
		    0xFE,
		    0xFF,
			
		    // Upper case
		    0xC0,
		    0xC1,
		    0xC2,
		    0xC3,
		    0xC4,
		    0xC5,
		    0xC6,
		    0xC7,
		    0xC8,
		    0xC9,
		    0xCA,
		    0xCB,
		    0xCC,
		    0xCD,
		    0xCE,
		    0xCF,
		    0xD0,
		    0xD1,
		    0xD2,
		    0xD3,
		    0xD4,
		    0xD5,
		    0xD6,
		    0xD7,
		    0xD8,
		    0xD9,
		    0xDA,
		    0xDB,
		    0xDC,
		    0xDD,
		    0xDE,
		    0xDF
		);
	}
}
?>