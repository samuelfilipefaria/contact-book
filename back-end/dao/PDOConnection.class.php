<?php
    include_once "../config/DBConfig.class.php";

    class PDOConnection {
        private $connection;

        public function connect() {
            try {
                $this->connection = new PDO(
                    "mysql:host=".DBConfig::$HOST.";dbname=".DBConfig::$DB, DBConfig::$USER,
                    DBConfig::$PWD);
            } catch (Exception $ex) {
                throw new Exception('Erro ao tentar se conectar.
                        Mensagem: '.$ex->getMessage());
            }
        }

        public function prepareStm($query, $fields) {
            $stm = $this->connection->prepare($query);
            foreach($fields as $key => &$value) {
                $stm->bindParam(":".$key, $value);
            }
            return $stm;
        }

        public function executeQuery($stm) {
            $isSelect = str_starts_with(strtolower($stm->queryString), "select");
            $stm->execute();
            $arr = $stm->fetchAll(PDO::FETCH_ASSOC);
            $numRows = $stm->rowCount();
            $stm = null;
            if (!$isSelect)
                return $numRows;

            return $arr;
        }
    }

?>