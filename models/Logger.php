<?php

    class Logger {
        const LOG_CREATE = 1;
        const LOG_READ = 2;
        const LOG_UPDATE = 3;
        const LOG_DELETE = 4;
        const LOG_IMAGE_AUTO_RESIZE = 5;

        const LOG_LIMIT = 100;


        /*
            @param int $type
            @param string $target
        */
        private static function makeLog($type, $target) {
            $db = Db::getConnection();
            $sql = 'INSERT INTO log (type, target) VALUES (:type, :target)';
            $result = $db->prepare($sql);
            $result->bindParam(':type', $type, PDO::PARAM_INT);
            $result->bindParam(':target', $target, PDO::PARAM_STR);
            $result->execute();
        }
        /*
            @param string $target
        */
        public static function logRead($target) {
            self::makeLog(self::LOG_READ, $target);
        }

        public static function logDelete($target) {
            self::makeLog(self::LOG_DELETE, $target);
        }
        
        public static function getlog() {
            $limit = self::LOG_LIMIT;
            $db = Db::getConnection();
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