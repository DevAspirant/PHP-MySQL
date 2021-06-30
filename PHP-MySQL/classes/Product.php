<?php

class Product extends Service
{
    public function all()
    {
        return [
            ['name'=>'mouse','price'=>50],
            ['name'=>'iPhone','price'=>1000],
            ['name'=>'Keyobard','price'=>500],
        ];
    }
}
