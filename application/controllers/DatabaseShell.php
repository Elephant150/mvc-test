<?php

namespace application\controllers;

class DatabaseShell
{
    public $dbh;

//  конект до БД
    public function __construct($host, $dbname, $charset, $user, $password)
    {
        try {
            $this->dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // обробка помилок
//            echo "Connecting is good!";
        } catch (PDOException $exception) {
            print_r("Error!: " . $exception->getMessage() . "<br>");
            die();
        }
    }

    public function insertIntoDb($table, $data = [], $values = [])
    {
        $insert = ' INSERT INTO ' . $table;

        $strData = join(', ', $data); //обєднання елементів масиву data в строку

        $insert .= " (" . $strData . ") ";

        $strValues = '"' . join('", "', $values) . '"'; //обєднання елементів масиву values в строку
        $replace = str_replace('"NULL"', 'NULL', $strValues); //видаляє "" навколо NULL

        $insert .= " VALUES (" . $replace . ")";

        $this->dbh->query($insert);
    }

    public function deleteFromDbById($table, $id)
    {
        $result = $this->dbh->prepare("SELECT * FROM $table WHERE id=$id");
        $result->execute();
        $fetch = $result->fetchColumn();
        if ($fetch > 0) {
            $this->dbh->query("DELETE FROM $table WHERE id=$id");
        } else {
            echo 'Such an id does not exist!';
        }
    }

    public function deleteRecordsInRange($table, $from, $to)
    {
        $result = $this->dbh->prepare("SELECT * FROM $table WHERE id BETWEEN $from AND $to");
        $result->execute();
        $fetch = $result->fetchColumn();
        if ($fetch > 0) {
            $this->dbh->query("DELETE FROM $table WHERE id BETWEEN $from AND $to");
        } else {
            echo 'No id in the specified range!';
        }
    }

    public function deleteAllRecords($table)
    {
        $result = $this->dbh->prepare("SELECT * FROM $table");
        $result->execute();
        $fetch = $result->fetchColumn();
        if ($fetch > 0) {
            $this->dbh->query("DELETE FROM $table");
        } else {
            echo 'Id does not exist!';
        }
    }

    public function deleteBySelectedId($table, $ids)
    {
        foreach ($ids as $id) {
            $result = $this->dbh->prepare("SELECT * FROM $table WHERE id = $id");
            $result->execute();
            $fetch = $result->fetchColumn();
            if ($fetch > 0) {
                $this->dbh->query("DELETE FROM $table WHERE id = $id");
            } else {
                echo "There is no record with this $id!";
            }
        }
    }

    public function getRecordById($table, $id)
    {
        $result = $this->dbh->query("SELECT * FROM $table WHERE id = $id");
        $records = $result->fetch(PDO::FETCH_ASSOC);
        if ($records) {
            echo '<pre>';
            print_r($records);
            echo '</pre>';
        } else {
            echo 'No record!';
        }
    }

    public function getRecordsInRange($table, $from, $to)
    {
        $result = $this->dbh->query("SELECT * FROM $table WHERE id BETWEEN $from AND $to");
        $records = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($records) {
            echo '<pre>';
            print_r($records);
            echo '</pre>';
        } else {
            echo 'No id in the specified range!';
        }
    }

    public function getAllRecordsById($table, $ids)
    {
        foreach ($ids as $id) {
            $result = $this->dbh->query("SELECT * FROM $table WHERE id = $id");
            $records = $result->fetch(PDO::FETCH_ASSOC);
            if ($records) {
                echo '<pre>';
                print_r($records);
                echo '</pre>';
            } else {
                echo 'No records!';
            }
        }
    }

    // зробити типу 3 методи де є > < = для виводу по умові
    // або вказувати одразу ж при передачі параметра 'where id >= 3' в індексі

    public function getConditionalRecords($table, $condition)
    {
        foreach ($condition as $key => $item) {
            $result = $this->dbh->query("SELECT * FROM $table WHERE $key = $item");
            $records = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($records) {
                echo '<pre>';
                print_r($records);
                echo '</pre>';
            } else {
                echo 'No records!';
            }
        }
    }

    public function getAllRecords($table)
    {
        $result = $this->dbh->query("SELECT * FROM $table");
        $records = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($records) {
            echo '<pre>';
            print_r($records);
            echo '</pre>';
        } else {
            echo 'No records!';
        }
    }

    public function updateRecords($table, $id, $newData)
    {
        $result = $this->dbh->query("SELECT * FROM $table WHERE id = $id");
        if ($result->fetch(PDO::FETCH_ASSOC)) {
            foreach ($newData as $key => $value) {
                $stmt = $this->dbh->prepare("UPDATE `$table` SET `$key` = '$value' WHERE `id` = '$id'");
                $stmt->execute();
                echo '<pre>';
                print_r($stmt);
                echo '</pre>';
            }
        } else {
            echo 'No record!';
        }
    }
}