<?php


namespace Alpa\Icms\Oauth;


use League\OAuth2\Client\Provider\AbstractProvider;

class UserData
{
    protected array $data;
    protected ?array $flip_fields;
    public function __construct(array $data,?array $flip_fields=null)
    {
        $this->data=$data;
        $this->flip_fields=$flip_fields;
    }
    public function get ($name)
    {
        if($this->flip_fields!==null){
            if(key_exists($name,$this->flip_fields)){
                $key=$this->flip_fields[$name];
            } else {
                $key=$name;
            }
            return $this->data[$key];
        }
        return $this->data[$name];
    }
    public function toArray():array
    {
        $result=[];

        if($this->flip_fields!==null){
            $bind_fields=array_flip($this->flip_fields);
            foreach($this->data as $key=>$value){
                if(key_exists($key,$bind_fields)){
                    $result[$bind_fields[$key]]=$value;
                } else {
                    $result[$key]=$value;
                }
            }
        } else {
            $result=$this->data;
        }
        return $result;
    }
    /*protected function bindDataToProps($data,?array $bindFields=null)
    {
        if($bindFields!==null){
            foreach($bindFields as $key=>$value){
                if(key_exists($value,$data)){
                    $this->$key=$data[$value];
                } else {
                    $this->$key=null;
                }
            }
        } else {
            foreach($data as $key=>$value){
                $this->$key=$value;
            }
        }
    }*/
}