<?php
    
    function custom_hash($password, $salt = "sneaker123") {
        $hash = 0;
        $prime = 31;

        // Combine password with salt
        $combined = $password . $salt;

        for ($i = 0; $i < strlen($combined); $i++) {
            // Get ASCII value of each character
            $ascii = ord($combined[$i]);

            // Multiply by prime number and XOR with hash
            $hash = (($hash * $prime) ^ $ascii) & 0xFFFFFFFF;
        }

        // Convert hash to a hexadecimal string
        return dechex($hash);
    }
    function consistent_hash($input) {
        return hash('sha256', $input);
    }
?>
