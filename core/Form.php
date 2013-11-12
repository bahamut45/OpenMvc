<?php 
/**
 * 
 */
 class Form{

    public $controller;
    public $errors;


    // protected $_inputDefaults = array(
    //     'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
    //     'div' => 'control-group',
    //     'label' => array('class' => 'control-label'),
    //     'between' => '<div class="controls">',
    //     'after' => '</div>',
    //     'class' => 'input-xxlarge'
    // );
    
    protected $_inputDefaults = array();

    /**
     * [__construct description]
     * @param [type] $controller [description]
     */
    public function __construct($controller){
        $this->controller = $controller;
    }

    /**
     * [createForm description]
     * @param  [type] $model   [description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function create($model = null, $options = array()){
        $method = 'post';
        $charset = 'utf-8';
        $enctype = '';
        $class = '';

        //Permet de definir les options des inputs par defaut
        if (isset($options['inputDefaults'])) {
            $this->_inputDefaults = array_merge($this->_inputDefaults,$options['inputDefaults']);
        }
        
        //Permet de construire l'action du form automatiquement ou non
        if (is_null($model)){
            $ctl = $this->controller->request->controller;
            $act = $this->controller->request->action;
            $model = array($ctl,$act);
            if (!empty($this->controller->request->prefix)) {
                $pfx[] = $this->controller->request->prefix;
            }
            if (!empty($this->controller->request->params)) {
                $prm[] = $this->controller->request->params['0'];
            }
            if (isset($pfx)) {
                $model = array_merge($pfx,$model);
            }
            if (isset($prm)) {
                $model = array_merge($model, $prm);
            }
            $id = implode(array_map('ucfirst', $model));
            $model = implode('/',$model);
            $action = Router::url($model);            
        }else {
            $id = explode('/', $model);
            $id = implode(array_map('ucfirst', $id));
            $action = Router::url($model);
        }

        //Permet de definir un id specifique sinon créé automatiquement
        if (isset($options['id'])) {
            $id = $options['id'];
        }

        //Permet de definir la méthode d'envoi du formulaire
        if (isset($options['method'])) {
            $method = $options['method'];
        }

        //Permet de définir le type d'envoi du formulaire
        if (isset($options['enctype'])) {
            $enctype = 'enctype="'.$options['enctype'].'"';
            $method = 'post';
        }

        //Permet de définir une class au formulaire
        if (isset($options['class'])) {
            $class = 'class="'.$options['class'].'"';
        }

        $html = '<form id="'.$id.'" '.$class.' action="'.$action.'" '.$enctype.' method="'.$method.'" accept-charset="'.$charset.'">';
        return $html;
    }

    public function inputForm($fieldName, $options = array()){
        
        $realOptions = $options;

        // Merge des inputs par defaut 
        if (isset($options['type'])) {
            if ($options['type'] != 'hidden') {
                $options = array_merge_recursive($this->_inputDefaults,$options);
            }
        }else{
            $options = array_merge_recursive($this->_inputDefaults,$options);
        }

        //Initialisation des variables
        $error      = false;
        $classError = null;
        $wrapTag    = (isset($options['error']['attributes']['wrap'])) ? $options['error']['attributes']['wrap'] : 'div';
        $wrapClass  = (isset($options['error']['attributes']['class'])) ? $options['error']['attributes']['class'] : 'error-message';
        $html       = '';
        $div        = (isset($options['div'])) ? $options['div'] : null;
        $divAttr    = '';
        $endDiv     = '';
        $label      = (isset($options['label'])) ? $options['label'] : null;
        $labelAttr  = '';
        $before     = (isset($options['before'])) ? $options['before'] : '';
        $between    = (isset($options['between'])) ? $options['between'] : '';
        $input      = '';
        $disError   = '';
        $after      = (isset($options['after'])) ? $options['after'] : '';
        $class      = (isset($options['class'])) ? (is_array($options['class'])) ? implode(' ',$options['class']) : $options['class'] : null;
        $format     = (isset($options['format'])) ? $options['format'] : array('div', 'before', 'label', 'between', 'input', 'disError', 'after', 'endDiv');
        $value      = (isset($this->controller->request->data->$fieldName)) ? $this->controller->request->data->$fieldName : ((isset($options['value'])) ? $options['value'] : '' );

        //Vérification des erreurs suite à la validation
        if (isset($this->errors[$fieldName])) {
            $error = $this->errors[$fieldName];
            $classError = isset($options['error']['class']) ? $options['error']['class'] : null;
            $disError = '<'.$wrapTag.' class="'.$wrapClass.'">'.$error.'</'.$wrapTag.'>';
        }

        // verification d'une div englobante
        if (isset($div)) {
            if (is_string($div)) {
                $div = '<div class="'.$div.' '.$classError.'">';
            }elseif (is_array($div)) {
                foreach ($div as $k => $v) {
                    if ($k == 'class') {
                        $divAttr .= " $k=\"$v $classError\"";
                    }else {
                        $divAttr .= " $k=\"$v\"";
                    }                    
                }
                $div = '<div '.$divAttr.'>';
            }
            $endDiv = '</div>';
        }
        // verification d'un label
        if (isset($label)) {
            if (is_string($label)) {
                $label = '<label for="input'.$fieldName.'">'.$label.'</label>';
            }elseif (is_array($label)) {
                foreach ($label as $k => $v) {
                    if ($k != 'text') {
                        $labelAttr .= " $k=\"$v\"";
                    }
                }
                $label = '<label for="input'.$fieldName.'" '.$labelAttr.'>'.$label['text'].'</label>';
                unset($realOptions['label']);
            }
        }

        //Verification du type d'input
        if (!isset($options['type'])) {
            if (isset($class)) {
                $class = 'class="'.$class.'"';
            }
            $input = '<input type="text" id="input'.$fieldName.'" '.$class.' name="'.$fieldName.'" value="'.$value.'">';
        }else{
            $type = $options['type'];
            unset($realOptions['type']);
            $realOptions['value'] = $value;
            if (isset($class)) {
                $realOptions['class'] = $class;
            }            
            //debug($realOptions);            
            $input = $this->$type($fieldName,$realOptions);
        }

        $out = array('div' => $div, 'before' => $before, 'label' => $label, 'input' => $input, 'disError' => $disError, 'between' => $between, 'after' => $after, 'endDiv' => $endDiv);

        foreach ($format as $element) {
            $html .= $out[$element];
        }
        
        return $html;
    }

    public function hidden($fieldName, $options = array()) {
        $hiddenAttr = '';
        foreach ($options as $k => $v) {
            $hiddenAttr .= " $k=\"$v\"";
        }
        $hidden = '<input type="hidden" name="'.$fieldName.'" '.$hiddenAttr.'>';
        return $hidden;
    }

    public function textarea($fieldName, $options = array()) {
        $textareaAttr = '';
        foreach ($options as $k => $v) {
            if ($k != 'value') {
                $textareaAttr .= " $k=\"$v\"";
            }               
        }
        $textarea = '<textarea id="input'.$fieldName.'" name="'.$fieldName.'" '.$textareaAttr.'>'.$options['value'].'</textarea>';
        return $textarea;
    }

    public function select($fieldName, $options = array()){
        $class = (isset($options['class'])  ? 'class="'.$options['class'].'"' : null);
        $select = '<select id="input'.$fieldName.'" name="'.$fieldName.'" '.$class.'>';
        $select .= '<option value="0">- Sans catégorie -</option>';
        if (isset($options['attributes'])) {
            foreach ($options['attributes'] as $key) {
                if (isset($options['value']) AND $options['value'] == $key['id']) {
                    $checked = 'selected';
                }else{
                    $checked = '';
                }
                if (!empty($key['separator'])) {
                    $sep = '|'.$key['separator'].' ';
                }else{
                    $sep = '';
                }
                $select .= '<option value="'.$key['id'].'" '.$checked.'>'.$sep.''.$key['name'].'</option>';
            }
        }
        $select .= '</select>';
        return $select;
    }

    /**
     * [checkbox description]
     * @param  [type] $fieldName [description]
     * @param  array  $options   [description]
     * @return [type]            [description]
     * <?php echo $this->Form->inputForm('online',array(
     *   'type' => 'checkbox',
     *   'multiple' => true,
     *   'attributes' => array(
     *       'Value1' => 'Label 1',
     *       'Value2' => 'Label 2'
     *   ),
     *   'option' => array(
     *       'label' => array('class' => 'checkbox inline'),
     *   ),
     *   'selected' => array('Value1','Value2'),
     *   'label' => array('text' => 'En ligne :')
     *)); ?>
     */
    public function checkbox($fieldName, $options = array()){
        $checkbox = '';
        if (isset($options['multiple'])) {
            $class = (isset($options['option']['label']['class'])) ? $options['option']['label']['class'] : '';
            foreach ($options['attributes'] as $key => $value) {
                if (isset($options['selected']) AND in_array($key,$options['selected'])) {
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $checkbox .= '<label class="'.$class.'" for="input'.$value.'"><input type="checkbox" id="input'.$value.'" name="'.$fieldName.'[]" value="'.$key.'" '.$checked.'>'.$value.'</label>';
            }
        }else{
            if (empty($options['value']) OR $options['value'] == -1) {
                $checked = '';
            }else{
                $checked = 'checked';
            }
            if (!isset($options['hiddenField']) OR $options['hiddenField'] != false) {
                $checkbox = $this->hidden($fieldName,array('value' => 0));
                $checkbox .= '<input type="checkbox" id="input'.$fieldName.'" name="'.$fieldName.'" value="1" '.$checked.'>';
            }else{
                $checkbox = '<input type="checkbox" id="input'.$fieldName.'" name="'.$fieldName.'" value="1" '.$checked.'>';
            }
        }
        return $checkbox;
    }



    /**
     * [end description]
     * @param  [type] $options [description]
     * @return [type]          [description]
     * Exemple : echo $this->Form->end(array(
     *       'input' => array(
     *           'class' => 'btn btn-primary',
     *          'value' => 'Envoyer'
     *       ),
     *       'reset' => array(
     *           'class' => 'btn btn-danger',
     *           'style' => 'margin-left:5px',
     *           'value' => 'Effacer'
     *       ),
     *       'cancel' => array(
     *           'class' => 'btn btn-info',
     *           'style' => 'margin-left:5px',
     *           'url'   => 'cockpit/posts',
     *           'value' => 'Annuler'
     *       ),
     *       'div' => 'form-actions'
     *   ));
     */
    public function end($options = null){
        $html       = '';
        $div        = '';
        $endDiv     = '';
        $input      = '';
        $inputAttr  = '';
        $reset      = '';
        $resetAttr  = '';
        $cancel     = '';
        $cancelAttr = '';
        $endForm    = '</form>';
        $format     = (isset($options['format'])) ? $options['format'] : array('div','input','reset','cancel','endDiv','endForm');
        if ($options !== null) {
            if (is_string($options)) {
                $html .= '<div class="submit">';
                $html .= '<input type="submit" value="'.$options.'">';
                $html .= '</div>';
            }elseif (is_array($options)) {
                if (isset($options['div'])) {
                    if (is_string($options['div'])) {
                        $div = '<div class="'.$options['div'].'">';
                    }elseif (is_array($div)) {
                        foreach ($div as $k => $v) {
                            $divAttr .= " $k=\"$v\"";                    
                        }
                        $div = '<div '.$divAttr.'>';
                    }
                    $endDiv = '</div>';
                }
                if (isset($options['input'])) {
                    if (is_string($options['input'])) {
                            $input = '<input type="submit" value="'.$options['input'].'">';
                    }elseif (is_array($options['input'])) {
                        foreach ($options['input'] as $k => $v) {
                            $inputAttr .= " $k=\"$v\"";
                        }
                        $input = '<input type="submit" '.$inputAttr.'>';
                    }
                }
                if (isset($options['reset'])) {
                    if (is_string($options['reset'])) {
                            $reset = '<input type="reset" value="'.$options['reset'].'">';
                    }elseif (is_array($options['reset'])) {
                        foreach ($options['reset'] as $k => $v) {
                            $resetAttr .= " $k=\"$v\"";
                        }
                        $reset = '<input type="reset" '.$resetAttr.'>';
                    }
                }
                if (isset($options['cancel'])) {
                    if (is_string($options['cancel'])) {
                            $cancel = '<input type="button" value="'.$options['cancel'].'" >';
                    }elseif (is_array($options['cancel'])) {
                        foreach ($options['cancel'] as $k => $v) {
                            if ($k == 'url') {
                                $cancelAttr .= 'onclick="window.location=\''.Router::url($v).'\'"';
                            }else {
                                $cancelAttr .= " $k=\"$v\"";
                            }                            
                        }
                        $cancel = '<input type="button" '.$cancelAttr.' >';
                    }
                }
                $out = array('div' => $div, 'input' => $input, 'reset' => $reset, 'cancel' => $cancel, 'endDiv' => $endDiv, 'endForm' => $endForm);
                foreach ($format as $element) {
                    $html .= $out[$element];
                }
            }
        }else {
            $html = $endForm;
        }


        return $html;
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
            $html .= '<input type="hidden" name="'.$name.'" value="0"><input type="checkbox" id="input'.$name.'" name="'.$name.'" value="1" '.(empty($value) ? '' : 'checked').'>';
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

} 
?>