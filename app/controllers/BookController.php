<?php

    require_once('./app/models/BookModel.php');

    class BookController {

        private $bookModel;

        public function __construct() {
            $this->bookModel = new BookModel();
        }

        public function execute() {
            $method = $_SERVER['REQUEST_METHOD'];

            switch ($method) {
                case 'GET':
                    Router::execute('book', function () {
                        self::findAll();
                    });

                    Router::execute('book/?', function ($par) {
                        self::findById($par[1]);
                    });

                case 'POST':
                    Router::execute('book', function () {
                        self::create();
                    });

                case 'PUT':
                    Router::execute('book/?', function ($par) {
                        self::update($par[1]);
                    });

                case 'DELETE':
                    Router::execute('book/?', function ($par) {
                        self::delete($par[1]);
                    });
            }

            $data = array('errors' => ['status' => '404', 'title' => 'Not Found', 'detail' => 'Resource not found...']);
            $json = json_encode($data);

            http_response_code(404);

            echo $json;
        }

        public function findAll() {
            $data = $this->bookModel->findAll();
            $json = json_encode($data);

            http_response_code(200);

            echo $json;
        }

        public function findById($id) {
            $data = null;

            if (is_numeric($id)) {
                $data = $this->bookModel->findById($id);
            }

            if ($data == null) {
                $data = array('errors' => ['status' => '404', 'title' => 'Not Found', 'detail' => 'Book not found...']);

                http_response_code(404);
            } else {
                http_response_code(200);
            }

            $json = json_encode($data);

            echo $json;
        }

        public function create() {
            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if (!isset($data->title) || !isset($data->author) || !isset($data->publisher) || !isset($data->year_published)) {
                $data = array('errors' => ['status' => '400', 'title' => 'Bad Request', 'detail' => 'Some field is not defined...']);

                http_response_code(400);

                $json = json_encode($data);

                echo $json;
            } else if (empty($data->title) || empty($data->author) || empty($data->publisher) || empty($data->year_published)) {
                $data = array('errors' => ['status' => '400', 'title' => 'Bad Request', 'detail' => 'Some field is empty...']);

                http_response_code(400);

                $json = json_encode($data);

                echo $json;
            } else if ($this->bookModel->create($data->title, $data->author, $data->publisher, $data->year_published)) {
                $data = array('errors' => ['status' => '422', 'title' => 'Unprocessable', 'detail' => 'Some field is invalid...']);

                http_response_code(422);

                $json = json_encode($data);

                echo $json;
            } else {
                http_response_code(201);
            }
        }

        public function update($id) {
            if (!is_numeric($id)) {
                $data = array('errors' => ['status' => '404', 'title' => 'Not Found', 'detail' => 'Book not found...']);

                http_response_code(404);

                $json = json_encode($data);

                echo $json;
                return;
            }

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if (!isset($data->title) || !isset($data->author) || !isset($data->publisher) || !isset($data->year_published)) {
                $data = array('errors' => ['status' => '400', 'title' => 'Bad Request', 'detail' => 'Some field is not defined...']);

                http_response_code(400);
            } else if (empty($data->title) || empty($data->author) || empty($data->publisher) || empty($data->year_published)) {
                $data = array('errors' => ['status' => '400', 'title' => 'Bad Request', 'detail' => 'Some field is empty...']);

                http_response_code(400);
            } else if ($this->bookModel->update($id, $data->title, $data->author, $data->publisher, $data->year_published)) {
                $data = array('errors' => ['status' => '422', 'title' => 'Unprocessable', 'detail' => 'Some field is invalid...']);

                http_response_code(422);
            } else {
                http_response_code(200);
            }
        }

        public function delete($id) {
            if (!is_numeric($id)) {
                $data = array('errors' => ['status' => '404', 'title' => 'Not Found', 'detail' => 'Book not found...']);

                http_response_code(404);

                $json = json_encode($data);

                echo $json;
                return;
            }

            if ($this->bookModel->delete($id)) {
                $data = array('errors' => ['status' => '404', 'title' => 'Not Found', 'detail' => 'Book not found...']);

                http_response_code(404);

                $json = json_encode($data);

                echo $json;
            } else {
                http_response_code(204);
            }
        }

    }

?>