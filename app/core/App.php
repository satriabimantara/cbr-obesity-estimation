<?php
class App
{
    protected $controller_default = "home";
    protected $method_default = "index";
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        // Controller
        if (file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller_default = $url[0];
            unset($url[0]);
        }
        require_once '../app/controllers/' . $this->controller_default . '.php';
        $this->controller_default = new $this->controller_default;
        // Method
        if (isset($url[1])) {
            if (method_exists($this->controller_default, $url[1])) {
                $this->method_default = $url[1];
                unset($url[1]);
            }
        }
        // Params
        if (!empty($url)) {
            $this->params = array_values($url);
        }
        // Jalankan controller dan method serta kirimkan parameter jika ada
        call_user_func_array([$this->controller_default, $this->method_default], $this->params);
    }
    public function parseURL()
    {
        if (isset($_GET['url'])) {
            // Bersihkan url dahulu kemudian pecah menjadi array
            $url = $_GET['url'];
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
