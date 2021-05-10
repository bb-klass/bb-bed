<?php
error_reporting( E_ALL&~E_NOTICE );
class Sql {
    protected $host = "localhost";
    protected $userName = "root";
    protected $password = "111";
    protected $dbName = "db_tax";
    public function connect() {
        $conn = mysqli_connect($this->host,$this->userName,$this->password,$this->dbName) or die("数据库连接失败".mysqli_error());
        mysqli_query($conn, "set names utf8");
        return $conn;
    }
    public function search_data($conn,$query) {
        return mysqli_query($conn, $query);
    }
    public function update($conn,$query){
        mysqli_query($conn, $query);
        return true;
    }
    public function close($conn) {
        mysqli_close($conn);
        return true;
    }
    public function create_industry($ch,$en){
        $conn = $this->connect();
        mysqli_query($conn, 'insert into tb_industry(industryName,tableName) values("'.$ch.'","'.$en.'")');
        mysqli_query($conn, 'create table tb_in_'.$en.' like tb_in_hotel');
        $this->close($conn);
        return true;
    }
    public function drop_table($en){
        $conn = $this->connect();
        mysqli_query($conn, 'drop table tb_in_'.$en);
        mysqli_query($conn, 'delete from tb_industry where tableName="'.$en.'"');
        $this->close($conn);
        return true;
    }
    public function truncate_table($en){
        $conn = $this->connect();
        mysqli_query($conn, 'truncate table tb_in_'.$en);
        $this->close($conn);
        return true;
    }
    public function change_col($conn,$table,$oldField,$newField) {
        mysqli_query($conn, 'ALTER TABLE db_tax.tb_in_'.$table.'');
        mysqli_query($conn, 'CHANGE '.$oldField.' '.$newField.' TEXT NOT NULL');
        return true;
    }
    public function add_col($conn,$newField,$table) {
        mysqli_query($conn, 'alter table db_tax.tb_in_'.$table.' ADD '.$newField.' TEXT NOT NULL');
        return true;
    }
    public function add_field($conn,$newField) {
        mysqli_query($conn, 'insert into tb_fields(fieldName,width) values("'.$newField.'","120px")');
        return true;
    }
    public function rename_col($conn,$oldName,$newField,$table) {
        mysqli_query($conn, 'alter table tb_in_'.$table.' CHANGE COLUMN '.$oldName.' '.$newField.' TEXT NOT NULL');
        return true;
    }
    public function delete_field($conn,$oldName) {
        mysqli_query($conn, 'delete from tb_fields where fieldName="'.$oldName.'"');
        mysqli_query($conn, 'alter table tb_fields drop id');
        mysqli_query($conn, 'alter table tb_fields add id INT primary key not null auto_increment first');
        return true;
    }
    public function drop_field($conn,$oldName,$table) {
        mysqli_query($conn, 'alter table tb_in_'.$table.' drop '.$oldName);
        return true;
    }
    public function change_width($field,$width) {
        $conn = $this->connect();
        mysqli_query($conn, 'update tb_fields set width= "'.$width.'" where fieldName = "'.$field.'"');
        $this->close($conn);
        return true;
    }
    public function move_field($conn,$fieldName,$after,$table) {
        mysqli_query($conn, 'alter table tb_in_'.$table.' modify '.$fieldName.' text after '.$after);
        return true;
    }
}
