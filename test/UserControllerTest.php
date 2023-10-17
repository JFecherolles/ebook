<?php

use PHPUnit\Framework\TestCase;
use Ebook\Controllers\UserController;

class UserControllerTest extends TestCase
{
    public function testPasswordValidation()
    {
        $userController = new UserController();

        $validPasswords = [
            'StrongPassword123',
            'AnotherValidPassword123!',
        ];

        $invalidPasswords = [
            'Weak',
            'Invalid@',
            'Short1!',
        ];

        foreach ($validPasswords as $password) {
            $this->assertTrue($userController->validatePassword($password));
        }

        foreach ($invalidPasswords as $password) {
            $this->assertFalse($userController->validatePassword($password));
        }
    }
}
