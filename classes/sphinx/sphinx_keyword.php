<?
//Search hoitraloi bằng sphinx
require_once(dirname(__FILE__) . "/sphinxapi.php");
require_once(dirname(__FILE__) . "/sphinx_init.php");
class sphinx_keyword{
	var $max_keyword_length 	= 150;
	var $keyword 					= "";
	var $original_keyword 		= "";
	
	var $array_data 				= array();
	var $array_search_keyword	= array();
	var $array_vatgia_product	= array();
	var $array_vatgia_raovat	= array();
	
	var $total_found 				= 0;
	var $count_cat 				= 0;
	var $cat_order_top 			= 0; //Quy định category_id nào đc lên đầu trong kết quả search, mặc định là 0: không có category nào cả	
	
	//Có thành công khi search sphinx hay không
	var $search_successful 		= false;
	//Server Config here
	var $sphinx_host 				= "localhost";
	var $sphinx_port 				= 33120;

    //Tên data cần search
	var $index_data 				= "content";
    var $array_filter               = array();
	
	var $array_keyword = array();

	//Class sphinx
	var $sphinx;
	/*
	Khởi tạo class
	*/
	function sphinx_keyword($keyword, $index_data = ''){
		$this->index_data = $index_data ? $index_data : $this->index_data;
		//Cắt ngắn
		if (mb_strlen($keyword,"UTF-8") > $this->max_keyword_length) $keyword = mb_substr($keyword,0,$this->max_keyword_length,"UTF-8");
		
		$this->keyword = mb_strtolower($keyword,"UTF-8");
		//echo "2";
		//Remove "
		$this->keyword = str_replace("&quot;","",$this->keyword);
		
		//Replace các bad character
		$array_bad_word = array("?","^",",",";","*","/","~","@","-","!","[","]","(",")","=","|");
		$this->keyword = str_replace($array_bad_word,"",$this->keyword);

		//Chống các ký tự ô vuông, convert lại đúng kiểu UTF-8
		$this->keyword = mb_convert_encoding($this->keyword,"UTF-8","UTF-8");
		
		//Xóa bỏ ký tự NCR
		$convmap = array(0x0, 0x2FFFF, 0, 0xFFFF);
		$this->keyword = @mb_decode_numericentity($this->keyword, $convmap, "UTF-8");
		//echo "3";
		$j=-1;
		//Lấy keyword còn lại sau, bẻ dấu cách
		$array_temp = explode(" ",$this->keyword);

		for ($i=0;$i<count($array_temp);$i++){
			if (trim($array_temp[$i]) != ""){
				//Những keyword có độ dài > 1 mới cho vào array
				if (mb_strlen(trim($array_temp[$i]),"UTF-8") >1){
					$j++;
					$this->array_keyword[$j][0] = str_replace("'","''",trim($array_temp[$i]));
				}
			}	
		}
		
		$quorum			= count($array_temp) * 3/5;
		$quorum			= intval($quorum);
		if($quorum < 2) $quorum = 2;
		
		$this->keyword = trim($this->keyword);
		$this->original_keyword = $this->keyword;
		
		//echo $this->keyword;
		//Cấu hình sphinx tại localhost
		if (@$_SERVER['SERVER_NAME'] == "localhost"){
			$this->sphinx_host = "127.0.0.1";
			$this->sphinx_port = 9312;
		}
		//echo "3";
		//Khởi tạo class và mở kết nối đến server
		$this->sphinx = new SphinxClient();
		$this->sphinx->SetServer($this->sphinx_host, $this->sphinx_port);
		$this->sphinx->SetConnectTimeout(1.5);
		$this->sphinx->SetMatchMode(SPH_MATCH_ANY);
		//Lấy max 5030 kết quả trả về
		$this->sphinx->_maxmatches = 330;
		$this->sphinx->Open();
		//echo "4";
	}

    function set_filter($array_filter) {
        foreach($array_filter as $key => $value) {
            $this->array_filter[$key] = $value;
        }
    }

	/*
	Tìm kiếm để đưa ra data chính xác
	*/
	function search_data($page=1, $page_size=30){
		//Set array tra về là rỗng
		$this->array_data = array();

		//Reset để bỏ GroupBy
		$this->sphinx->ResetGroupBy();
				
		//phân trang
		//echo ($page-1) * $page_size;
		$this->sphinx->SetLimits(($page-1) * $page_size, $page_size);
		
		//Kiểu sort
		$sort_expr = "@weight";
		//Set Sort
		$this->sphinx->SetSortMode(SPH_SORT_EXPR, $sort_expr);

		//Set filter
        if($this->array_filter) {
            foreach($this->array_filter as $k=>$v) {
                $this->sphinx->SetFilter($k,$v);
            }
        }
		//Bắt đầu search
		$result = $this->sphinx->Query($this->keyword, $this->index_data);
        if($_SERVER['SERVER_NAME'] == 'localhost'){
            print_r($this->sphinx->GetLastError());
        }
//        echo '<pre>';
//        print_r($result);
//        echo '</pre>';
		//Nếu không trả lại đc kết quả
		if ($result === false){
			$this->savaErrorLog("Query failed (hoitraloi): " . $this->sphinx->GetLastError() . ".\n");
			//Return false luôn
			return false;
		}
		else{
			if ($this->sphinx->GetLastWarning()){
				//Dump ra cảnh báo
				$this->savaErrorLog("WARNING (hoitraloi): " . $this->sphinx->GetLastWarning() . "");
			}
			//print_r($result);
			if (!empty($result["matches"])){
				$this->total_found	= $result["total_found"];
				foreach ($result["matches"] as $doc => $docinfo) {
					//Thêm vào array trả về key = cat_id, value = count
					$this->array_data[$doc] = $doc;
				}//End foreach
				//tra ve ket qua list id 
				return $this->array_data;
			}//End if (!empty)
		}
		
		return array();
	}
	/*-----------Kết thúc search data--------*/
	

	
	/*
	Đóng kết nối với sphinx server
	*/
	function CloseConnection(){
		//Đóng kết nối
		$this->sphinx->Close();
	}
	
	/*
	Save error log
	*/
	function savaErrorLog($log_message){
		$filename = $_SERVER["DOCUMENT_ROOT"] . "/logs/sphinx_error.cfn";
		$handle = @fopen($filename, 'a');
		//Nếu handle chưa có mở thêm ../
		if (!$handle) $handle = @fopen("../" . $filename, 'a');
		//Nếu ko mở đc lần 2 thì return luôn
		if (!$handle) return;
		
		fwrite($handle, date("d/m/Y h:i:s A") . " " . $_SERVER['REMOTE_ADDR'] . " " . $_SERVER['SCRIPT_NAME'] . "?" . @$_SERVER['QUERY_STRING'] . "\n" . $log_message . "\n");
		fclose($handle);	
	}
}