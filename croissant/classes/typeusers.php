<?php	
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	
	class Type extends Connection
	{
		//attribute
		private $id;		
		private $type;
		
		//methods
		public function get_id() { return $this->id;}
		public function set_id($value) { $this->id = $value; }			
		public function get_type() { return $this->type; }
		public function set_type($value) { $this->type = $value; } 	
		
		//Constructor
		function __construct()
		{
			//if no arguments received, create a new empty object
			if(func_num_args() == 0)
			{
				$this->id = 0;				
				$this->type = '';
			}			
			//if one argument received create object with data
			if(func_num_args() == 1)
			{				
				//receive arguments into an array
				$args = func_get_args();
				//id
				$id = $args[0];				
				//open connection to MySQL
				parent::open_connection();
				//query
				$query = "select Type_Id, Type_User from typeuser where Type_Id = ?";
				//prepare command
				$command = parent::$connection ->prepare($query);
				//link parameters
				$command ->bind_param('i', $id); 
				//execute command				
				$command -> execute();
				//link results to class attributes
				$command -> bind_result($this->id, $this->type); 
				//fetch data 					
				$found = $command->fetch();
				//close command 
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if(!$found) throw(new RecordNotFoundException());
			}			
		}
	}
?>

