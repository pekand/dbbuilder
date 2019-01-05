<?php

namespace Core\Template;

class Template
{
    private static $blocks = [];

    private $templatesPath = "";

    public function __construct($templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    public function render($path, $params = array())
    {
        $template = $this;
        extract($params);

        $templateFile = $this->templatesPath. DIRECTORY_SEPARATOR . $path . ".php";

        if (file_exists($templateFile)) {
            $tmplate = $this;
            ob_start();
            include $templateFile;
            return ob_get_clean();
        }

        return null;
    }

    public function blockStart($name)
    {
        self::$blocks[$name] = "";
        ob_start();        
    }

    public function blockEnd($name)
    {
        $content = ob_get_clean();
        self::$blocks[$name] = $content;
    }

    public function blockInsert($name, $default = "")
    {
        echo isset(self::$blocks[$name])?self::$blocks[$name]:$default;
    }

    public function extend($path, $params = array())
    {
        $templateFile = $this->templatesPath. DIRECTORY_SEPARATOR . $path . ".php";

        if (file_exists($templateFile)) {
            $tmplate = $this;
            extract($params);
            include $templateFile;
        }
    }
}