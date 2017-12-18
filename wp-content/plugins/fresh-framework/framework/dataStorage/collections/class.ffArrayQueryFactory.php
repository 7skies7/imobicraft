<?php

class ffArrayQueryFactory extends ffFactoryAbstract {
	public function createArrayQuery( $data = null ) {
		$arrayQuery = new ffArrayQuery( $data );

		return $arrayQuery;
	}
}