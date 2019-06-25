<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 23.06.2019
 * Time: 16:09
 */

namespace models\widjets;


use mvc\model\IWidjet;

class CategoryWidjet implements IWidjet
{
    public static function render($categories){
        $html = "";
        if(isset($categories) && !empty($categories)){
            foreach($categories as $key => $child){
                if(count($child['childs']) > 0){
                    $html .= '<li class="dropdown side-dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.$child['name'].'<i class="fa fa-angle-right"></i></a>';
                    $html .= '<div class="custom-menu">';
                    $html .= '<div class="row">';
                    foreach ($child['childs'] as $keySub => $subChild) {
                        $html .= '<div class="col-md-4" >';
                        $html .= '<ul class="list-links">';
                        $html .= '<li >';
                        $html .= '<h3 class="list-links-title" > <a href = "'.\Application::getUrl('products', "category", $subChild['id']).'" >'.$subChild['name'].'</a ></h3 >';
                        $html .= '</li >';
                        foreach ($subChild['childs'] as $keySubSub => $subSubChild) {
                            $html .= '<li ><a href = "'.\Application::getUrl('products', "category", $subSubChild['id']).'" >' . $subSubChild['name'] . '</a ></li >';
                            }
                        $html .= '</ul >';
                        $html .= '</div>';
                        }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</li>';
                }else{
                    $html .= '<li><a href="'.\Application::getUrl('products', "category", $child['id']).'">'.$child['name'].'</a>';
                }
            }
        }
        return $html;
    }
}