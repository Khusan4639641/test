<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class House extends Model
{
    use HasFactory;

    const FILE_NAME = 'data.csv';

    protected $fillable = [
            'name',
            'price',
            'bathrooms',
            'bedrooms',
            'storeys',
            'garages',
    ];

    public function getFirstDataAttribute(){
        $return = [];
        $fileContents = explode(PHP_EOL, Storage::disk('public')->get(self::FILE_NAME));
        $headers = explode(',',$fileContents[0]);
        foreach ( array_slice($fileContents, 1) as $content){
                $return[] = array_change_key_case(
                        array_combine($headers, explode(',', $content)
                    ),CASE_LOWER);
        }
        return $return;
    }
}
