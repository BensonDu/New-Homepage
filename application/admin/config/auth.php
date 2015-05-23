<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 忽略鉴权设置
 *
 * @author: Dubx
 *
 * Example:
 *     $config['ignore']=array(
 *
 *          忽略所有 类为class1 方法为method3 的方法
 *          0   =>  array('class1','method1'),
 *
 *          忽略所有 类为class2 的方法
 *          1   =>  array('class2'),
 *          忽略所有 方法为method3 的方法
 *
 *          3   =>  array('','method3')
 *     );
 */
$config['ignore']=array(
    0=>array('auth')
);