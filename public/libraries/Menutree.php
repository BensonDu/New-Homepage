<?php
/**
 * Author: Benson
 * Date: 15/5/15
 */
class Menutree{

    private

        $id,
        $parent,
        $children;

    public function get_tree($array,$id='id',$parent='parent',$children='child'){

        $this->id=$id;
        $this->parent=$parent;
        $this->children=$children;

        $c=array();
        $l=count($array);
        //所有ID 导入数组
        foreach($array as $v) {
            $c[]=$v[$id];
        }
        //筛选有效列表 （删除：不为根目录、并且父目录不存在、或父元素等于其自身）
        while($l){
            $l--;
            if(($array[$l][$this->parent]!=0 && !in_array($array[$l][$this->parent],$c,true))||$array[$l][$this->id] == $array[$l][$this->parent]){
                array_splice($array,$l,1);
            }
        }

        return $this->handle($array);

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

}