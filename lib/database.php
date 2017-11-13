<?php
class database {

    var $PDO;
    var $DEBUG = false;
    var $RR;

    /**
     *
     * @param String $db_type type database (server, MYSQL)
     * @param String $db_host ip database
     * @param String $db_name database used
     * @param Int $db_port port database
     * @param Sting $db_user user login database
     * @param String $db_pass password login database
     */
    function construct($db_type, $db_host, $db_name, $db_port, $db_user, $db_pass) {
        try {
            $this->PDO = new PDO($db_type . ':host=' . $db_host . ';dbname=' . $db_name . '; port=' . $db_port, $db_user, $db_pass);
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
        }
        catch(PDOException $e) {
            $this->error_messages("",$e->getMessage());
        }
    }

    /**
     *
     * @param String $table table name
     * @param Array $data key => field database, value => insert value data
     * @return Mixed Integer = row affected, String HTML error
     */
    function insert($table, $data = array()) {
        try {
            ksort($data);
            $fieldname = implode(',', array_keys($data));
            $fieldvalue = ':' . implode(', :', array_keys($data));

            /* reql query */
            $rqvalue = '\'' . implode('\',\'', array_values($data)) . '\'';

            $this->_rq = 'INSERT INTO ' . $table . ' (' . $fieldname . ') VALUES (' . $rqvalue . ')';

            $query = 'INSERT INTO ' . $table . ' (' . $fieldname . ') VALUES (' . $fieldvalue . ')';
            $statement = $this->PDO->prepare($query);

            foreach ($data as $key => $value) {
                $statement->bindValue(':' . $key, $value);
            }

            $statement->execute();
            $this->RR = $statement->rowCount();
            return $statement->rowCount();

            $statement = null;
            $this->PDO = null;
        } catch (Exception $e) {
            $this->error_messages($this->_rq,$e->getMessage());
        }
    }

    /**
     *
     * @param String $table table name
     * @param Array $data key => field database, value => insert value data
     * @param type $conditionfield key => field database, value => where value data
     * @return Mixed Integer = row affected, String HTML error
     */
    function update($table, $data = array(), $conditionfield = array()) {
        try {

            ksort($data);
            ksort($conditionfield);
            $updatedata = null;
            $wheredata = null;
            $rqwhere = null;
            $rqupdate = null;
            foreach ($data as $key => $value) {
                $updatedata .= $key . ' = :' . $key . ', ';
                $rqupdate .= $key . ' = \'' . $value . '\', ';
            }

            $updatedata = rtrim($updatedata, ', ');
            $rqupdate = rtrim($rqupdate, ', ');

            foreach ($conditionfield as $key => $value) {
                $wherekey = 'where' . $key;
                $conditionfield[$wherekey] = $conditionfield[$key];
                unset($conditionfield[$key]);
                $wheredata .= $key . ' = :' . $wherekey . ' AND ';
                $rqwhere .= $key . ' = \'' . $value . '\' AND ';
            }
            $wheredata = rtrim($wheredata, ' AND ');
            $rqwhere = rtrim($rqwhere, ' AND ');

            $finalarray = array_merge($data, $conditionfield);
            ksort($finalarray);


            $this->_rq = 'UPDATE ' . $table . ' SET ' . $rqupdate . ' WHERE ' . $rqwhere;
            $query = 'UPDATE ' . $table . ' SET ' . $updatedata . ' WHERE ' . $wheredata;
            $statement = $this->PDO->prepare($query);

            foreach ($finalarray as $key => $value) {
                $statement->bindValue(':' . $key, $value);
            }
            $statement->execute();
            $this->RR = $statement->rowCount();
            return $statement->rowCount();

            $statement = null;
            $this->PDO = null;
        } catch (Exception $e) {
            $this->error_messages($query,$e->getMessage());
        }
    }

    /**
     *
     * @param String $query query to database
     * @param Array $conditionfield key => field database, value => where value data
     * @param PDO $fetchmode FETCH MODE database
     * @return Mixed Integer = row affected, String HTML error
     */
    function select($query, $conditionfield = array(), $fetchmode = PDO::FETCH_ASSOC) {
        try {
            $statement = $this->PDO->prepare($query);

            foreach ($conditionfield as $key => $value) {
                $statement->bindValue($key, $value);
            }
            $statement->execute();

            $this->RR = $statement->rowCount();
            return $statement->fetchall($fetchmode);

            $statement = null;
            $this->PDO = null;
        } catch (PDOException $e) {
            $this->error_messages($query,$e->getMessage());
        }
    }

