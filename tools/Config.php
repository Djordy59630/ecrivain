<?php


class Config {

    private $env;

    public function __construct()
    {
        $this->env = empty(getenv('CONFIG'))?'local':getenv('CONFIG');
    }

    public function load(){
        return parse_ini_file(APP_DIRECTORY. 'config/'.$this->env . '.ini');
    }


}