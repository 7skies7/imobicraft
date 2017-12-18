<?php

class ffStopWatch {
	private static $_namedTime = null;
	private static $_currentTime = null;
	
	private static $_currentMem = null;
	private static $_namedMem = null;
	
	public static function memoryStart( $name = null ) {
		if( $name !== null ) {
			self::$_namedMem[ $name ] = memory_get_usage();
		} else {
			self::$_currentMem = memory_get_usage();
		}
	}
	
	public static function memoryEnd( $name = null ) {
		$end = memory_get_usage();
		if( $name !== null ) {
			$diff = $end - self::$_namedMem[ $name ];
		} else {
			$diff = $end - self::$_currentMem;
		}
		
		return $diff / 950000;
	}
	
	public static function memoryEndDump( $name = null ) {
		var_dump( self::memoryEnd($name ));
	}
	
	public static function timeStart( $name = null ) {
		if( $name !== null ) {
			self::$_namedTime[ $name ] = ff_microtime_float(); 
		} else {
			self::$_currentTime = ff_microtime_float();
		}
	}
	
	public static function timeEnd( $name = null ) {
		$end = ff_microtime_float();
		
		if( $name !== null  ) {
			$diff = $end - self::$_namedTime[ $name ];
		} else {
			$diff = $end - self::$_currentTime;
		}
		
		return $diff;
	}
	
	public static function timeEndDump( $name = null ) {
		$diff = self::timeEnd( $name );
		var_dump( $diff );
	}


	protected static $_variableDumps = array();

	protected static $_queryNotFoundDumps = array();

	public static function addVariableDumpString( $string ) {

		self::$_variableDumps[] = $string;
	}

	public static function addQueryNotFoundString( $string ) {
		self::$_queryNotFoundDumps[] = $string;
	}

	public static function getQueryNotFoundStrings(){
		return self::$_queryNotFoundDumps;
	}

	public static function resetQueryNotFoundStrings() {
		self::$_queryNotFoundDumps = array();
	}

	public static function dumpStart() {
		ob_start();
	}

	public static function dumpEnd() {
		$dump = ob_get_contents();
		ob_end_clean();

		self::$_variableDumps[] = $dump;
	}

	public static function addVariableDump( $variable ) {
		ob_start();
		var_dump( $variable );
		$dump = ob_get_contents();
		ob_end_clean();

		self::$_variableDumps[] = $dump;
	}

	public static function getVariableDumps() {
		return self::$_variableDumps;
	}

	public static function dumpVariables() {
		foreach( self::$_variableDumps as $oneVar ) {
			echo $oneVar;
		}

		foreach( self::$_queryNotFoundDumps as $oneVar ) {
			echo $oneVar;
		}
	}

}

function ff_microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

add_action('wp_footer', 'ff_print_developer_tools');

function ff_print_developer_tools() {
	if( defined( 'FF_DEVELOPER_MODE' ) && FF_DEVELOPER_MODE == true ) {
		$queryNotFound = ffStopWatch::getQueryNotFoundStrings();

		if( !empty( $queryNotFound ) ) {
			var_dump( $queryNotFound );
		}

//		$variableDumps = ffStopWatch::getVariableDumps();
//
//		if( !empty( $variableDumps ) ) {
//			var_dump( $variableDumps );
//		}
	}
}