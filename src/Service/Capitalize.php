<?php

namespace App\Service;
	
class Capitalize
{	    	
    public function toUpper(string $s): string
    {
        //  Ne gère les majuscules avec les accents
        // $s = strtoupper($s);

        // Gère les majuscules avec les accents
        $s = mb_strtoupper($s);
        return $s;
    } // -- toUpper()

} // -- class