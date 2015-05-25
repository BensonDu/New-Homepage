<?php
/**
 * Author: Benson
 * Date: 15/5/15
 */
class Menutree{

    private

        $id,
        $parent,
        $children,
        $array,
        $condition,
        $tag;

    public function get_tree($array,$id='id',$parent='parent',$children='child'){

        $this->id=$id;
        $this->parent=$parent;
        $this->children=$children;

        $array=$this->list_init($array);

        return $this->handle($array);

    }

    private function list_init($array){

        if(!$array)return false;
        $l=count($array);
        //所有ID 导入数组
        foreach($array as $v) {
            $c[]=$v[$this->id];
        }
        //筛选有效列表 （删除：不为根目录、并且父目录不存在、或父元素等于其自身）
        while($l){
            $l--;
            if(($array[$l][$this->parent]!=0
                    && !in_array($array[$l][$this->parent],$c,true))
                ||$array[$l][$this->id] == $array[$l][$this->parent]){
                array_splice($array,$l,1);
            }
        }
        return $array;
    }

    private function handle($array,$menu=array(),$map=array()){

        $l=count($array);

        if(!$l)return $menu;

        while($l){
            $l--;
            //子目录
            if($array[$l][$this->parent]){
                if(isset($map[$array[$l][$this->parent]])){
                    $map[$array[$l][$this->id]]=&$map[$array[$l][$this->parent]][$this->children][$array[$l][$this->id]];
                    $map[$array[$l][$this->id]]=$array[$l];
                    array_splice($array,$l,1);
                }
            }
            //根目录
            else{
                $menu[$array[$l][$this->id]]=$array[$l];
                $map[$array[$l][$this->id]]=&$menu[$array[$l][$this->id]];
                array_splice($array,$l,1);
            }

        }
        //递归
        return $this->handle($array,$menu,$map);

    }

    public function tag_it($array,$condition,$tag,$id='id',$parent='parent'){
        if(!is_array($array)||!is_array($condition)||!is_array($tag)){
            return false;
        }
        $this->id     = $id;
        $this->parent = $parent;
        $this->array  = $this->list_init($array);
        foreach($condition as $k => $v){
            $this->condition[0]=$k;
            $this->condition[1]=$v;
        }
        foreach($tag as $k =>$v){
            $this->tag[0]=$k;
            $this->tag[1]=$v;
        }
        return $this->handle_tag();

    }

    private function handle_tag(){
        foreach($this->array as $k =>$v){
            if($v[$this->condition[0]]==$this->condition[1]){
                $this->array[$k][$this->tag[0]]=$this->tag[1];
                if($v[$this->parent]!=0){
                    $this->condition[0]=$this->id;
                    $this->condition[1]=$v[$this->parent];
                    return $this->handle_tag();
                }
                else{
                    return $this->array;
                }
                break;
            }
        }
    }

}