<?php
ini_set('display_errors', 1);

session_start();


$app = App::app()->run();
exit;

class User
{
    public int $id = 0;
    public string $login = '';
    public string $password = '';
    public string $session_id = '';
    public string $role = '';

    public static function create(string $login, string $password, string $role): void
    {
        $query_row = sprintf("INSERT INTO users (login,password,role) VALUES ('%s', '%s', '%s')", $login, $password, $role);
        App::app()->mysql()->query($query_row);
    }

    public static function findBySessionId(string $id): ?self
    {
        $item = null;
        $query_row = sprintf("SELECT * FROM users WHERE session_id ='%s'", $id);
        $query = App::app()->mysql()->query($query_row);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            $item = new User();
            $item->id = $result[0]['id'];
            $item->login = $result[0]['login'];
            $item->password = $result[0]['password'];
            $item->session_id = $result[0]['session_id'];
            $item->role = $result[0]['role'];
        }

        return $item;
    }

    public static function findByLoginPassword(string $login, string $password): ?self
    {
        $item = null;
        $query_row = sprintf("SELECT * FROM users WHERE login ='%s' and password = '%s'", $login, $password);
        $query = App::app()->mysql()->query($query_row);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            $item = new User();
            $item->id = $result[0]['id'];
            $item->login = $result[0]['login'];
            $item->password = $result[0]['password'];
            $item->role = $result[0]['role'];
            $item->saveSession(session_id());
        }
        return $item;
    }

    public function saveSession(string $session_id): void
    {
        $query_row = sprintf("UPDATE users SET session_id = '%s' WHERE id = %d", $session_id, $this->id);
        App::app()->mysql()->query($query_row);
        $this->session_id = $session_id;
    }

    public static function getAll(): array
    {
        $items = [];
        $query_row = sprintf("SELECT * FROM users");
        $query = App::app()->mysql()->query($query_row);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $data) {
            $item = new self();
            $item->id = $data['id'];
            $item->login = $data['login'];
            $item->password = $data['password'];
            $item->session_id = $data['session_id'];
            $item->role = $data['role'];
            $items[] = $item;
        }

        return $items;
    }

    public static function findById(string $id): ?self
    {
        $item = null;
        $query_row = sprintf("SELECT * FROM users WHERE id ='%d'", $id);
        $query = App::app()->mysql()->query($query_row);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            $item = new self();
            $item->id = $result[0]['id'];
            $item->login = $result[0]['login'];
            $item->password = $result[0]['password'];
            $item->role = $result[0]['role'];
            $item->session_id = $result[0]['session_id'];
        }

        return $item;
    }

    public function save(): void
    {
        $query_row = sprintf("UPDATE users SET login = '%s', password= '%s', role= '%s' WHERE id = %d", $this->login, $this->password, $this->role, $this->id);
        App::app()->mysql()->query($query_row);
    }

    public function delete(): void
    {
        $query_row = sprintf("DELETE FROM users WHERE id = %d", $this->id);
        App::app()->mysql()->query($query_row);
    }
}

class Order
{
    public $id;
    public $param_1;
    public $param_2;
    public $param_3;

    public static function create(string $param_1, string $param_2, string $param_3): void
    {
        $query_row = sprintf("INSERT INTO orders (param_1,param_2,param_3) VALUES ('%s', '%s', '%s')", $param_1, $param_2, $param_3);
        App::app()->mysql()->query($query_row);
    }

    public function save(): void
    {
        $query_row = sprintf("UPDATE orders SET param_1 = '%s', param_2= '%s', param_3= '%s' WHERE id = %d", $this->param_1, $this->param_2, $this->param_3, $this->id);
        App::app()->mysql()->query($query_row);
    }

    public function delete(): void
    {
        $query_row = sprintf("DELETE FROM orders WHERE id = %d", $this->id);
        App::app()->mysql()->query($query_row);
    }

    public static function getAll(): array
    {
        $items = [];
        $query_row = sprintf("SELECT * FROM orders");
        $query = App::app()->mysql()->query($query_row);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $data) {
            $item = new Order();
            $item->id = $data['id'];
            $item->param_1 = $data['param_1'];
            $item->param_2 = $data['param_2'];
            $item->param_3 = $data['param_3'];
            $items[] = $item;
        }

        return $items;
    }

    public static function findById(string $id): ?self
    {
        $item = null;
        $query_row = sprintf("SELECT * FROM orders WHERE id ='%d'", $id);
        $query = App::app()->mysql()->query($query_row);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            $item = new Order();
            $item->id = $result[0]['id'];
            $item->param_1 = $result[0]['param_1'];
            $item->param_2 = $result[0]['param_2'];
            $item->param_3 = $result[0]['param_3'];
        }

        return $item;
    }
}

class App
{
    private static ?self $app = null;

    public ?PDO $mysql = null;
    public ?User $user = null;

    public static function app(): self
    {
        if (!self::$app) {
            self::$app = new self();
        }
        return self::$app;
    }

