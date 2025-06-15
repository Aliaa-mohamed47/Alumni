<?php
require_once '../../Models/admin.php';
require_once '../../Models/alumni.php';
require_once '../../Models/student.php';

class UserFactory {
    public static function createUser($role) 
    {
        switch (strtolower($role)) 
        {
            case 'admin':
                return new Admin();
            case 'alumni':
                return new Alumni();
            case 'student':
                return new Student();
            default:
                throw new Exception("Invalid role");
        }
    }
}

