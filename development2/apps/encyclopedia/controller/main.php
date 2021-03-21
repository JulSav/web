<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak, Julia Savitskaya
 * @global object $CORE
 * @package Controller\Main
 */
namespace Controller;

class Main
{
    use \Library\Shared;

    private $model;
 
    private function isCorrect($var, $pattern)
    {
        $file_pattern = ROOT . 'model/config/patterns.php';
        if (file_exists($file_pattern)) {
            include $file_pattern;
        };

        $my_var = null;
        if ($pattern != null) {
            if (preg_match($regex[$pattern], $var)) {
                $my_var =  $var;
            } elseif ($pattern == 'phone') {
                $my_var = $callbacks[$pattern];
            }
        }
        return $my_var;
    }


    private function getParams($details)
    {
        $request = [];
        foreach ($details['params'] as $param) {
            $var = $this->getVar($param['name'], $param['source']);
            if ($var) {
                if ($this->isCorrect($var, $param['pattern']) != null) {
                    $request[$param['name']] = $this->isCorrect($var, $param['pattern']);
                } else {
                    throw new \Exception("REQUEST_INCORRECT");
                }
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
            $file_pattern = ROOT . 'model/config/patterns.php';
            if (file_exists($file_pattern)) {
                include $file_pattern;
            };
            if (file_exists($file)) {
                include $file;
                if (isset($methods[$path[2]])) {
                    $details = $methods[$path[2]];
                    $request = [];
                    $request = $this->getParams($details);
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