    public function run(): void
    {
        $this->user = $this->getUser();
        if (!$this->user) {
            $this->toLoginPage();
        }

        if ($this->isRoute('add')) {
            $this->toEditPage();
        } elseif ($this->isRoute('edit')) {
            $id = $this->getItemId();
            $this->toEditPage($id);
        } elseif ($this->isRoute('delete')) {
            $id = $this->getItemId();
            $this->toDeletePage($id);
        } elseif ($this->isRoute('logout')) {
            $this->logout();
        } elseif ($this->isRoute('users')) {
            $this->toUserPage();
        } elseif ($this->isRoute('addUser')) {
            $this->toUserEditPage();
        } elseif ($this->isRoute('editUser')) {
            $id = $this->getItemId();
            $this->toUserEditPage($id);
        } elseif ($this->isRoute('deleteUser')) {
            $id = $this->getItemId();
            $this->toDeleteUserPage($id);
        } else {
            $this->toMainPage();
        }
    }

    private function getUser(): ?User
    {
        $session_id = session_id() ? session_id() : '';
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findBySessionId($session_id);

        if (!$user && ($login && $password)) {
            $user = User::findByLoginPassword($login, $password);
        }

        return $user;
    }

    public function mysql(): PDO
    {
        return new PDO('mysql:dbname=tz_olkon;host=127.0.0.1', 'tz_olkon_user', 'tz_olkon_pass');
    }

    private function toLoginPage(): void
    {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';
        $error  = '';
        if ($login || $password) {
            $error = 'НЕВЕРНО ВВЕДЁН ЛОГИН ИЛИ ПАРОЛЬ';
        }
        require_once './pages/login.php';
        exit;
    }

    private function toMainPage(): void
    {
        $isAdmin = $this->user->role === 'admin';
        $items = Order::getAll();
        require_once './pages/main.php';
        exit;
    }

    private function toUserPage(): void
    {
        $isAdmin = $this->user->role === 'admin';
        if (!$isAdmin) {
            header('location: /');
        }
        $items = User::getAll();
        require_once './pages/users.php';
        exit;
    }

    private function isRoute(string $route): bool
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        return explode('/', $uri)[1] === $route;
    }

    private function getItemId(): int
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        return explode('/', $uri)[2] ?? 0;
    }

    private function toUserEditPage(int $itemId = 0): void
    {
        $id = $_POST['id'] ?? null;
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;
        $role = $_POST['role'] ?? null;
        $error = '';

        if (is_null($id) || is_null($login) || is_null($password) && is_null($role)) {
            $item = null;
            if ($itemId != 0) {
                $item = User::findById($itemId);
            }

            if ($item) {
                $id = $item->id;
                $login = $item->login;
                $password = $item->password;
                $role = $item->role;
            }

            require_once './pages/addUser.php';
            exit;
        } else {
            $item = null;
            if ($id != 0) {
                $item = User::findById($id);
            }

            if ($item) {
                $item->login = $login;
                $item->password = $password;
                $item->role = $role;
                $item->save();
            } else {
                if (!$login || !$password || !$role) {
                    $error = "Вы должны заполнить все поля!";
                    require_once './pages/addUser.php';
                    exit;
                }
                User::create($login, $password, $role);
            }
            header('location: /users');
        }
        exit;
    }

    private function toEditPage(int $itemId = 0): void
    {
        $id = $_POST['id'] ?? null;
        $param_1 = $_POST['param_1'] ?? null;
        $param_2 = $_POST['param_2'] ?? null;
        $param_3 = $_POST['param_3'] ?? null;

        if (is_null($id) || is_null($param_1) || is_null($param_2) && is_null($param_3)) {
            $item = null;
            if ($itemId != 0) {
                $item = Order::findById($itemId);
            }

            if ($item) {
                $id = $item->id;
                $param_1 = $item->param_1;
                $param_2 = $item->param_2;
                $param_3 = $item->param_3;
            }

            require_once './pages/add.php';
            exit;
        } else {
            $item = null;
            if ($id != 0) {
                $item = Order::findById($id);
            }

            if ($item) {
                $item->param_1 = $param_1;
                $item->param_2 = $param_2;
                $item->param_3 = $param_3;
                $item->save();
            } else {
                Order::create($param_1, $param_2, $param_3);
            }
            header('location: /');
        }
        exit;
    }

    private function toDeletePage(int $itemId = 0): void
    {
        $item = null;
        if ($itemId != 0) {
            $item = Order::findById($itemId);
        }

        if ($item) {
            $item->delete();
        }
        header('location: /');

        exit;
    }

    private function toDeleteUserPage(int $itemId = 0): void
    {
        $item = null;
        if ($itemId != 0) {
            $item = User::findById($itemId);
        }

        if ($item) {
            $item->delete();
        }
        header('location: /users');

        exit;
    }

    private function logout(): void
    {
        session_unset();
        $this->user->saveSession('');
        header('location: /');
        exit;
    }
}
