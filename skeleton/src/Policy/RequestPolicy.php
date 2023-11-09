<?php

namespace App\Policy;

use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;
use Authorization\IdentityInterface;
use Authorization\Policy\ResultInterface;

class RequestPolicy implements RequestPolicyInterface {
	/**
	 * Method to check if the request can be accessed
	 *
	 * @param \Authorization\IdentityInterface|null $identity Identity
	 * @param \Cake\Http\ServerRequest $request Server Request
	 * @return bool
	 */
	public function canAccess(?IdentityInterface $identity, ServerRequest $request): bool|ResultInterface {

		if ($request->getParam('plugin') === "Rhino") {
			if (empty($identity)) {
				if ($request->getParam('controller') !== "Users") {
					return false;
				}

				return $request->getParam('action') === "login";
			}

			return $identity->getOriginalData()->getSource() === "Rhino.Users";
		}

		return true;
	}
}
