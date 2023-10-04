<?php 
namespace App\Http\Traits;
use App\Models\Transections\Transection;
use Auth;

trait TransectionTrait{


	public function transaction($data){
		$transectionModel = new Transection();
		$finalData = collect($data)
					->merge([
						'encrypt'=> uniqid(), 
						'created_by'=> Auth::user()->id,
						'status'=> 'active'])->toArray();
		$transectionModel->create($finalData);
	}

	

}