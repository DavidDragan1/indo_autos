<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-14
 */

class Db_sync extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Db_sync_model');      
        $this->load->helper('db_sync');      
    }

    public function index() {
        $db_sync    = $this->Db_sync_model->get_all();
        $tables     = $this->db->list_tables();
        
        $data       = ['db_sync_data' => $db_sync, 'tables' => $tables];
        $this->viewAdminContent('db_sync/index', $data);
    }

    

    public function delete($id) {
        $row = $this->Db_sync_model->get_by_id($id);
        if ($row) {
            $this->Db_sync_model->delete($id);
            echo json_encode(['status' => 'OK', 'msg' => 'Create Record Success']);
        } else {
            echo json_encode(['status' => 'Fail', 'msg' => 'Record Not Found!']);
        }
    }
              
    
    public function countColumns($table = ''){
        $database    = $this->db->database;
                              
        $result = $this->db->query(
                "SELECT COUNT(*) as col
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE table_schema = '$database'
                AND table_name = '$table'")->row();    
                
        return $result->col;
    }
    
    
    public function countRows($table = ''){                                     
        //$result = $this->db->query("SELECT COUNT(*) as Row FROM `$table`")->row();
        $result = $this->db->get($table)->num_rows();               
        return $result;
    }
    
    public function backup_full_db(){
       ajaxAuthorized();       
       isDeadSystem();
       
       
       $database    = $this->db->database;
       $hostname    = $this->db->hostname;
       $username    = $this->db->username;
       $password    = $this->db->password;
       
       $mysql_path  = str_replace('htdocs', '', $_SERVER['DOCUMENT_ROOT']);
       $mysql_path  = str_replace('/', '\\', $mysql_path);
       $mysqlPath   = (PHP_OS == "WINNT") ? $mysql_path . 'mysql\\bin\\' : '';
                            
       $dbPath = dirname( BASEPATH ) . '/DB/' . $database . date('_Y-m-d_H-i-s');
       
       $sql_string = "mysqldump --host=$hostname --user=$username --password=$password $database > $dbPath.sql";
       
       system( $mysqlPath .$sql_string);

       $tbl         = 'Full DB Backuped';
       $record_id   = $this->add_change_log( $tbl );      
       
       $array['Status'] = 'OK';
       $array['Msg']    = '<p class="ajax_success">Full DB Export Successful</p>';
       $array['TblRow'] = '<tr><td>'. $record_id .'</td><td>'. date('h:i A d/m/y').'</td><td>' . $tbl .'</td><td>' . getLoginUserData('name') .'</td></tr>';
                     
       echo json_encode($array);                     
    }
    
    public function exportTable( ){
    
       ajaxAuthorized();
       isDeadSystem();
        
       $table = $this->input->post('table');               
        
       $database    = $this->db->database;
       $hostname    = $this->db->hostname;
       $username    = $this->db->username;
       $password    = $this->db->password;
       
       $mysql_path  = str_replace('htdocs', '', $_SERVER['DOCUMENT_ROOT']);
       $mysql_path  = str_replace('/', '\\', $mysql_path);
       $mysqlPath   = (PHP_OS == "WINNT") ? $mysql_path . 'mysql\\bin\\' : '';
                            
       $dbPath = dirname( BASEPATH ) . '/DB/'. $table . date('_Y-m-d_H-i-s');
       
       $sql_string = "mysqldump --host=$hostname --user=$username --password=$password $database $table > $dbPath.sql";
       
       system( $mysqlPath .$sql_string);

       $tbl         = ucfirst($table);
       $record_id   = $this->add_change_log(  'Backup ' . $tbl );      
       
       $array['Status'] = 'OK';
       $array['Msg']    = '<p class="ajax_success">'. $tbl .' Export Successfully</p>';
       $array['TblRow'] = '<tr><td>'. $record_id .'</td><td>'. date('h:i A d/m/y').'</td><td>Backup ' . $tbl .'</td><td>' . getLoginUserData('name') .'</td></tr>';
                     
       echo json_encode($array);                     
    }
    
    public function truncateTable(){
        ajaxAuthorized();
        
        $table = $this->input->post('table');
        $truncate = $this->db->truncate($table);
        if($truncate){
            echo ajaxRespond('OK','Complete');
        } else {
            echo ajaxRespond('Fail','Fail To Truncate');
        }
        
        
    }
    private function add_change_log( $event_name = null ) {
        ajaxAuthorized();
        
        $data = [
            'user_id'       => getLoginUserData('user_id'),
            'created'       => date('Y-m-d H:i:s'),
            'event_fired'   => $event_name,
        ];
        return $this->Db_sync_model->insert($data); 
         
    }
}
