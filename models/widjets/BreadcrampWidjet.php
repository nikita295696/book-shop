<?php


namespace models\widjets;


use Application;use mvc\model\IWidjet;

class BreadcrampWidjet implements IWidjet
{
    public static function render($breadcramp){
        $html = "";
        if(isset($breadcramp) && is_array($breadcramp) && count($breadcramp) > 0) {
        $html .= '<nav class="col-md-12" aria-label="breadcrumb">';
            $html .= '<ol class="breadcrumb" id="broadcast">';
                $size = count($breadcramp);
                for ($i = 0; $i < $size - 1; $i++){
                    $html .= '<li data-id="'.$i.'" data-name="'.$breadcramp[$i]['name'].'" class="breadcrumb-item active"><a href="'.Application::getUrl("products", "category", $breadcramp[$i]['id']).'">'.$breadcramp[$i]['name'].'</a></li>';
                }
                $html .= '<li data-id="'.$size.'" data-name="'.$breadcramp[$size-1]['name'].'" class="breadcrumb-item active" aria-current="page">'.$breadcramp[$size-1]['name'].'</li>';
            $html .= '</ol>';
            $html .= '</nav>';
        }
        return $html;
    }

    public static function renderBook($book){
        $html = "";
        if(isset($book) && !empty($book)) {
            $breadcramp = $book['breadcrump'];
            if (isset($breadcramp) && is_array($breadcramp) && count($breadcramp) > 0) {
                $html .= '<nav class="col-md-12" aria-label="breadcrumb">';
                $html .= '<ol class="breadcrumb" id="broadcast">';
                $size = count($breadcramp);
                for ($i = 0; $i < $size; $i++) {
                    $html .= '<li data-id="' . $i . '" data-name="' . $breadcramp[$i]['name'] . '" class="breadcrumb-item active"><a href="' . Application::getUrl("products", "category", $breadcramp[$i]['id']) . '">' . $breadcramp[$i]['name'] . '</a></li>';
                }
                $html .= '<li data-id="' . ($size + 1) . '" data-name="' . $book['data']['name'] . '" class="breadcrumb-item active" aria-current="page">' . $book['data']['name'] . '</li>';
                $html .= '</ol>';
                $html .= '</nav>';
            }
        }
        return $html;
    }
}