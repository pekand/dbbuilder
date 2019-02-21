<?php

namespace Core\Temp;

class Temp
{
    private $app = null;
    
    private $tempPath = null;
        
    public function __construct($app, $tempPath) {
        $this->app = $app;
        $this->tempPath = $tempPath;
    }
    public function getFileName($name){
        return $this->tempPath.md5($name).'.tmp';
    }
    
    public function set($name, $value) {
        $filename = $this->getFileName($name);
        
        $filenameSav = $filename.'.sav';
        
        if (file_exists($filenameSav)) {
           return false; 
        }
        
        file_put_contents($filenameSav, $value);
        
        if (file_exists($filename)) {
            unlink($filename);
        }
        
        rename($filenameSav, $filename); 
        
        return true; 
    }
    
    public function get($name) {
        $filename = $this->getFileName($name);
        if (file_exists($filename)) {
            return file_get_contents($filename);
        }
        
        return null;
    }
    
    public function remove($name) {
        
    }
    
    public function clear() {
        foreach (glob($this->tempPath."*.tmp") as $filePath) {
            unlink($filePath);
        }
        
        foreach (glob($this->tempPath."*.sav") as $filePath) {
            unlink($filePath);
        }
    }
}