<?php

class ipvCalc{

    private $ipv4 = '';
    private $ipv6 = '';
    private $mac = '';

    public function calc($addr, $type){
        // addr = ipv4 or ipv6
        // Type ipv4 or ipv6
        if($type === 'ipv6'){
            $this->ipv4 = $addr;
            $this->ipv4();
            print_r($this->ipv6);
        }
        if($type === 'ipv4'){
            $this->ipv6 = $addr;
            $this->ipv6();
            print_r($this->ipv4);
        }     
        if($type === 'mac'){
            $this->ipv6 = $addr;
            $this->mac_addr();
            print_r($this->mac);
        }
    }

    private function ipv4(){    
              
       $addr_seg = explode('.', $this->ipv4);
       
       $ipv6_addr = array();
       foreach($addr_seg as $value){
            $ipv6_addr[] = dechex($value);
       }

       for($i=0;$i<count($ipv6_addr);$i++){
           
           if(strlen($ipv6_addr[$i])==1){
            $this->ipv6 .= "0".$ipv6_addr[$i];
           }else{
            $this->ipv6 .= $ipv6_addr[$i];
           }
         
       }
       
       $first_half = substr($this->ipv6, 0, 4);
       $second_half = substr($this->ipv6, 4, 8);
       $this->ipv6 = "0:0:0:0:0:ffff:".$first_half.":".$second_half;
       
       return $this->ipv6;
    }

    private function ipv6(){    

       // Split the string into segments
       $addr_seg = explode(':', $this->ipv6);
       
       $address_str = '';
       foreach($addr_seg as $value){
           if(!empty($value)){
            $address_str .= $value;
           }
       }

       // Get the last 8 characters
       $last_seg = substr($address_str,-8);
       $this->ipv4 = $this->make_ipv4($last_seg);
       
       return $this->ipv4;
    }    

    private function make_ipv4($val){
        $da = str_split($val);
        
        $a = array();
        foreach($da as $k => $v){
            if(!empty($v)){
                $a[] = hexdec($v);
            }
        }
        
        $b = array();
        foreach($a as $k => $v){
            if($k % 2 == 0){
                $b[] = $v * 16;
            }else{
                $b[] = $v;
            }                 
        }
        $z = array_chunk($b, 2);
        $c = array();
        foreach($z as $k => $v){
            $c[] = array_sum($v);
        }

        $d = '';
        foreach($c as $k => $v){
            $d .= $v.".";
        }
        
        $e = substr($d, 0, -1);
        
        return $e;
    }

    private function mac_addr(){
       // Split the string into segments
       $addr_seg = explode(':', $this->ipv6);
       
       $address_str = '';
       foreach($addr_seg as $value){
           if(!empty($value)){
            $address_str .= $value;
           }
       }

       // Get the last 8 characters
       $last_seg = substr($address_str,-16);
       $needle = 'fffe';
       $a = str_replace($needle, '', $last_seg);

       $b = substr($a, 0, 2);
       $c = base_convert($b, 32, 2);
       $d = substr($c, 6, 1);

       /** 
       if(substr(base_convert(substr($a, 0, 2), 32, 2),6,1) == 0){
        $g = 1;
       }else{
        $g = 0;
       }
       */
       // 68:1c:a2:12:c1:61
       // 11001010
       
       // 11001110
       
       // 12 10
       var_dump($b);
       var_dump($c);
       var_dump($d);
    }

}
?>
