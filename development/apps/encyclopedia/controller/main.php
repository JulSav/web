<?php
/**
 * User Controller
 *
 * @author Julia Savitskaya
 * @global object $CORE
 * @package Controller\Main
 */
namespace Controller;

class Main
{
    use \Library\Shared;

    private $model;
 
    private function checkPhone($var, $name)
    {
        $file_pattern = ROOT . 'model/config/patterns' . '.php';
        if (file_exists($file_pattern)) {
            include $file_pattern;
        }

        if ($name == 'phone') {
            if (preg_match($regex['phone'], $var)) {
                $phone = $var;
            } else {
                $patterns = [];
                $patterns[0] = '/^0/';
                $patterns[1] = '/^80/';
                $patterns[2] = '/^380/';
                $replacements = '+380';
                $phone =  preg_replace($patterns, $replacements, $var);
            }
        } else {
            $phone = $var;
        }
        return $phone;
    }

    private function checkPattern($var, $pattern)
    {
        if ($pattern != null) {
            if (preg_match($pattern, $var)) {
                return $var;
            } else {
                throw new \Exception("REQUEST_INCORRECT");
            }
        }
    }

    private function checking($details)
    {
        $request = [];
        foreach ($details['params'] as $param) {
            $var = $this->getVar($param['name'], $param['source']);
            if ($var) {
                $request[$param['name']] = $this->checkPhone($var, $param['name']);
                $request[$param['name']] = $this->checkPattern($var, $param['pattern']);
            } elseif (!$var && $param['required'] == true) {
                throw new \Exception("REQUEST_INCOMPLETE");
            } else {
                $request[$param['name']] = 'default';
            }
        }
        return $request;
    }
 


    public function exec():?array
    {
        $result = null;
        $url = $this->getVar('REQUEST_URI', 'e');
        $path = explode('/', $url);
        if (isset($path[2]) && !strpos($path[1], '.')) {
            $file = ROOT . 'model/config/methods/' . $path[1] . '.php';
            if (file_exists($file)) {
                include $file;
                if (isset($methods[$path[2]])) {
                    $details = $methods[$path[2]];
                    $request = [];
                    $request = $this->checking($details);
                    if (method_exists($this->model, $path[1] . $path[2])) {
                        $method = [$this->model, $path[1] . $path[2]];
                        if ($request == null) {
                            throw new \Exception("REQUEST_INCOMPLETE");
                        } else {
                            $result = $method($request);
                        }
                    }
                }
            }
        }

        return $result;
    }
    
    public function __construct()
    {
        // CORS configuration
        $origin = $this -> getVar('HTTP_ORIGIN', 'e');
        $domain = $this -> getVar($_SERVER['FRONT'], 'e');
        foreach ([$domain] as $allowed) {
            if ($origin == "https://$allowed") {
                header("Access-Control-Allow-Origin: $origin");
                header('Access-Control-Allow-Credentials: true');
            }
        }
        $this->model = new \Model\Main;
    }
}
