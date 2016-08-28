<?php	
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	
	class Theme extends Connection
	{
		//attribute
        private $id;	
	    private $primary_color;	
        private $primary_dark_color;
        private $primary_light_color;	
        private $accent_color;
        private $icons_color;	
		
		//methods
		public function get_id() { return $this->id;}
		public function set_id($value) { $this->id = $value; }			
		public function get_primary_color() { return $this->primary_color; }
		public function set_primary_color($value) { $this->primary_color = $value; } 	
        public function get_primary_dark_color() { return $this->primary_dark_color; }
		public function set_primary_dark_color($value) { $this->primary_dark_color = $value; } 	
        public function get_primary_light_color() { return $this->primary_light_color; }
		public function set_primary_light_color($value) { $this->primary_light_color = $value; } 
        public function get_accent_color() { return $this->accent_color; }
		public function set_accent_color($value) { $this->accent_color = $value; } 
        public function get_icons_color() { return $this->icons_color; }
		public function set_icons_color($value) { $this->icons_color = $value; } 	
		
		//Constructor
		function __construct()
		{
			//if no arguments received, create a new empty object
			if(func_num_args() == 0)
			{
				$this->id = 0;				
				$this->type = '';
                $this->id = '';	
                $this->primary_color = '';	
                $this->primary_dark_color = '';
                $this->primary_light_color = '';	
                $this->accent_color = '';
                $this->icons_color = '';
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
				$query = "SELECT `id_theme`, `primary_color`, `primary_dark_color`, `primary_light_color`, `accent_color`, `icons_color` FROM `customtheme` WHERE `id_theme` = ?";
		
				//prepare command
				$command = parent::$connection ->prepare($query);
				//link parameters
				$command ->bind_param('i', $id); 
				//execute command				
				$command -> execute();
				//link results to class attributes
				$command -> bind_result($this->id, $this->primary_color, $this->primary_dark_color, $this->primary_light_color, $this->accent_color, $this->icons_color); 
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
        
        public function Add()
		{
			parent::open_connection();			
			$query = "INSERT INTO `customtheme`(`id_theme`, `primary_color`, `primary_dark_color`, `primary_light_color`, `accent_color`, `icons_color`) VALUES (null,?,?,?,?,?);";			
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssss', $this->primary_color, $this->primary_dark_color, $this->primary_light_color, $this->accent_color, $this->icons_color);			
			$added = $command->execute();
			$id = $command->insert_id;
			$this->id = $id;
			mysqli_stmt_close($command);			
			parent::close_connection();			
			return $added;
		}		
		public function Deleted()
		{
			parent::open_connection();			
			$query = "delete from `customtheme` where `id_theme` = ?";			
			$command = parent::$connection->prepare($query);
			$command->bind_param('i', $this->id);			
			$deleted = $command->execute();
			mysqli_stmt_close($command);			
			parent::close_connection();			
			return $deleted;
		}		
		public function Update()
		{
			parent::open_connection();			
			$query = "UPDATE `customtheme` SET `primary_color`=?,`primary_dark_color`=?,`primary_light_color`=?,`accent_color`=?,`icons_color`=? WHERE `id_theme` = ?";			
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssssi', $this->primary_color, $this->primary_dark_color, $this->primary_light_color, $this->accent_color, $this->icons_color, $this->id);		
			$updated = $command->execute();
			mysqli_stmt_close($command);			
			parent::close_connection();			
			return $updated;
		}
        
        
	}
?>