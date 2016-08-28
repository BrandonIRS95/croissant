<?php
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	require_once('user.php');
	
	class Conference extends Connection
	{
		//attributes
		private $id;
		private $title;
		private $type;
		private $description;
		private $dated;
		private $timed;
		private $user;
		private $place;
		private $room;
		private $id_event;
		//methods
		public function get_id() { return $this->id; }
		public function set_id($value) { $this->id = $value; }
		public function get_title() { return $this->title; }
		public function set_title($value) { $this->title = $value; }
		public function get_type() { return $this->type; }
		public function set_type($value) { $this->type = $value; }
		public function get_description() {return $this->description; }
		public function set_description($value) { $this->description = $value; }		
		public function get_date() {return $this->dated; }
		public function set_date($value) { $this->dated = $value; }		
		public function get_time() {return $this->timed; }
		public function set_time($value) { $this->timed = $value; }		
		public function get_place() {return $this->place; }
		public function set_place($value) { $this->place = $value; }		
		public function get_room() {return $this->room; }
		public function set_room($value) { $this->room = $value; }	
		public function get_user() {return $this->user; }
		public function set_user($value) { $this->user = $value; }
		public function get_id_event() { return $this->id_event; }
		public function set_id_event($value) { $this->id_event = $value; }
		//constructor
		function __construct()
		{
			//if no arguments received, create empty object
			if(func_num_args() == 0) 
			{
				$this->id = 0;
				$this->title = '';
				$this->type = '';
				$this->description = '';
				$this->timed = '';
				$this->dated='';
				$this->place='';
				$this->room='';
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
				$query = "SELECT Con_Id, Con_Title, Con_Type, Con_Description, con_date, con_Time, `Con_Place`, `Con_Room` FROM conference WHERE Con_Id = ?";
				//prepare command
				$command = parent::$connection->prepare($query);
				//link parameters
				$command->bind_param('i', $id);
				//execute command
				$command->execute();
				//link results to class attributes
				$command->bind_result($this->id, $this->title, $this->type, $this->description, $this->dated, $this->timed, $this->place, $this->room);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				parent::close_connection();
				//if not found throw exception
				if(!$found)throw(new RecordNotFoundException());	
			}
		}
		function get_Speaker()
		{
			//open connection to MySql
			parent::open_connection();
			//query
			$query = 'select Use_Id from users_conference where con_id = ? and Is_Speaker = 1';			
			//prepare command
			$command = parent::$connection->prepare($query);				
			//parameters
			$command->bind_param('i', $this->id);
			//execute command
			$command->execute();
			//link results
			$command->bind_result($user);
			//fetch data 					
			$found = $command -> fetch();
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//return user
			if($found)					
				$this->user = new User($user);				
			else
				throw(new RecordNotFoundException());
			return $user;
			
		}
		public function Add()
		{
			parent::open_connection();			
			$query = "INSERT INTO `conference`(`Con_Id`, `Con_Title`, `Con_Type`, `Con_Description`, `Con_Date`, `Con_Time`, `Con_Place`, `Con_Room`, `id_conference_event`) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?);";			
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssssssi', $this->title, $this->type, $this->description, $this->dated, $this->timed, $this->place, $this->room, $this->id_event);			
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
			$query = "delete from conference where Con_Id = ?";			
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
			$query = 'update conference set Con_Title = ?, Con_Type = ?, Con_Description= ?, con_time= ?, con_date= ? where Con_Id = ?';			
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssi', $this->title, $this->type, $this->description, $this->id, $this->timed, $this->dated);			
			$updated = $command->execute();
			mysqli_stmt_close($command);			
			parent::close_connection();			
			return $updated;
		}
		
		public function get_count_questions()
		{
			//open connection to MySql
			parent::open_connection();
			//query
			$query = "SELECT count( * ) AS total FROM questions WHERE Con_Id = ? AND Que_Status = 'p'";			
			//prepare command
			$command = parent::$connection->prepare($query);				
			//parameters
			$command->bind_param('i', $this->id);
			//execute command
			$command->execute();
			//link results
			$command->bind_result($count);
			//fetch data 					
			$found = $command -> fetch();
			//close command
			mysqli_stmt_close($command);
			//close connection
			parent::close_connection();
			//return user
			if(!$found)	throw(new RecordNotFoundException());
			return $count;
		}
			
	}
?>
