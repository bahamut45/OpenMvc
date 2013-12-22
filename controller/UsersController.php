<?php 
/**
* 
*/
class UsersController extends Controller{
    
    /**
     * Login
     */
    function login(){
        $this->loadModel('User');
        if ($this->request->data) {
            if ($this->User->validates($this->request->data)) {
                $data = $this->request->data;
                $data->password = sha1($data->password);
                $user = $this->User->findFirst(array(
                    'conditions' => array(
                        'login' => $data->login,
                        'password' => $data->password,
                    )
                ));
                if (!empty($user)) {
                    $this->Session->write('User',$user);
                    $this->Session->setFlash('Vous êtes maintenant connecté');
                }else{
                    $this->Session->setFlash('Merci de corriger vos informations','error');
                }
            }else{
                $this->Session->setFlash('Merci de corriger vos informations','error');
            }
            $this->request->data->password = '';
        }
        if ($this->Session->isLogged()) {
            if ($this->Session->user('role') == 'admin') {
                $this->redirect('cockpit');
            }else{
                $this->redirect('');
            }
        }
    }
    /**
     * Logout
     */
    function logout(){
        unset($_SESSION['User']);
        $this->Session->setFlash('Vous êtes maintenant déconnecté');
        $this->redirect('');
    }
}

?>