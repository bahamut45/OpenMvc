<?php 
/**
 * 
 */
 class Form{

    public $controller;
    public $errors;

    public function __construct($controller){
        $this->controller = $controller;
    }

    public function input($name,$label,$options = array()){
        $error = false;
        $classError = '';
        if (isset($this->errors[$name])) {
            $error = $this->errors[$name];
            $classError = ' error';
        }
        if (!isset($this->controller->request->data->$name)) {
            $value = '';
        }else{
            $value = $this->controller->request->data->$name;
        }
        if ($label == 'hidden') {
            return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
        }
        $html = '<div class="control-group '.$classError.'">
                    <label class="control-label" for="input'.$name.'">'.$label.'</label>
                    <div class="controls">';
        $attr = ' ';
        foreach ($options as $k => $v) {
            if ($k != 'type') {
                $attr .= " $k=\"$v\"";
            }
        }
        if (!isset($options['type'])){
            $html .= '<input type="text" id="input'.$name.'" name="'.$name.'" value="'.$value.'" '.$attr.'>';
        }elseif ($options['type'] == 'textarea') {
            $html .= '<textarea id="input'.$name.'" name="'.$name.'" '.$attr.'>'.$value.'</textarea>';
        }elseif ($options['type'] == 'checkbox') {
            $html .= '<input type="hidden" name="'.$name.'" value="0"><input type="checkbox" name="'.$name.'" value="1" '.(empty($value) ? '' : 'checked').'>';
        }elseif ($options['type'] == 'file') {
            $html .= '<input type="file" class="input-file" id="input'.$name.'" name="'.$name.'"'.$attr.'>';
        }elseif($options['type'] == 'password'){
            $html .= '<input type="password" id="input'.$name.'" name="'.$name.'" value="'.$value.'" '.$attr.'>';
        }

        if ($error) {
            $html .= '<span class="help-inline">'.$error.'</span>';
        }

        $html .= '</div></div>';

        return $html;
    }

    public function select($name,$label,$cat,$subcat = array(),$options = array()){
        $error = false;
        $classError = '';
        if (isset($this->errors[$name])) {
            $error = $this->errors[$name];
            $classError = ' error';
        }
        $html =  '<div class="control-group '.$classError.'">
                    <label class="control-label" for="select'.$name.'">'.$label.'</label>
                    <div class="controls">';
        $attr = ' ';
        foreach ($options as $k => $v) { 
            if ($k!= 'type') {
                $attr .= " $k=\"$v\"";
            }
        }
        $html .='<select id="select'.$name.'" name="'.$name.'">';
        $html .='<option value="0">Aucune Catégorie</option>';
        if (empty($subcat)) {
            foreach ($cat as $k => $v){
                if ($this->controller->request->data->name != $v->name) {
                    $selected = '';
                    if ($v->id == $this->controller->request->data->$name) {
                        $selected = 'selected';
                    }
                    $html .='<option value="'.$v->id.'" '.$selected.'>'.$v->name.'</option>';
                }
            }
        }else{
            $html .='<optgroup label="Catégorie Principale">';
            foreach ($cat as $k => $v){
                if ($this->controller->request->data->name != $v->name) {
                    $selected = '';
                    if ($v->id == $this->controller->request->data->$name) {
                        $selected = 'selected';
                    }
                    $html .='<option value="'.$v->id.'" '.$selected.'>'.$v->name.'</option>';
                }
            }
            $html .='</optgroup>';
            foreach ($cat as $cle => $valeur) {
                $for = 0;
                foreach ($subcat as $key => $value) {
                    if ($valeur->id == $value->parentId) {  
                        if ($for == 0) {
                            $html .='<optgroup label="Sous Categorie de '.$valeur->name.'">';
                        }
                        if ($this->controller->request->data->name != $value->name) {
                            $selected = '';
                            if ($value->id == $this->controller->request->data->$name) {
                                $selected = 'selected';
                            }
                            $html .='<option value="'.$value->id.'" '.$selected.'>'.$value->name.'</option>';
                        }                  
                        $for++;
                    }
                }
                if ($for == 0) {
                    $html .='</optgroup>';
                }
            }
        }
        $html .= '</select>';
        if ($error) {
            $html .= '<span class="help-inline">'.$error.'</span>';
        }
        $html .= '</div></div>';
        return $html;
    }
 } 
?>