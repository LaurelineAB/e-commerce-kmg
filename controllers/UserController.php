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
            if($_POST['password'] === $_POST['confirm-password'])
            {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $user = new User($_POST['firstName'], $_POST['lastName'],$_POST['email'], $password);
                $this->userManager->insertUser($user);
                $allUsers = $this->userManager->getAllUsers();
                // $this->render('users/create.phtml', ['user' => $user]);
            }
        }
        else
        {
            $allUsers = $this->userManager->getAllUsers();
            $this->render('create_user', ['users' => $allUsers]);
        }
    }


    public function editUser()
    {
        if(isset($_POST['submit-edit-user']))
        {
            $user = new User($_POST['firstName'], $_POST['lastName'],$_POST['password'],$_POST['email']);
            $user->setId($_SESSION['user']->getId());
            $this->userManager->updateUser($user);
            $allUsers = $this->userManager->getAllUsers();
            $this->render('edit-user', ['users' => $allUsers]);
        } 
        else
        {
            $this->render('edit-user', []);
        }
    }


    // public function deleteUser()
    // {
    //     $this->userManager->deleteUser($Id);
    //     $allUsers = $this->userManager->getAllUsers();
    //     $this->render('delete_user', ['users' => $allUsers]);
    // }


    public function read()
    {
        if(isset($_POST['submit-login']))
        {
            $user = $this->userManager->getUserByEmail($_POST['email']);
            if(password_verify($_POST['password'], $user->getPassword()));
            {
                $_SESSION['user'] = $user;
            }
            
        }
        // $user = $this->userManager->getUserById($userId);

        // if ($user !== null) {
        //     $this->render('read_user', ['user' => $user]);
        // } else {
        //     echo'user non trouvé';
        // }
    }

    // public function readAll()
    // {

    // }
}

?>