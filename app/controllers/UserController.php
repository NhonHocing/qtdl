<?php
class UserController extends Controller {
    public function list() {
        $userModel = $this->model('User');
        $users = $userModel->getAll();
        $this->view('user_list', ['users' => $users]);
        

    }

}

