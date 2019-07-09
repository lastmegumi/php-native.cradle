<?php
class Promotion extends _Model{
	public $id;
	public $type;
	public $value;
	public $target;
	public $target_value;
	public $name;
	public $description;
	public $start;
	public $end;
	public $target_limited;
	public $code;
	public $target_group;
	public $created;
	public $updated;
	public $status;
	public $priority;

	const _table = "promotion";

	static function discountValue(Product $p){
		$pro = Promotion::find([
								 'end'		=> ['gt'	=>	strtotime("now")],
								 'start'	=> ['st'	=>	strtotime("now")],
								 'status'	=>	['eq'	=>	1],
								 'store_id'	=>	['eq'	=>	$p->getStoreID()],
								 'target'		=> ['eq'	=>	1],
								 'priority'	=>	['gt'	=>	0],
								 'target_value'	=>	['lk'	=>	"%,".$p->id.",%"],
										],[
								 'order by'	=>	['priority ASC'],
									]);
		$dis = [];
		if($pro):
		switch ($pro->type) {
			case 1:
				$dis[]	=	$p->getOriginPrice() * floatval($pro->value);
				break;
			case 2:					
				$dis[]	=	floatval($pro->value);
				break;
			default:
				# code...
				break;
		}
		endif;

		if($p->category_ids):
			$filter = ['end'		=> ['gt'	=>	strtotime("now")],
					 'start'	=> ['st'	=>	strtotime("now")],
					 'status'	=>	['eq'	=>	1],
					 'store_id'	=>	['eq'	=>	$p->getStoreID()],
					 'target'		=> ['eq'	=>	2],
					 'target_value'	=>	['in'	=>	explode(',', $p->category_ids)],
					 'priority'	=>	['gt'	=>	0],	];
			$cat = Promotion::find($filter ,[
									 'order by'	=>	['priority ASC'],
										]);
			if($cat):
			switch ($cat->type) {
				case 1:
					$dis[]	=	$p->getOriginPrice() * floatval($cat->value);
					break;
				case 2:					
					$dis[]	=	floatval($cat->value);
					break;
				default:
					# code...
					break;
			}
			endif;
		endif;
		$dis[]	=	0;
		return max($dis);
	}

	function getName(){
		return $this->name? $this->name:"Default";
	}

	function getDescription(){
		return $this->description;
	}

	function getTarget(){
		switch ($this->target) {
			case 1:	return "Simple Product";
			case 2:	return "Category";
			case 3:	return "Store";
			default:
				return "N/A";
				break;
		}
	}

	function getTargetValue(){
		return $this->target_value;
	}

	function getType(){
		return $this->type;
	}

	function getValue(){
		return $this->value;
	}

	function getTypeName(){
		switch ($this->type) {
			case 1:	return "Persentage %";
			case 2:	return "Flat";
				break;
			
			default:
				# code...
				break;
		}
	}

	function getValueName(){
		switch ($this->type) {
				case 1:
					return intval($this->value * 100). '%';
				case 2:
					return Product::getCurrency() . $this->value;
						break;					
					default:
						# code...
						break;
				}		
	}

	function getStart(){
		return _T($this->start);
	}
	function getEnd(){
		return _T($this->end);
	}
	function getStatus(){
		switch($this->status){
			case 0:	return "Pending"; break;
			case 1:	return "Active"; break;
			case -1:	return "Disabled"; break;
			default: return "N/A"; break;
		}
	}

	function getPriority(){
		return $this->priority;
	}
}
?>