<?php 
namespace App\Policy;

use Authorization\IdentityInterface;
use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;
class RequestPolicy implements RequestPolicyInterface
{
    /**
     * Method to check if the request can be accessed
     *
     * @param IdentityInterface|null Identity
     * @param ServerRequest $request Server Request
     * @return bool
     */
    public function canAccess($identity, ServerRequest $request)
    {
		echo '<pre>';
		var_dump('check');
		die;
		return true;
        $role = 0;
        if(!empty($identity)){
            $data = $identity->getOriginalData();
            $role = $data['role_id'];
        } 
         if(!empty($request->getParam('prefix'))){
            switch($request->getParam('prefix')){
                        case 'User' : return (bool)($role === 3);
                        case 'Admin': return (bool)($role === 1) || (bool)($role === 2);
                            
            }
            
         }else{
             return true;
         }
         
        return false;
        
    }
}