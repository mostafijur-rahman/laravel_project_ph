<?php 
namespace App\Http\Traits;
use App\Models\Accounts\AccountTransection;
use Auth;

trait AccountTransTrait{

	public function transaction($data){
		$transectionModel = new AccountTransection();
		$finalData = collect($data)
					->merge(['encrypt'=> uniqid(), 
						'created_by'=> Auth::user()->id,
						'status'=> 'active'])->toArray();
		$transection = $transectionModel->create($finalData);
		return $transection;
	}


	
	

}