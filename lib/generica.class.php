<?php

//require_once ("../../../etc/configPHP.inc");
require_once (SITE_ROOT . "/etc/configPHP.inc");


class Generica {

    public $_search;
    public $rows;
    public $page;
    public $sidx;
    public $sord;
    public $oper;
    public $id;
    public $tabla;
    public $searchField;
    public $searchString;
    public $searchOper;
    public $database;

    
    function __construct($db='resint') {


        global $conn;
        mysql_select_db($db,$conn);
        

        $this->_search = $_GET["_search"];
        $this->rows = $_GET["rows"];
        $this->page = $_GET["page"];
        $this->sidx = $_GET["sidx"];
        if(!$this->sidx) $this->sidx =1;
        $this->tabla = $_GET["tabla"];
        $this->sord = $_GET["sord"];

        $this->oper = $_POST["oper"];
        $this->id = $_POST["id"]; // se carga la clave en formato WHERE. Ej: Campo1 = valor1 AND Campo2 = 'Valor2'
                
        $this->searchField = $_GET["searchField"];
        $this->searchString = $_GET["searchString"];
        $this->searchOper = $_GET["searchOper"];

        
    }

    /**
     * funci�n: execute
     * descripci�n: ejecuta el m�todo correspondiente seg�n la operaci�n
     */
   
    public function execute() {

        global $conn;
        //mysql_select_db($this->database,$conn);

        if ($this->oper == "edit")
            $sql = $this->update(); 
        if ($this->oper == "add")
            $sql = $this->insert(); 
        if ($this->oper == "del")
            $sql = $this->delete();
        if ($sql != "") {
			$this->writeLog($sql);
            $res = mysql_query($sql, $conn);
			if ($res == null)
				return str_replace("'",'"',mysql_error ($conn));
		}
		//$this->writeLog('post:'.print_r($_GET, true) . "\n");

    
        mysql_close($conn);
        if ($error == "")
            return "{success:['true']}";
        else
            return "{errors:['".$error."']}";

    }

    /**
     * funci�n: select
     * Par�metros: SQL_Contar, SQL_Seleccionar 
     * Retorno: json_encode
     */
   
