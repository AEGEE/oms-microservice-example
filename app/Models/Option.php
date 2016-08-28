<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = "options";

    // Relationships..

    // Model methods go down here..
    public function getRequestHeaders() {
    	$key = $this->where('code', 'handshake_token')->first();

    	$headers = array(
    		'X-Requested-With'	=>	'XMLHttpRequest',
			'X-Api-Key'			=>	$key->value
    	);

    	return $headers;
    }
}
