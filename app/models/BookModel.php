<?php

    require_once('./DatabaseConnection.php');

    class BookModel {

        public function findAll() {
            try {
                $pdo = DatabaseConnection::getConnection();

                $sql = "SELECT * FROM tb_book";

                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll();

                return $result;
            } catch (Exception $e) {
                return [];
            } finally {
                $pdo = null;
            }
        }

        public function findById($id) {
            try {
                $pdo = DatabaseConnection::getConnection();

                $sql = "SELECT * FROM tb_book WHERE id = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->execute(array($id));

                $result = $stmt->fetch();

                return ($result) ? $result : null;
            } catch (Exception $e) {
                return null;
            } finally {
                $pdo = null;
            }
        }

        public function create($title, $author, $publisher, $year_published) {
            try {
                $pdo = DatabaseConnection::getConnection();

                $sql = "INSERT INTO tb_book (id, title, author, publisher, year_published) VALUES (null, ?, ?, ?, ?)";

                $stmt = $pdo->prepare($sql);

                if ($stmt->execute(array($title, $author, $publisher, $year_published))) {
                    return false;
                }

                return true;
            } catch (Exception $e) {
                return true;
            } finally {
                $pdo = null;
            }
        }

        public function update($id, $title, $author, $publisher, $year_published) {
            try {
                $pdo = DatabaseConnection::getConnection();

                $sql = "UPDATE tb_book SET title = ?, author = ?, publisher = ?, year_published = ? WHERE id = ?";

                $stmt = $pdo->prepare($sql);

                if ($stmt->execute(array($title, $author, $publisher, $year_published, $id))) {
                    return false;
                }

                return true;
            } catch (Exception $e) {
                return true;
            } finally {
                $pdo = null;
            }
        }

        public function delete($id) {
            try {
                $pdo = DatabaseConnection::getConnection();

                $sql = "DELETE FROM tb_book WHERE id = ?";

                $stmt = $pdo->prepare($sql);

                if ($stmt->execute(array($id))) {
                    return false;
                }

                return true;
            } catch (Exception $e) {
                return true;
            } finally {
                $pdo = null;
            }
        }

    }

?>