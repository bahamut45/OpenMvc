<?php 
/**
* 
*/
class Model{

    static $connections = array();
    
    public $conf  = 'default';
    public $table = false;
    public $db;
    public $primaryKey = 'id';
    public $id;
    public $errors = array();
    public $form;
    public $validate = array();

    /**
     * Permet d'initialiser les variables du Model
     */
    public function __construct(){
        // J'initialise quelques variables 
        if ($this->table === false) {
            $this->table = strtolower(get_class($this)).'s';
        }
        // Je me connecte à la base
        $conf = Conf::$databases[$this->conf];
        if (isset(Model::$connections[$this->conf])) {
            $this->db = Model::$connections[$this->conf];
            return true;
        }
        try {
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8;SET lc_time_names = "fr_FR"',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
            );
            $pdo = new PDO(
                'mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
                $conf['login'],
                $conf['password'],
                $options
            );
            //$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING); 
            Model::$connections[$this->conf] = $pdo;
            $this->db = $pdo;
        } catch (PDOException $e) {
            if (Conf::$debug >= 1) {
                die($e->getMessage());
            }else {
                die('Impossible de se connecter à la base de donnée');
            }
        }
    }

    /**
     * Permet de valider des données
     * @param  [type] $data données à valider
     */
    function validates($data){
        $errors = array();
        foreach ($this->validate as $k => $v) {
            if (!isset($data->$k)) {
                $errors[$k] = $v['message'];
            }else{
                if ($v['rule'] == 'notEmpty'){
                    if (empty($data->$k) && $data->$k !=="0") {
                        $errors[$k] = $v['message'];
                    }
                }elseif (!preg_match('/^'.$v['rule'].'$/', $data->$k)) {
                    $errors[$k] = $v['message'];
                }
            }
        }
        $this->errors = $errors;
        if (isset($this->Form)) {
            $this->Form->errors = $errors;
        }
        if (empty($errors)) {
            return true;
        }
        return false;
    }

    /**
     * Permet d'ajouter automatiquement le prefixe du nom de table 
     * @param [type] $value [description]
     */
    private function addTableNameFields($fields,$alias = null){
        $explode = array();
        $return = array();
        if(isAssoc($fields)) {
            foreach ($fields as $key => $value) {
                $return[] = $alias.'.'.$key.' as '.$value;
            }
        }else {
            foreach ($fields as $k) {
                $explode = explode(',',$k);
                foreach ($explode as $value) {
                    $return[] = get_class($this).'.'.$value;
                }
            }
        }  
        return $return;
    }

    /**
     * Permet de récuperer plusieurs enregistrements
     * @param  array $req contient les éléments de la requete
     * @return [type]      [description]
     */
    public function find($req = array()){
        $sql = 'SELECT ';
        $join = '';

        //Construction de la liste des champs
        if (isset($req['fields'])) {
            if(is_array($req['fields'])){
                $sql .= implode(',',$this->addTableNameFields($req['fields']));
            }elseif ($req['fields'] === false){
                $sql .= '';
            }else{
                $sql .= $req['fields'];
            }            
        }else{
            $sql .= '*';
        }

        //Construction des cases
        if (isset($req['case'])) {
            $sql .= ','.$req['case'];
        } 

        //Construction des functions mysql
        if (isset($req['functions'])) {
            if (is_array($req['functions'])) {
                if ($req['fields'] === false) {
                    $sql .= implode(',',$req['functions']);
                }else {
                    $sql .= ','.implode(',',$req['functions']);
                }
            }else{
                if ($req['fields'] === false) {
                    $sql .= $req['function'];
                }else {
                    $sql .= ','.$req['function'];
                }                
            }            
        } 

        //Construction des jointures
        if(isset($req['joins'])) {
            $nbjoins = count($req['joins']);
            for($i = 0; $i < $nbjoins; $i++) {
                if(isset($req['joins'][$i]['fields'])) {
                    if (is_array($req['joins'][$i]['fields'])) {
                        $sql .= ','.implode(',', $this->addTableNameFields($req['joins'][$i]['fields'],$req['joins'][$i]['as']));
                    }else{
                        $sql .= ','.$req['joins'][$i]['as'].'.'.$req['joins'][$i]['fields'];
                    }
                }
                $join .= ' '.strtoupper($req['joins'][$i]['type']).' JOIN '.strtolower($req['joins'][$i]['table']).' as '.$req['joins'][$i]['as'];
                $join .= ' ON '.$req['joins'][$i]['conditions'];
            }
        }

        $sql .= ' FROM '.$this->table.' as '.get_class($this).' '.$join;

        //Construction de la condition
        if (isset($req['conditions'])) {
            $sql .= ' WHERE ';
            if(!is_array($req['conditions'])){
                $sql .= $req['conditions'];
            }else{
                $cond = array();
                foreach ($req['conditions'] as $k => $v) {
                    if (!is_numeric($v)) {
                        $v = $this->db->quote($v);
                    }
                    $cond[] = "$k=$v";
                }
                $sql .= implode(' AND ', $cond);
            }
        }

        //Construction de Group
        if (isset($req['group'])) {
            $sql .= ' GROUP BY ' . $req['group'];
        }

        // Construction de l'ordre
        if(isset($req['orderDesc'])){
            $sql .= ' ORDER BY ' . $req['orderDesc'] . ' DESC';
        }

        if(isset($req['orderAsc'])){
            $sql .= ' ORDER BY ' . $req['orderAsc'] . ' ASC';
        }

        //Construction de la limite
        if (isset($req['limit'])) {
            $sql .= ' LIMIT '.$req['limit'];
        }

        //die($sql);
        //echo $sql.'<br />';

        $pre = $this->db->prepare($sql);
        $pre->execute();
        // permet de compter le nombre de requete 
        if (!isset($_SESSION['CountSql'])) {
            $_SESSION['CountSql'] = $sql.' | ';
        }else{
            $_SESSION['CountSql'] .= $sql.' | ';            
        }
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }

    public function findFirst($req){
        return current($this->find($req));
    }

    public function findCount($conditions = null){
        if (is_null($conditions)) {
            $res = $this->findFirst(array(
                'fields' => 'COUNT('.$this->primaryKey.') as count'
            ));
        }else{
            $res = $this->findFirst(array(
                'fields' => 'COUNT('.$this->primaryKey.') as count',
                'conditions' => $conditions
            ));
        }
        return $res->count;
    }

    public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = $id ";
        $this->db->query($sql);
    }

    public function save($data){
        $key = $this->primaryKey;
        $fields = array();
        $d = array();

        foreach ($data as $k => $v) {
            if ($k != $this->primaryKey) {
                $fields[] = "$k=:$k";
                $d[":$k"] = $v;
            }elseif (!empty($v)) {
                $d[":$k"] = $v;
            }
        }
        if (isset($data->$key) && !empty($data->$key)) {
            $sql = 'UPDATE '.$this->table.' SET '.implode(',',$fields).' WHERE '.$key.'=:'.$key ;
            $this->id = $data->$key;
            $action = 'update';
        }else{
            $sql = 'INSERT INTO '.$this->table.' SET '.implode(',',$fields);
            $action = 'insert';
        }

        //die($sql);
        $pre = $this->db->prepare($sql);
        $pre->execute($d);
        if ($action == 'insert') {
            $this->req_id = $this->db->lastInsertID();
        }
    }
} 

?>