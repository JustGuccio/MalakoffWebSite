<?php
spl_autoload_register('Autoloader::autoloadTrait');
spl_autoload_register('Autoloader::autoloadDto');
spl_autoload_register('Autoloader::autoloadDao');
spl_autoload_register('Autoloader::autoloadLib');


class Autoloader{
     
    private string $file;
    
    static function autoloadTrait($class): void
    {
        $file = 'modeles/traits/' . lcfirst($class) . '.php';
        if(is_file($file)&& is_readable($file)){

            require $file;
        }
        
    }
    
    
    static function autoloadDto($class): void{
        $file = 'modeles/DTO/' . lcfirst($class) . '.php';
        if(is_file($file)&& is_readable($file)){
            require $file;
        }
      
    }
    
    static function autoloadLib($class): void{
        $file = 'lib/' . lcfirst($class) . '.php';
        if(is_file($file)&& is_readable($file)){
            echo $file;
            require $file;
        }
        
    }
    
    static function autoloadDao($class): void{
        $file = 'modeles/DAO/' . lcfirst($class) . '.php';
        if(is_file($file)&& is_readable($file)){
            require $file;
        }
        
    }
    
    
}

