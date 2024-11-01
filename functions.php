<?php

class Comparaison {
    private $meta;
	
    function __construct($field, $criteria) {
        $this->field = $field;
        $this->criteria = $criteria;
    }

    function compare($a, $b) {
        return Compare($a, $b, $this->field, $this->criteria);
    }
}

function Compare($a, $b, $field, $criteria) {
	switch($criteria) {
		case 'alphabeticalasc':
			return (strtolower($a->$field) < strtolower($b->$field)) ? -1 : 1;
			break;
		case 'alphabeticaldesc':
			return (strtolower($a->$field) > strtolower($b->$field)) ? -1 : 1;
			break;
	}
}

?>