<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Toastr;
use App\Setting;
// use PDO;

class DatabaseBackupController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function db_backup(Request $request){



		// dd('test');







    	// if(!\Hash::check($request->password, auth()->user()->password)){
    	// 	Toastr::error('error','Entired Password Invalid');
	    // 	return redirect()->back();
        // }


        // $company_name = hybrid_first('settings_company','key','company_name','value');
        // $company_name = str_replace(' ','/', '_', $company_name);

        $DbName = DB::connection()->getDatabaseName();
	    $get_all_table_query = "SHOW TABLES ";
	    $result = DB::select(DB::raw($get_all_table_query));
	    $prep = "Tables_in_".$DbName;
	    foreach ($result as $res){
	        $tables[] =  $res->$prep;
	    }

	    $connect = DB::connection()->getPdo();

	    $get_all_table_query = "SHOW TABLES";
	    $statement = $connect->prepare($get_all_table_query);
	    $statement->execute();
	    $result = $statement->fetchAll();


	    $output = '';
	    foreach($tables as $table)
	    {
	        $show_table_query = "SHOW CREATE TABLE " . $table . "";
	        $statement = $connect->prepare($show_table_query);
	        $statement->execute();
	        $show_table_result = $statement->fetchAll();

	        foreach($show_table_result as $show_table_row)
	        {
	            $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
	        }
	        $select_query = "SELECT * FROM " . $table . "";
	        $statement = $connect->prepare($select_query);
	        $statement->execute();
	        $total_row = $statement->rowCount();

	        for($count=0; $count<$total_row; $count++)
	        {
	            $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
	            $table_column_array = array_keys($single_result);
	            $table_value_array = array_values($single_result);
	            $output .= "\nINSERT INTO $table (";
	            $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
	            $output .= "'" . implode("','", $table_value_array) . "');\n";
	        }
	    }
	    // $file_name = $company_name .'_'. date('d_m_y') . '.sql';
	    $file_name = date('d_m_y') . '_db.sql';
	    $file_handle = fopen($file_name, 'w+');
	    fwrite($file_handle, $output);
	    fclose($file_handle);
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename=' . basename($file_name));
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file_name));
	    ob_clean();
	    flush();
	    readfile($file_name);
	    unlink($file_name);
	}
}
