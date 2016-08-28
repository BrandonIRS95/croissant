<?php	
	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	require_once('user.php');
	
	class ScoreToConference extends Connection
	{
		//attribute
		private $right_answers;
		private $user;
		private $best_time;
		private $worst_time;
		private $average_time;
		
		
		//methods
		public function get_right_answers() { return $this->right_answers;}
		public function set_right_answers($value) { $this->right_answers = $value; }			
		public function get_user() { return $this->user; }
		public function set_user($value) { $this->user = $value; }
		public function get_best_time() {return $this->best_time;}
		public function set_best_time($value) { $this->best_time = $value; }
		public function get_worst_time() {return $this->worst_time;}
		public function set_worst_time($value) { $this->worst_time = $value; }
		public function get_average_time() {return $this->average_time;}
		public function set_average_time($value) { $this->average_time = $value; }
		
		//Constructor
		function __construct()
		{
				//if no arguments received, create a new empty object
				if(func_num_args() == 0)
				{
					$this->user = new User();
					$this->right_answers = 0;
					$this->best_time = 0;
					$this->worst_time = 0;
					$this->average_time = 0;
					
				}
		}
	}
	
?>