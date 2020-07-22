<?php


namespace App\Tests\Entity;


use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Unit Entity.
 *
 * Class UserTest
 * @package App\Tests\Entity
 */

class UserTest extends TestCase
{

    public function testSetUserName() : void {
        $user = new User();
        $test_username = "tester";
        $user->setUsername($test_username);
        $this->assertEquals($test_username, $user->getUsername());
    }

    public function testSetEmail() : void {
        $user = new User();
        $user_email = "someone@example.com";
        $user->setEmail($user_email);
        $this->assertEquals($user_email, $user->getEmail());
    }

    public function testSetFirstName() : void {
        $user = new User();
        $test_user_name = "Someone";
        $user->setFirstName($test_user_name);
        $this->assertEquals($test_user_name, $user->getFirstName());
    }

    public function testSetLastName() : void {
        $user = new User();
        $test_user_name = "Somewhere";
        $user->setLastName($test_user_name);
        $this->assertEquals($test_user_name, $user->getLastName());
    }

    public function testSetPassword() : void {
        $user = new User();
        $test_password = "dsfdlasa534534534sasadsadadsaggghjj";
        $user->setPassword($test_password);
        $this->assertEquals($test_password, $user->getPassword());
    }

    public function testSetPhone() : void {
        $user = new User();
        $test_phone = "02204246521";
        $user->setPhone($test_phone);
        $this->assertEquals($test_phone, $user->getPhone());
    }

    public function testSetRoles() : void {
        $user = new User();
        $test_role = ["ROLE_ADMIN"];
        $expected = [0 => "ROLE_ADMIN", 1 => "ROLE_USER"];
        $user->setRoles($test_role);
        $this->assertEquals($expected, $user->getRoles());
    }

}