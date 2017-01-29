<?php

    class Logger {
        const LOG_CREATE = 1;
        const LOG_READ = 2;
        const LOG_UPDATE = 3;
        const LOG_DELETE = 4;
        const LOG_IMAGE_AUTO_RESIZE = 5;

        const LOG_LIMIT = 100;

        public $db;

        public function __construct() {
            $this->db = $this->getConnection();
        }

        public function getConnection() {
            $paramsPath = ROOT . '/config/db_params.php';
            $params = include($paramsPath);
            $db = new PDO(
                "mysql:host={$params['host']};" 
                . "dbname={$params['dbname']}",
                $params['user'],
                $params['password']
            );
            $db->exec("set names utf8");
            return $db;
        }


        /*
            @param int $type
            @param string $target
        */
        private function makeLog($type, $target) {
            $db = $this->db;
            $sql = 'INSERT INTO log (type, target) VALUES (:type, :target)';
            $result = $db->prepare($sql);
            $result->bindParam(':type', $type, PDO::PARAM_INT);
            $result->bindParam(':target', $target, PDO::PARAM_STR);
            $result->execute();
        }
        /*
            @param string $target
        */
        public function logRead($target) {
            $this->makeLog(self::LOG_READ, $target);
        }

        public function logDelete($target) {
            $this->makeLog(self::LOG_DELETE, $target);
        }
        
        public function logUpdate($target) {
            $this->makeLog(self::LOG_UPDATE, $target);
        }
        
        public function getlog() {
            $limit = self::LOG_LIMIT;
            $db = $this->db;
            $sql = 
                'SELECT
                    operation.type AS "type",
                    log.target AS "target",
                    log.date AS "date"
                FROM
                    log
                INNER JOIN
                    operation
                ON
                    log.type = operation.id
                ORDER BY log.date DESC 
                LIMIT :limit';
       
            $result = $db->prepare($sql);
            $result->bindParam(':limit', $limit, PDO::PARAM_INT);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();
        
            return $result->fetchAll();
        }
    }