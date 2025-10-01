<?php


use PHPUnit\Framework\TestCase;

use Controller\UserController;
use Model\User;

class UserTest extends TestCase
{

    private $usercontroller;
    private $mockUserModel;

    protected function setUp(): void
    {
        $this->mockUserModel = $this->createMock(user::class);

        $this->usercontroller = new UserController($this->mockUserModel);
    }

    #[PHPUnit\Framework\Attributes\Test]

    public function it_should_be_able_to_create_user()
    {

        //Esta linha serve para acessar o metodo de registro, com base nos dados obtidos na função createUSer e ligando ao bd
        $this->mockUserModel->method('registerUser')->willReturn(true);

        $userResult = $this->usercontroller->createUser('Ana luisa Santos', 'ana@example.com', '123456');

        $this->assertTrue($userResult);
    }

    #[PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_sign_in()
    {

        //verificando se email e senha são os mesmos
        $this->mockUserModel->method('getUserByEmail')->willReturn([
            'id' => 1,
            'user_fullname' => 'Ana luisa Santos',
            'email' => 'ana@example.com',
            'password' => password_hash('123456', PASSWORD_DEFAULT),

        ]);

        $userResult = $this->usercontroller->login('ana@example.com', '123456');

        $this->assertTrue($userResult);
        $this->assertEquals(1, $_SESSION['id']);
        $this->assertEquals('Ana luisa Santos', $_SESSION['user_fullname']);
        $this->assertEquals('ana@example.com', $_SESSION['email']);

    }

    #[PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_login_with_invalid_credentials()
    {
        //verificando se email e senha são os mesmos, obtendo os mesmos dados para compara-los e também verificar o retorno
        $this->mockUserModel->method('getUserByEmail')->willReturn([
            'id' => 1,
            'user_fullname' => 'Ana luisa Santos',
            'email' => 'ana@example.com',
            'password' => password_hash('123456', PASSWORD_DEFAULT),

        ]);

        $userResult = $this->usercontroller->login('ana@example.com', '12345');
        $this->assertFalse($userResult);

    }


    #[PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_check_user_by_email()
    {

        //verificando se email e senha são os mesmos
        $this->mockUserModel->method('getUserByEmail')->willReturn([
            'id' => 1,
            'user_fullname' => 'Ana luisa Santos',
            'email' => 'ana@example.com',
            'password' => '$2y$12$CJuswFY4.ylUp5RBqQOQpuDcDZJZeQILuAZBAP3iJcGwMjN3F0mO6'

        ]);

        $userResult = $this->usercontroller->checkUserByEmail('ana@example.com');
        $this->assertNotNull($userResult);
        $this->assertEquals('ana@example.com', $userResult['email']);

    }


    #[PHPUnit\Framework\Attributes\Test]
    public function it_should_verify_if_is_logged_in()
    {
        $_SESSION['id'] = 1;
        $userResult = $this->usercontroller->isLoggedIn();

        $this->assertTrue($userResult);

    }



}


?>