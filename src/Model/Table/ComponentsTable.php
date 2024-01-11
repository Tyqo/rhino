<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Rhino\Model\Table\NodesTable;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;

class ComponentsTable extends NodesTable {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);
    }

	public function getEntry(int $id = null): object {
		if (!empty($id)) {
			return $this->get($id);
		}
		
		return $this->newEmptyEntity();
	}
}