    public function select($sql_count,$sql_data,$datatype='json') {
        
        global $conn;

        
        $page = $this->page; // get the requested page
        $limit = $this->rows; // get how many rows we want to have into the grid
        $sidx = $this->sidx; // get index row - i.e. user click to sort
        $sord = $this->sord; // get the direction

        $res = mysql_query($sql_count, $conn);
        $row = mysql_fetch_assoc($res);
        $count = $row['count'];
    
    
        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
             $total_pages = 0;
        }
    
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start<0) $start = 0;

        $sql_data = str_replace("{_REGISTROS_}",$limit,$sql_data);
        $sql_data = str_replace("{_PAGINA_}",$start,$sql_data);
        
        if ($sidx != "" && $sidx != "id" && $sord != "")
            $sql_data .= " ORDER BY ".$this->getFieldName($sidx)." ".$sord;
        
        $sql_data .= " LIMIT $start,$limit ";   

        
        
        $sql_data .= ";";
        
        $this->writeLog($sql_data);
        
        $res = mysql_query($sql_data, $conn);

        if ($datatype == 'json') {    
            // Construct the json data
            $response->page = $page; // current page
            $response->total = $total_pages; // total pages
            $response->records = $count; // total records
            
            
            $i = 0;
            $_array;
            while ($row = mysql_fetch_assoc($res)){
               $response->rows[$i]['id'] = $row["id"];
               $response->rows[$i]['cell'] = $this->arrayFill($row,$datatype);
               $i++;
            }
            //$this->writeLog(json_encode($response)); 
            return json_encode($response);
        }
        else { // xml
            /*if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) { 
               header("Content-type: application/xhtml+xml;charset=utf-8"); 
            } else { 
               header("Content-type: text/xml;charset=utf-8"); 
            }*/ 
            $et = ">";
            $data = "<?xml version='1.0' encoding='utf-8'?$et\n"; 
            $data .= "<rows>"; // be sure to put text data in CDATA 
            $data .= "<page>".$page."</page>"; 
            $data .= "<total>".$total_pages."</total>"; 
            $data .= "<records>".$count."</records>";
                         
            while ($row = mysql_fetch_assoc($res)){ 
               $data .= "<row id='". $row[id]."'>";
               $data .= $this->arrayFill($row,$datatype); 
               $data .="</row>"; 
            } 
            $data .="</rows>";   
//$this->writeLog('data:'.$data);
            return $data;            
        }
        
    }


    /**
     * funci�n: update
     * Par�metros: 
     */
    
    public function update() {

       
        foreach ($_POST as $k=>$v) {
            if (substr($k,0,7) == '_field_') {
                $coma = "";
                if ($fields != "") $coma = ",";
                if (substr($k,6,3) == '_N_') 
                    $fields .= $coma.substr($k,9)." = ".$v." "; // Campos de tipo num�ricos
                else if (substr($k,6,3) == '_D_') 
                    $fields .= $coma.substr($k,9)." = CONVERT(datetime,'".$v."',103) "; // Campos de tipo fecha
                else
                    $fields .= $coma.substr($k,9)." = '".$this->clearField($v)."' "; // Campos de tipo caracter
            } 
        }
        $sql = "UPDATE ".$this->tabla." SET ".$fields." WHERE ". utf8_decode(stripslashes($this->id)) .";";

        return $sql;

    }

    /**
     * funci�n: search
     * Par�metros: 
     */

    public function search($sql_count,$sql_data) {


        //LOG
        if (substr($this->searchField,0,7) == '_field_') {
            if (substr($this->searchField,8,3) == '_N_')
                $comilla = ""; 
            else
                $comilla = "'";
            $fields .= substr($this->searchField,9); // Nombre de campos
        } else if (substr($this->searchField,0,5) == '_key_') {
            if (substr($this->searchField,4,3) == '_N_')
                $comilla = "";
            else
                $comilla = "'";
            $fields .= substr($this->searchField,7); // Nombre de campos
        }
        if ($fields != "")
        	$sql_data .= " AND ".$fields.$this->getOper($this->searchOper,$this->searchString,$comilla);

        return $this->select($sql_count,$sql_data);

    }


    /**
     * funci�n: insert
     * Par�metros: 
     */

    public function insert() {

        foreach ($_POST as $k=>$v) {
            if (substr($k,0,7) == '_field_') {
                $coma = "";
                if ($values != "") $coma = ",";
                if (substr($k,6,3) == '_N_') 
                    $values .= $coma.$v; // Valores de campos num�ricos
                else if (substr($k,6,3) == '_D_') 
                    $fields .= $coma."CONVERT(datetime,'".$v."',103) "; // Campos de tipo fecha
                else
                    $values .= $coma."'". utf8_decode($v) ."'"; // Valores de campos caracter
                $fields .= $coma.substr($k,9); // Nombre de campos
            } else if (substr($k,0,5) == '_key_') {
                $coma = "";
                if ($values != "") $coma = ",";

                if ($v == "" || $v == "_new")
                    $values .= $coma.$this->getKey($k);
                else
                    if (substr($k,4,3) == '_N_') 
                        $values .= $coma.$v;                                // Valores de campos num�ricos
                    else if (substr($k,4,3) == '_D_') 
                        $fields .= $coma."CONVERT(datetime,'".$v."',103) "; // Campos de tipo fecha
                    else
                        $values .= $coma."'". utf8_decode($v) ."'";                        // Valores de campos caracter
                 
                $fields .= $coma.substr($k,7); // Nombre de campos
            } 
             
        }         
        return "INSERT INTO ".$this->tabla." (".$fields.") VALUES (".$values.");";

    }

    /**
     * funci�n: delete
     * Par�metros: 
     */

    public function delete() {

        $sql = "DELETE FROM ".$this->tabla." WHERE ". utf8_decode(stripslashes($this->id)) .";";
        return $sql;

    }

    
    /**
     * funci�n: getOper
     * Par�metros: tipo de operador logico
     * retorno: operador SQL
     */

    public function getOper($oper,$valor,$comilla) {
        
        $valor = utf8_decode($valor);
        
        switch ($oper) {
            case "eq":
                return " = ".$comilla.$valor.$comilla;
                break;
            case "ne":
                return " <> ".$comilla.$valor.$comilla;
                break;
            case "lt":
                return " < ".$comilla.$valor.$comilla;
                break;
            case "le":
                return " <= ".$comilla.$valor.$comilla;
                break;
            case "gt":
                return " > ".$comilla.$valor.$comilla;
                break;
            case "ge":
                return " >= ".$comilla.$valor.$comilla;
                break;
            case "bw":
                //empiece con
                return " LIKE '".$valor."%'";
                break;
            case "bn":
                //no empiece con
                return " NOT LIKE '".$valor."%'";
                break;
            case "in":
                //esta en
                return " IN (".$valor.")";
                break;
            case "ni":
                //no esta en
                return " NOT IN (".$valor.")";
                break;
            case "ew":
                //termina por
                return " LIKE '%".$valor."'";
                break;
            case "en":
                //no termina con
                return " NOT LIKE '%".$valor."'";
                break;
            case "cn":
                //contiene
                return " LIKE '%".$valor."%'";
                break;
            case "nc":
                //NO contiene
                return " NOT LIKE '%".$valor."%'";
                break;                                                    
        }         

    }


    /**
     * funci�n: getFieldName
     * Par�metros: nombre de campo con _field_X_NOMBRE o _key_X_NOMBRE
     * retorno: NOMBRE de campo sin _field_X_ o _key_X_
     */

    /**
     * funci�n: getFieldName
     * Par�metros: nombre de campo con _field_X_NOMBRE o _key_X_NOMBRE
     * retorno: NOMBRE de campo sin _field_X_ o _key_X_
     */

    public function getFieldName($field) {
        
        if (substr($field,0,7) == '_field_')
            return substr($field,9); 
        else if (substr($field,0,5) == '_key_')
            return substr($field,7); 
        else
        	return $field;
    }


    /**
     * funci�n: getMax
     * Par�metros: nombre de campo
     * retorno: obtiene el m�ximo + 1
     * descripci�n: se utiliza para las tablas que el c�digo es num�rico y no lo 
     * determina el usuario.
     */

    public function getKey($k) {
        
        global $conn;
        //mysql_select_db($this->database,$conn);

        if (substr($k,4,3) == '_N_') 
            $sql = "SELECT MAX(".substr($k,7).") + 1 AS clave FROM ".$this->tabla.";";
        else if (substr($k,4,3) == '_D_') 
            $sql = "SELECT GetDate() AS clave;";
        else if (substr($k,4,3) == '_U_') 
            $sql = "SELECT NewId() AS clave;";

        $res = mysql_query($sql, $conn);

        if ($lp_row = mysql_fetch_assoc($res)){
            $clave .= $lp_row["clave"]; 
        } 
        return $clave;
        
    }


    /**
     * funci�n: arrayFill
     * Par�metros: registro
     * retorno: array
     */

    public function arrayFill($row,$datatype) {
        
        if ($datatype=='json') {
            $aResult = array();
            $iCount = 0;
            foreach($row as $val)
            {
                $aResult[$iCount] = utf8_encode($val); 
                $iCount++;
            }    
            return $aResult;
        }
        else {
            $data = "";
            foreach($row as $val)
            {
               $data .="<cell><![CDATA[". utf8_encode($val) ."]]></cell>"; 
            }    
            return $data;
            
        }
    }


    /**
     * funci�n: clearField
     * Par�metros: valor
     * retorno: valor sin "\" y sin "'"  
     */

    public function clearField($value) {
        return str_replace("'","''",stripslashes(utf8_decode($value)));
    }


    /**
     * funci�n: writeLog
     * Par�metros: texto
     * retorno: 
     */

    public function writeLog($text) {
    
        //return "";

        $fileContainer = SITE_ROOT . "/log/log.txt";
        $filePointer = fopen($fileContainer, "a+");
        $logMsg = $text . "\n";
        fputs($filePointer, $logMsg);
        fclose($filePointer);
        return;

    }
    
}



?>
