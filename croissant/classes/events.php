<?php
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	require_once('theme.php');
	
	class Event extends Connection
	{
		//attributes
		private $id;
		private $name_of_event;
		private $description;
		private $logo_of_event;
		private $theme;
		private $admin_id;
		//methods
		public function get_id() { return $this->id; }
		public function set_id($value) { $this->id = $value; }
		public function get_name_of_event() { return $this->name_of_event; }
		public function set_name_of_event($value) { $this->name_of_event = $value; }
		public function get_description() {return $this->description; }
		public function set_description($value) { $this->description = $value; }		
		public function get_logo_of_event() {return $this->logo_of_event; }
		public function set_logo_of_event($value) { $this->logo_of_event = $value; }		
		public function get_theme() {return $this->theme; }
		public function set_theme($value) { $this->theme = $value; }	
		public function set_admin_id($value) { $this->admin_id = $value; }
		public function get_admin_id() { return $this->admin_id; }
		//constructor
		function __construct()
		{
			//if no arguments received, create empty object
			if(func_num_args() == 0) 
			{
				$this->id = 0;
				$this->name_of_event = '';
				$this->description = '';
				$this->logo_of_event = '';
				$this->theme = new Theme();
			}
			//if one argument received create object with data
			if(func_num_args() == 1)
			{
				//receive arguments into an array
				$args = func_get_args();
				//id
				$id = $args[0];
				//open connection to MySql
				parent::open_connection();
				//query
				$query = "SELECT `id_event`, `name_of_event`, `description`, `logo_of_event`, `id_theme_foreign` FROM `events` WHERE `id_event` = ?";
				//prepare command
				$command = parent::$connection->prepare($query);
				//link parameters
				$command->bind_param('i', $id);
				//execute command
				$command->execute();
				//link results to class attributes
				$command->bind_result($this->id, $this->name_of_event, $this->description, $this->logo_of_event, $idtheme);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if($found)					
					$this->theme = new Theme($idtheme);
				else
					throw(new RecordNotFoundException());	
			}
		}
	
		public function Add()
		{
			parent::open_connection();			
			$query = "INSERT INTO `events`(`id_event`, `name_of_event`, `description`, `logo_of_event`, `id_theme_foreign`) VALUES (null,?,?,?,?);";			
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssi', $this->name_of_event, $this->description, $this->logo_of_event, $this->theme->get_id());			
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
			$query = "DELETE FROM `events` WHERE where id_event = ?";			
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
			$query = 'UPDATE `events` SET `name_of_event`=?,`description`=?,`logo_of_event`=?,`id_theme_foreign`=?, `id_admin`=? WHERE id_event = ?';			
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssiii', $this->name_of_event, $this->description, $this->logo_of_event, $this->theme->get_id(), $this->admin_id, $this->id);			
			$updated = $command->execute();
			mysqli_stmt_close($command);			
			parent::close_connection();			
			return $updated;
		}
        
			
	}
?>