    function custom($query, $conditionfield = array()) {
        try {
            $statement = $this->PDO->prepare($query);
            foreach ($conditionfield as $key => $value) {
                $statement->bindValue($key, $value);
            }
            $statement->execute();
            $this->RR = $statement->rowCount();
            return $statement->rowCount();
            $statement = null;
            $this->PDO = null;
        } catch (PDOException $e) {
            $this->error_messages($query,$e->getMessage());
        }
    }

    function call($func, $fetchmode = PDO::FETCH_ASSOC) {
        try {
            $statement = $this->PDO->prepare($callfucntion);
            $statement->execute();

            $this->RR = $statement->rowCount();
            return $statement->fetchall($fetchmode);

            $statement = null;
            $this->PDO = null;
        } catch (PDOException $e) {
            $this->error_messages($func,$e->getMessage());
        }
    }

    /**
     *
     * @param Sting $table table name
     * @param Array $conditionfield key => field database, value => where value data
     * @return Mixed Integer = row affected, String HTML error
     */
    function delete($table, $conditionfield = array()) {
        try {
            ksort($conditionfield);

            $wheredata = null;
            $rqwhere = null;
            foreach ($conditionfield as $key => $value) {
                $wheredata .= ' ' . $key . ' = :' . $key . ' and';
                $rqwhere .= ' ' . $key . ' = \'' . $value . '\' and';
            }
            $wheredata = rtrim($wheredata, 'and');
            $rqwhere = rtrim($rqwhere, 'and');

            $this->_rq = 'DELETE FROM ' . $table . ' WHERE ' . $rqwhere;
            //echo $this->_rq;
            $query = 'DELETE FROM ' . $table . ' WHERE ' . $wheredata;
            $statement = $this->PDO->prepare($query);
            foreach ($conditionfield as $key => $value) {
                $statement->bindValue(':' . $key, $value);
            }
            $statement->execute();
            $this->RR = $statement->rowCount();
            return $statement->rowCount();

            $statement = null;
            $this->PDO = null;
        } catch (Exception $e) {
            $this->error_messages($query,$e->getMessage());
        }
    }

    function information() {

        $attributes = array(
            "CONNECTION_STATUS",
            "SERVER_INFO",
            "SERVER_VERSION",
            "CLIENT_VERSION",
            "AUTOCOMMIT", 
            "ERRMODE",
        );

        if($this->DEBUG) {  

            echo "<pre>";
            foreach ($attributes as $val) {
                echo "$val : ";
                echo $this->PDO->getAttribute(constant("PDO::ATTR_$val")) . "\n";
            }
            echo "</pre>";
        }
        else {

            echo "<script>";
            foreach ($attributes as $val) {

                $value = $this->PDO->getAttribute(constant("PDO::ATTR_$val"));

                echo "console.log('%c $val' + ' : ' + '$value', 'background: #ffffff; color: #0000ff');";
            }
            echo "</script>";
        }
    }

    function error_messages($syntax,$messages) {

        if($this->DEBUG)
        {   
            echo "<style>";
            echo "body";
            echo "{";
            echo "padding:0px;";
            echo "margin:0px;";
            echo "}";
            echo "</style>";
            echo "<div style=\"width:100%;background-color:#0099FF\"><h3><font style=\"color:#FFFFFF\">$messages</h3></font></div>";
            echo "<div>";
            echo "<pre>";
            print_r($syntax);
            echo "</div>";
            exit();
        }
        else {

            $messages = str_replace("'", "", $messages);
            $syntax = str_replace("'", "", $syntax);

            echo "<script>";
            echo "alert('DATABASE QUERY ERROR, PLEASE CONTACT YOUR ADMINISTRATOR\\n\\n$messages\\n\\n$syntax');";
            echo "console.log('%c DATABASE QUERY ERROR ', 'background: #ff0000; color: #ffffff');";
            echo "console.log('%c $messages', 'background: #ffffff; color: #ff0000');";
            echo "console.log('%c $syntax', 'background: #ffffff; color: #ff0000');";
            echo "</script>";

            exit();
        }
    }

    /**
     *
     * @param Array $variable Data to encryption
     * @return Array Data decryption
     */
    function htmlspecial_array(&$variable) {
        foreach ($variable as $valuae => &$value) {
            if (!is_array($value)) {
                $value = htmlspecialchars($value);
            } else {
                $this->_htmlspecial_array($value);
            }
        }
        return $variable;
    }

}
