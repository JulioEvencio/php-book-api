<?php

    class Application {

        public function execute() {
            $url = isset($_GET['url']) ? explode('/', $_GET['url'])[0] : 'Home';
            $url = ucfirst($url);
            $url .= 'Controller';

            if (file_exists('./app/controllers/'.$url.'.php')) {
                require_once('./app/controllers/'.$url.'.php');

                $controller = new $url();
                $controller->execute();
            } else {
                $data = array('errors' => ['status' => '404', 'title' => 'Not Found', 'detail' => 'Resource not found...']);
                $json = json_encode($data);

                http_response_code(404);

                echo $json;
            }
        }

    }

?>