<?php
class show {
    
    private $name;
    private $array;

    public function __construct($name,$array=null){
        $this->name = $name;//文件名
        $this->array = $array;//变量数组
    }

    public function display(){
        
        if (is_array($this->array)){
            foreach ($this->array as $key=>$value){
                $$key = $value;
            }
        }
            
        require $this->name;
    }
    
}

 
?>