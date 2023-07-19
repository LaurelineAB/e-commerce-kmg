<?php

class UserController extends AbstractController {

    private UserManager $userManager;
    private OrderManager $orderManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->orderManager = new OrderManager();
    }

    public function index()
    {
        $allUsers = $this->userManager->getAllUsers();
        $allOrders = $this->orderManager->getAllOrders();
        var_dump($allUsers);
        var_dump($allOrders);
        $this->render('index', ["users" => $allUsers, "orders" => $allOrders]);

    }



    public function createUser()
    {
        $this->render('users/create.phtml', []);
        if(isset($_POST['submit-create-user']))
        {
            $user = new User($_POST['firstname'], $_POST['lastname'],$_POST['email'], $_POST['password']);
            $this->userManager->insertUser($user);
            $allUsers = $this->userManager->getAllUsers();
            // $this->render('users/create.phtml', ['user' => $user]);
        }
        else
        {
            $allUsers = $this->userManager->getAllUsers();
            $this->render('create_user', ['users' => $allUsers]);
        }
    }


    public function editUser($id){

        if(isset($_POST['firstname'], $_POST['lastname']))
        {
            $user = new User($_SESSION['id'], $_POST['firstname'], $_POST['lastname'],$_POST['password'],$_POST['email']);
            $this->userManager->updateUser($id);
            $allUsers = $this->userManager->getAllUsers();
            $this->render('edit_user', ['users' => $allUsers]);
        } else{
            $allUsers = $this->userManager->getAllusers();
            $this->render('index_user', ['users' => $allUsers]);
        }

    }


    public function delete(int $Id)
    {
        $this->userManager->deleteUser($Id);
        $allUsers = $this->userManager->getAllUsers();
        $this->render('delete_user', ['users' => $allUsers]);
    }




    public function read(int $userId)
    {
        $user = $this->userManager->getUserById($userId);

        if ($user !== null) {
            $this->render('read_user', ['user' => $user]);
        } else {
            echo'user non trouvé';
        }
    }

    // public function readAll()
    // {

    // }
}

?>