<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Movies Model
 *
 * @method \App\Model\Entity\Movie get($primaryKey, $options = [])
 * @method \App\Model\Entity\Movie newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Movie[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Movie|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Movie saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Movie patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Movie[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Movie findOrCreate($search, callable $callback = null, $options = [])
 */
class MoviesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('movies');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('link')
            ->maxLength('link', 1000)
            ->requirePresence('link', 'create')
            ->notEmptyString('link');

        $validator
            ->scalar('title')
            ->maxLength('title', 1000)
            ->requirePresence('title', 'create')
            ->allowEmpty('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 5000)
            ->requirePresence('description', 'create')
            ->allowEmpty('description');

        $validator
            ->scalar('channel_title')
            ->maxLength('channel_title', 1000)
            ->requirePresence('channel_title', 'create')
            ->allowEmpty('channel_title');

        $validator
            ->integer('view_count')
            ->requirePresence('view_count', 'create')
            ->allowEmpty('view_count');

        $validator
            ->integer('like_count')
            ->requirePresence('like_count', 'create')
            ->allowEmpty('like_count');

        $validator
            ->integer('dislike_count')
            ->requirePresence('dislike_count', 'create')
            ->allowEmpty('dislike_count');

        $validator
            ->integer('comment_count')
            ->requirePresence('comment_count', 'create')
            ->allowEmpty('comment_count');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->notEmptyDateTime('updated_at');

        $validator
            ->scalar('group_name')
            ->maxLength('group_name', 1000)
            ->requirePresence('group_name', 'create')
            ->allowEmpty('group_name');

        return $validator;
    }
}
