<?php

namespace Core\Services;


use Core\Config\Config;
use Core\Session\Session;
use Core\Db\Sqlite;
use Core\Auth\Auth;
use Core\Auth\UserManager;
use Core\Template\Template;
use Core\Router\Request;

class Services
{
    private static $db = null;
    private static $session = null;
    private static $userManager = null;
    private static $auth = null;
    private static $template = null;
    private static $request = null;

    public function __construct($templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    public static function Db()
    {
        if (!empty(self::$db)) {
            return self::$db;
        }

        $dbPath = ROOT_PATH . Config::$db;
        self::$db = new Sqlite();
        self::$db->open($dbPath);

        return self::$db;
    }

    public static function Session()
    {
        if (!empty(self::$session)) {
            return self::$session;
        }

        self::$session = new Session();

        return self::$session;
    }

    public static function UserManager()
    {
        if (!empty(self::$userManager)) {
            return self::$userManager;
        }

        $db = Services::Db();
        self::$userManager = new UserManager($db);

        return self::$userManager;
    }

    public static function Auth()
    {
        if (!empty(self::$auth)) {
            return self::$auth;
        }

        $session = new Session();
        $userManager = self::UserManager();
        self::$auth = new Auth($session, $userManager);

        return self::$auth;
    }

    public static function Template()
    {
        if (!empty(self::$template)) {
            return self::$template;
        }

        $templatesPath = ROOT_PATH . Config::$templates;

        self::$template = new Template($templatesPath);

        return self::$template;
    }
    
    public static function Request()
    {
        if (!empty(self::$request)) {
            return self::$request;
        }


        self::$request = new Request();

        return self::$request;
    }
}