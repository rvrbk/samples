<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    /**
     * @author Rik Verbeek
     * 
     * Get a visitor or create one on the fly
     */
    static public function getVisitorByIP(string $ip) : Visitor
    {
        // Check if the ip is already present
        $visitor = Visitor::where('ip', $ip)->first();

        // If not create a new one
        if(!$visitor) {
            $visitor = new Visitor();

            $visitor->ip = $ip;

            $visitor->save();
        }

        return $visitor;
    }
}
